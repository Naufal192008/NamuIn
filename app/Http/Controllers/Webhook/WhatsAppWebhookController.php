<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Tamu;
use App\Models\Booking;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    protected WhatsAppService $waService;

    public function __construct(WhatsAppService $waService)
    {
        $this->waService = $waService;
    }

    /**
     * Handle incoming Fonnte webhook request.
     */
    public function handleWebhook(Request $request)
    {
        $senderRaw = $request->input('sender');
        $message = trim($request->input('message', ''));

        if (empty($senderRaw) || empty($message)) {
            return response()->json(['status' => false, 'message' => 'Sender or message empty.'], 400);
        }

        // Normalize sender number to format 62xxx
        $sender = preg_replace('/\D/', '', $senderRaw);
        if (str_starts_with($sender, '0')) {
            $sender = '62' . substr($sender, 1);
        }

        Log::info("WA webhook received from: {$sender}, Message: '{$message}'");

        // Find employee (Pegawai) matching this sender number
        $pegawai = Pegawai::all()->first(function ($p) use ($sender) {
            return $p->nomorWaFormatted === $sender;
        });

        if (!$pegawai) {
            Log::warning("WA Webhook: Sender {$sender} is not associated with any school staff member.");
            return response()->json(['status' => false, 'message' => 'Sender not found.'], 404);
        }

        // 1. Check for Booking Approval Commands (SETUJU NMU-XXXXX / BATAL NMU-XXXXX)
        $matchesSetuju = [];
        $matchesBatal = [];
        
        if (preg_match('/setuju\s+(NMU-[A-Z0-9]+)/i', $message, $matchesSetuju)) {
            $bookingCode = strtoupper($matchesSetuju[1]);
            $booking = Booking::where('booking_code', $bookingCode)->first();

            if (!$booking) {
                $this->waService->kirimPesan($pegawai->no_wa, "⚠️ *NamuIn Info*\n\nKode Booking *{$bookingCode}* tidak ditemukan.");
                return response()->json(['status' => false, 'message' => 'Booking code not found.'], 200);
            }

            if ($booking->bertemu_dengan !== $pegawai->id) {
                $this->waService->kirimPesan($pegawai->no_wa, "⚠️ *NamuIn Info*\n\nAnda tidak memiliki otorisasi untuk menyetujui Booking *{$bookingCode}*.");
                return response()->json(['status' => false, 'message' => 'Unauthorized booking approval.'], 200);
            }

            $booking->update(['status' => 'Disetujui']);

            // Notify guest
            if (!empty($booking->no_wa)) {
                $formattedDate = $booking->tanggal_booking->format('d-m-Y');
                $pesanGuest = implode("\n", [
                    "💬 *NamuIn - Konfirmasi Janji Temu*",
                    "",
                    "Halo *{$booking->nama_tamu}*,",
                    "Janji temu Anda dengan Bapak/Ibu *{$pegawai->nama}* telah *DISETUJUI*.",
                    "",
                    "🗓️ *Tanggal:* {$formattedDate}",
                    "🕐 *Waktu:* {$booking->jam_booking} WIB",
                    "🔑 *Kode Booking:* *{$bookingCode}*",
                    "",
                    "Silakan tunjukkan/masukkan Kode Booking di atas pada layar Lobi saat Anda tiba untuk check-in instan. Terima kasih.",
                ]);
                $this->waService->kirimPesan($booking->no_wa, $pesanGuest);
            }

            // Notify staff
            $this->waService->kirimPesan($pegawai->no_wa, "✅ *Konfirmasi Berhasil*\n\nJanji temu dengan tamu *{$booking->nama_tamu}* pada {$booking->tanggal_booking->format('d-m-Y')} pukul {$booking->jam_booking} telah disetujui. Kode booking *{$bookingCode}* telah dikirimkan ke tamu.");

            return response()->json(['status' => true, 'message' => 'Booking approved successfully.']);
        }

        if (preg_match('/batal\s+(NMU-[A-Z0-9]+)/i', $message, $matchesBatal)) {
            $bookingCode = strtoupper($matchesBatal[1]);
            $booking = Booking::where('booking_code', $bookingCode)->first();

            if (!$booking) {
                $this->waService->kirimPesan($pegawai->no_wa, "⚠️ *NamuIn Info*\n\nKode Booking *{$bookingCode}* tidak ditemukan.");
                return response()->json(['status' => false, 'message' => 'Booking code not found.'], 200);
            }

            if ($booking->bertemu_dengan !== $pegawai->id) {
                $this->waService->kirimPesan($pegawai->no_wa, "⚠️ *NamuIn Info*\n\nAnda tidak memiliki otorisasi untuk membatalkan Booking *{$bookingCode}*.");
                return response()->json(['status' => false, 'message' => 'Unauthorized booking cancellation.'], 200);
            }

            $booking->update(['status' => 'Ditolak']);

            // Notify guest
            if (!empty($booking->no_wa)) {
                $pesanGuest = implode("\n", [
                    "💬 *NamuIn - Pembatalan Janji Temu*",
                    "",
                    "Halo *{$booking->nama_tamu}*,",
                    "Mohon maaf, janji temu Anda dengan Bapak/Ibu *{$pegawai->nama}* pada {$booking->tanggal_booking->format('d-m-Y')} pukul {$booking->jam_booking} WIB telah *DITOLAK/DIBATALKAN*.",
                ]);
                $this->waService->kirimPesan($booking->no_wa, $pesanGuest);
            }

            // Notify staff
            $this->waService->kirimPesan($pegawai->no_wa, "✅ *Konfirmasi Berhasil*\n\nJanji temu dengan tamu *{$booking->nama_tamu}* telah berhasil dibatalkan.");

            return response()->json(['status' => true, 'message' => 'Booking cancelled successfully.']);
        }

        // 2. Find latest active tamu (status Menunggu or Sedang Ditemui) for this employee
        $tamu = Tamu::where('bertemu_dengan', $pegawai->id)
            ->whereIn('status', ['Menunggu', 'Sedang Ditemui'])
            ->orderBy('jam_masuk', 'desc')
            ->first();

        if (!$tamu) {
            Log::info("WA Webhook: Staff {$pegawai->nama} has no active guests waiting.");
            $this->waService->kirimPesan($pegawai->no_wa, "⚠️ *NamuIn Info*\n\nAnda tidak memiliki kunjungan tamu aktif yang sedang menunggu respon saat ini.");
            return response()->json(['status' => false, 'message' => 'No active guests for this staff.'], 200);
        }

        $msgClean = strtolower($message);
        $statusChanged = false;
        $tamuName = $tamu->nama_tamu;

        // Parse option
        if ($msgClean === '1' || $msgClean === 'ok' || $msgClean === 'temui') {
            // Option 1: Temui Tamu
            $tamu->update(['status' => 'Sedang Ditemui']);
            $statusChanged = true;

            // Notify staff member
            $this->waService->kirimPesan($pegawai->no_wa, "✅ *Konfirmasi Berhasil*\n\nStatus tamu *{$tamuName}* telah diubah menjadi *Sedang Ditemui*. Selamat berdiskusi.");

            // Notify guest with self-checkout link
            if (!empty($tamu->no_wa)) {
                $checkoutUrl = route('checkout.direct', $tamu->id);
                $pesanTamu = implode("\n", [
                    "💬 *NamuIn - Info Sekolah*",
                    "",
                    "Halo *{$tamuName}*,",
                    "Bapak/Ibu *{$pegawai->nama}* sedang menuju ke Lobi untuk menemui Anda. Silakan menunggu di area ruang tamu.",
                    "",
                    "Setelah kunjungan selesai, mohon check-out mandiri melalui tautan berikut:",
                    "👉 {$checkoutUrl}",
                    "",
                    "Terima kasih.",
                ]);
                $this->waService->kirimPesan($tamu->no_wa, $pesanTamu);
            }
        } elseif ($msgClean === '2' || str_contains($msgClean, 'tunda') || str_contains($msgClean, 'tunggu')) {
            // Option 2: Tunda
            $tamu->update(['status' => 'Menunggu']); // Stay waiting
            $statusChanged = true;

            // Notify staff member
            $this->waService->kirimPesan($pegawai->no_wa, "✅ *Konfirmasi Berhasil*\n\nPesan agar menunggu telah dikirimkan kepada tamu *{$tamuName}*.");

            // Notify guest with self-checkout link
            if (!empty($tamu->no_wa)) {
                $checkoutUrl = route('checkout.direct', $tamu->id);
                $pesanTamu = implode("\n", [
                    "💬 *NamuIn - Info Sekolah*",
                    "",
                    "Halo *{$tamuName}*,",
                    "Bapak/Ibu *{$pegawai->nama}* saat ini sedang menyelesaikan kegiatan. Beliau memohon kesediaan Anda untuk menunggu sebentar.",
                    "",
                    "Setelah kunjungan selesai, mohon check-out mandiri melalui tautan berikut:",
                    "👉 {$checkoutUrl}",
                    "",
                    "Terima kasih.",
                ]);
                $this->waService->kirimPesan($tamu->no_wa, $pesanTamu);
            }
        } elseif ($msgClean === '3' || str_contains($msgClean, 'sibuk') || str_contains($msgClean, 'tolak')) {
            // Option 3: Sibuk / Batalkan
            $tamu->update([
                'status' => 'Selesai',
                'jam_pulang' => now()
            ]);
            $statusChanged = true;

            // Notify staff member
            $this->waService->kirimPesan($pegawai->no_wa, "✅ *Konfirmasi Berhasil*\n\nKunjungan tamu *{$tamuName}* telah diselesaikan. Pesan pemberitahuan telah dikirimkan.");

            // Notify guest
            if (!empty($tamu->no_wa)) {
                $pesanTamu = "💬 *NamuIn - Info Sekolah*\n\nHalo *{$tamuName}*,\nMohon maaf, Bapak/Ibu *{$pegawai->nama}* saat ini sedang memiliki rapat/kegiatan penting yang mendesak sehingga tidak dapat menemui Anda hari ini. Silakan hubungi kembali di lain waktu atau melapor ke Resepsionis. Terima kasih.";
                $this->waService->kirimPesan($tamu->no_wa, $pesanTamu);
            }
        } else {
            // Unrecognized option
            $reply = implode("\n", [
                "⚠️ *Pesan Tidak Dikenali*",
                "",
                "Ketik balasan dengan format:",
                "👉 *1* atau *OK* : Temui tamu sekarang.",
                "👉 *2* atau *TUNDA* : Minta tamu menunggu sebentar.",
                "👉 *3* atau *SIBUK* : Sedang sibuk, batalkan kunjungan.",
            ]);
            $this->waService->kirimPesan($pegawai->no_wa, $reply);
            return response()->json(['status' => false, 'message' => 'Unrecognized reply keyword.'], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Webhook processed successfully.',
            'status_changed' => $statusChanged,
            'new_status' => $tamu->status
        ]);
    }

    public function simulator()
    {
        $pegawais = Pegawai::where('aktif', true)->orderBy('nama')->get();
        
        // Find latest check-in guests
        $activeGuests = Tamu::with('pegawaiTujuan')
            ->whereIn('status', ['Menunggu', 'Sedang Ditemui'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Find active bookings (Diajukan)
        $activeBookings = Booking::with('pegawaiTujuan')
            ->where('status', 'Diajukan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.whatsapp-simulator', compact('pegawais', 'activeGuests', 'activeBookings'));
    }

    /**
     * Post simulation to webhook.
     */
    public function simulateWebhook(Request $request)
    {
        $request->validate([
            'sender' => 'required',
            'message' => 'required|string',
        ]);

        // Trigger local controller method directly
        $subRequest = Request::create('/webhook/whatsapp', 'POST', [
            'sender' => $request->sender,
            'message' => $request->message
        ]);

        $response = $this->handleWebhook($subRequest);

        return back()->with([
            'success' => 'Simulasi webhook berhasil dipicu!',
            'sim_status' => $response->getStatusCode(),
            'sim_response' => json_decode($response->getContent(), true)
        ]);
    }
}
