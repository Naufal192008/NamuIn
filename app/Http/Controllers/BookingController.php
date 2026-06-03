<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\KategoriTamu;
use App\Models\Pegawai;
use App\Models\Tamu;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    protected WhatsAppService $waService;

    public function __construct(WhatsAppService $waService)
    {
        $this->waService = $waService;
    }

    /**
     * Show the public booking form.
     */
    public function showBookingForm()
    {
        $kategoris = KategoriTamu::orderBy('nama_kategori')->get();
        $pegawais  = Pegawai::where('aktif', true)->orderBy('nama')->get();
        return view('publik.booking', compact('kategoris', 'pegawais'));
    }

    /**
     * Store public booking request.
     */
    public function storeBooking(Request $request)
    {
        // Honeypot check
        if ($request->filled('secondary_phone')) {
            Log::warning("Spam booking request blocked by Honeypot trap.");
            return redirect()->route('booking.form')->with('success', 'Janji temu berhasil diajukan! Harap menunggu konfirmasi WhatsApp.');
        }

        $request->validate([
            'nama_tamu'        => 'required|string|max:100',
            'instansi'         => 'required|string|max:100',
            'no_wa'            => 'required|string|max:20',
            'kategori_id'      => 'required|exists:kategori_tamu,id',
            'bertemu_dengan'   => 'required|exists:pegawai,id',
            'tujuan_kunjungan' => 'required|string|max:150',
            'tanggal_booking'  => 'required|date|after_or_equal:today',
            'jam_booking'      => 'required|string',
            'detail_keperluan' => 'nullable|string|max:500',
        ], [
            'nama_tamu.required'        => 'Nama lengkap wajib diisi.',
            'instansi.required'         => 'Asal instansi wajib diisi.',
            'no_wa.required'            => 'Nomor WhatsApp wajib diisi.',
            'kategori_id.required'      => 'Pilih kategori kunjungan.',
            'bertemu_dengan.required'   => 'Pilih staf yang ingin ditemui.',
            'tujuan_kunjungan.required' => 'Tujuan kunjungan wajib diisi.',
            'tanggal_booking.required'  => 'Pilih tanggal kunjungan.',
            'jam_booking.required'      => 'Pilih jam kunjungan.',
        ]);

        // Generate clean unique booking code: NMU-XXXXXX
        $code = 'NMU-' . strtoupper(Str::random(5));
        while (Booking::where('booking_code', $code)->exists()) {
            $code = 'NMU-' . strtoupper(Str::random(5));
        }

        $booking = Booking::create([
            'nama_tamu'        => $request->nama_tamu,
            'instansi'         => $request->instansi,
            'no_wa'            => $request->no_wa,
            'kategori_id'      => $request->kategori_id,
            'bertemu_dengan'   => $request->bertemu_dengan,
            'tujuan_kunjungan' => $request->tujuan_kunjungan,
            'tanggal_booking'  => $request->tanggal_booking,
            'jam_booking'      => $request->jam_booking,
            'detail_keperluan' => $request->detail_keperluan,
            'booking_code'     => $code,
            'status'           => 'Diajukan',
        ]);

        // Notify employee (Pegawai) via WhatsApp
        $pegawai = Pegawai::find($request->bertemu_dengan);
        if ($pegawai && !empty($pegawai->no_wa)) {
            $keperluan = $request->detail_keperluan ?: '-';
            $formattedDate = date('d-m-Y', strtotime($request->tanggal_booking));
            
            $msg = implode("\n", [
                "🔔 *Pengajuan Janji Temu (NamuIn)*",
                "",
                "Halo, *{$pegawai->nama}*!",
                "Ada pengajuan janji temu baru yang meminta kehadiran Anda.",
                "",
                "👤 *Nama Tamu:* {$request->nama_tamu}",
                "🏢 *Asal Instansi:* {$request->instansi}",
                "🗓️ *Tanggal:* {$formattedDate}",
                "🕐 *Waktu:* {$request->jam_booking} WIB",
                "🎯 *Tujuan:* {$request->tujuan_kunjungan}",
                "📝 *Keperluan:* {$keperluan}",
                "",
                "Balas pesan ini untuk memproses:",
                "👉 Ketik *SETUJU {$code}* : Setujui janji temu.",
                "👉 Ketik *BATAL {$code}* : Tolak/batalkan janji temu.",
                "",
                "_Sistem Layanan Tamu *NamuIn*_",
            ]);

            $this->waService->kirimPesan($pegawai->no_wa, $msg);
        }

        return redirect()->route('booking.form')->with('success', 'Janji temu berhasil diajukan! Silakan menunggu persetujuan staf via WhatsApp.');
    }

    /**
     * Process check-in using Booking Code in school lobby.
     */
    public function checkinWithCode(Request $request)
    {
        // Honeypot check
        if ($request->filled('secondary_phone')) {
            Log::warning("Spam booking check-in blocked by Honeypot trap.");
            return redirect('/')->with('success', 'Check-in Booking berhasil dicatat! Silakan menunggu.');
        }

        $request->validate([
            'booking_code' => 'required|string',
        ], [
            'booking_code.required' => 'Masukkan Kode Booking Anda.',
        ]);

        $code = trim(strtoupper($request->booking_code));

        $booking = Booking::where('booking_code', $code)->first();

        if (!$booking) {
            return back()->with('error', 'Kode Booking tidak ditemukan. Pastikan Anda memasukkan kode dengan benar.');
        }

        if ($booking->status === 'Checkin') {
            return back()->with('error', 'Kode Booking ini sudah digunakan untuk check-in.');
        }

        if ($booking->status !== 'Disetujui') {
            return back()->with('error', 'Kode Booking belum disetujui atau sudah dibatalkan oleh staf yang dituju.');
        }

        // Auto-check in guest
        $tamu = Tamu::create([
            'nama_tamu'        => $booking->nama_tamu,
            'instansi'         => $booking->instansi,
            'no_wa'            => $booking->no_wa,
            'kategori_id'      => $booking->kategori_id,
            'bertemu_dengan'   => $booking->bertemu_dengan,
            'tujuan_kunjungan' => $booking->tujuan_kunjungan,
            'detail_keperluan' => $booking->detail_keperluan,
            'sudah_janji'      => true,
            'status'           => 'Menunggu',
        ]);

        // Update booking status
        $booking->update(['status' => 'Checkin']);

        // Notify staff via WhatsApp that guest has arrived in lobby
        $pegawai = $booking->pegawaiTujuan;
        if ($pegawai && !empty($pegawai->no_wa)) {
            $msg = implode("\n", [
                "🔔 *Tamu Janji Temu Telah Hadir*",
                "",
                "Halo, *{$pegawai->nama}*!",
                "Tamu janji temu Anda telah tiba di Lobi Sekolah.",
                "",
                "👤 *Nama:* {$booking->nama_tamu}",
                "🏢 *Dari:* {$booking->instansi}",
                "🕐 *Waktu Check-In:* " . now()->format('H:i') . " WIB",
                "",
                "Harap segera menemui tamu Anda di ruang lobi resepsionis.",
                "",
                "_Sistem Layanan Tamu *NamuIn*_",
            ]);
            $this->waService->kirimPesan($pegawai->no_wa, $msg);
        }

        return redirect('/')->with('success', 'Terima kasih! Check-in menggunakan Booking Code berhasil dicatat. Silakan menunggu dipanggil.');
    }
}
