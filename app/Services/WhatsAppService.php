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

    public function kirimNotifikasiTamu(Tamu $tamu): bool
    {
        if (empty($this->token) || !config('services.fonnte.enabled', false)) {
            Log::info('WA notification skipped: Fonnte disabled or no token.');
            return false;
        }

        $pegawai = $tamu->pegawaiTujuan;
        if (!$pegawai || empty($pegawai->no_wa)) {
            Log::warning("WA notif: Pegawai not found or no WA number for tamu #{$tamu->id}");
            return false;
        }

        $pesan = $this->buildMessage($tamu, $pegawai->nama);

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post($this->baseUrl, [
                'target'  => $pegawai->nomorWaFormatted,
                'message' => $pesan,
                'typing'  => false,
                'delay'   => 1,
            ]);

            if ($response->successful() && ($response->json('status') === true || $response->json('status') === 'true')) {
                $tamu->update(['wa_sent_at' => now()]);
                Log::info("WA notif sent to {$pegawai->nama} ({$pegawai->nomorWaFormatted}) for tamu #{$tamu->id}");
                return true;
            }

            Log::error("WA notif failed: " . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error("WA notif exception: " . $e->getMessage());
            return false;
        }
    }

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
            "Silakan menuju resepsionis untuk menemui tamu Anda.",
            "",
            "_Pesan ini dikirim otomatis oleh sistem *NamuIn*_",
        ]);
    }
}
