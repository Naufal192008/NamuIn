<?php

namespace App\Services;

use App\Models\Tamu;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private string $token;
    private string $baseUrl = 'https://api.fonnte.com/send';

    public function __construct()
    {
        $this->token = config('services.fonnte.token', '');
    }

    /**
     * Send a generic WhatsApp message.
     */
    public function kirimPesan(string $to, string $pesan): bool
    {
        // Format number if starts with 0
        $cleanNumber = preg_replace('/\D/', '', $to);
        if (str_starts_with($cleanNumber, '0')) {
            $cleanNumber = '62' . substr($cleanNumber, 1);
        }

        if (empty($this->token) || !config('services.fonnte.enabled', false)) {
            Log::info("=== MOCK WHATSAPP MESSAGE ===\nTo: {$cleanNumber}\nMessage:\n{$pesan}\n=============================");
            return true; // Return true in mock mode so simulation flow proceeds
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post($this->baseUrl, [
                'target'  => $cleanNumber,
                'message' => $pesan,
                'typing'  => false,
                'delay'   => 1,
            ]);

            if ($response->successful() && ($response->json('status') === true || $response->json('status') === 'true')) {
                Log::info("WA message successfully sent to {$cleanNumber}");
                return true;
            }

            Log::error("WA message send failed to {$cleanNumber}: " . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error("WA message exception for {$cleanNumber}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send initial guest check-in alert to an employee.
     */
    public function kirimNotifikasiTamu(Tamu $tamu): bool
    {
        $pegawai = $tamu->pegawaiTujuan;
        if (!$pegawai || empty($pegawai->no_wa)) {
            Log::warning("WA notif: Pegawai not found or has no WA number for tamu #{$tamu->id}");
            return false;
        }

        $pesan = $this->buildMessage($tamu, $pegawai->nama);

        $success = $this->kirimPesan($pegawai->no_wa, $pesan);
        if ($success) {
            $tamu->update(['wa_sent_at' => now()]);
        }

        return $success;
    }

    /**
     * Build the WhatsApp notification text body.
     */
    private function buildMessage(Tamu $tamu, string $namaPegawai): string
    {
        $waktu     = $tamu->jam_masuk->format('H:i') . ' WIB';
        $kategori  = $tamu->kategori?->nama_kategori ?? 'Umum';
        $keperluan = $tamu->detail_keperluan ?: '-';

        return implode("\n", [
            "🔔 *Ada Tamu yang Mencari Anda*",
            "",
            "Halo, *{$namaPegawai}*!",
            "Seorang tamu telah check-in dan ingin bertemu dengan Anda.",
            "",
            "👤 *Nama:* {$tamu->nama_tamu}",
            "🏢 *Dari:* {$tamu->instansi} ({$kategori})",
            "📞 *WA:* {$tamu->no_wa}",
            "🎯 *Tujuan:* {$tamu->tujuan_kunjungan}",
            "📝 *Keperluan:* {$keperluan}",
            "🕐 *Waktu Masuk:* {$waktu}",
            "",
            "Balas pesan ini dengan angka/kata kunci berikut untuk merespons:",
            "👉 Ketik *1* atau *OK* : Temui tamu sekarang.",
            "👉 Ketik *2* atau *TUNDA* : Minta tamu menunggu sebentar.",
            "👉 Ketik *3* atau *SIBUK* : Sedang sibuk, batalkan kunjungan.",
            "",
            "_Pesan ini dikirim otomatis oleh sistem *NamuIn*_",
        ]);
    }
}
