<?php

namespace App\Http\Controllers;

use App\Models\KategoriTamu;
use App\Models\Pegawai;
use App\Models\Tamu;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class TamuPublikController extends Controller
{
    public function index()
    {
        $kategoris = KategoriTamu::orderBy('nama_kategori')->get();
        $pegawais  = Pegawai::where('aktif', true)->orderBy('nama')->get();
        return view('publik.form', compact('kategoris', 'pegawais'));
    }

    public function store(Request $request)
    {
        // Honeypot check
        if ($request->filled('secondary_phone')) {
            \Illuminate\Support\Facades\Log::warning("Spam check-in blocked by Honeypot trap.");
            return redirect('/')->with('success', 'Terima kasih! Check-in Anda berhasil dicatat. Silakan menunggu dipanggil.');
        }

        $request->validate([
            'nama_tamu'        => 'required|string|max:100',
            'instansi'         => 'required|string|max:100',
            'no_wa'            => 'required|string|max:20',
            'kategori_id'      => 'required|exists:kategori_tamu,id',
            'tujuan_kunjungan' => 'required|string|max:150',
            'bertemu_dengan'   => 'nullable|exists:pegawai,id',
            'detail_keperluan' => 'nullable|string|max:500',
            'sudah_janji'      => 'nullable|boolean',
        ], [
            'nama_tamu.required'        => 'Nama lengkap wajib diisi.',
            'instansi.required'         => 'Asal instansi wajib diisi.',
            'no_wa.required'            => 'Nomor WhatsApp wajib diisi.',
            'kategori_id.required'      => 'Pilih kategori kunjungan.',
            'tujuan_kunjungan.required' => 'Tujuan kunjungan wajib diisi.',
        ]);

        $tamu = Tamu::create([
            'nama_tamu'        => $request->nama_tamu,
            'instansi'         => $request->instansi,
            'no_wa'            => $request->no_wa,
            'kategori_id'      => $request->kategori_id,
            'tujuan_kunjungan' => $request->tujuan_kunjungan,
            'bertemu_dengan'   => $request->bertemu_dengan ?: null,
            'detail_keperluan' => $request->detail_keperluan,
            'sudah_janji'      => $request->boolean('sudah_janji'),
            'status'           => 'Menunggu',
        ]);

        if ($tamu->bertemu_dengan) {
            $tamu->load('pegawaiTujuan.kategori');
            app(WhatsAppService::class)->kirimNotifikasiTamu($tamu);
        }

        return redirect('/')->with('success', 'Terima kasih! Check-in Anda berhasil dicatat. Silakan menunggu dipanggil.');
    }

    public function display()
    {
        $checkinUrl = url('/?from=qr');
        return view('publik.display', compact('checkinUrl'));
    }

    public function liveFeed()
    {
        $today = today();
        $total = Tamu::whereDate('jam_masuk', $today)->count();
        $recent = Tamu::whereDate('jam_masuk', $today)
            ->orderBy('jam_masuk', 'desc')
            ->limit(3)
            ->get()
            ->map(function ($t) {
                return [
                    'nama' => $t->nama_tamu,
                    'instansi' => $t->instansi,
                    'jam' => $t->jam_masuk->format('H:i')
                ];
            });

        return response()->json([
            'total' => $total,
            'recent' => $recent
        ]);
    }

    public function showCheckoutForm()
    {
        return view('publik.checkout');
    }

    public function checkoutByNameOrPhone(Request $request)
    {
        // Honeypot check
        if ($request->filled('secondary_phone')) {
            \Illuminate\Support\Facades\Log::warning("Spam check-out blocked by Honeypot trap.");
            return redirect()->route('home')->with('success', 'Terima kasih! Check-out Anda berhasil dicatat.');
        }

        $request->validate([
            'no_wa' => 'required|string|max:20',
        ], [
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
        ]);

        $noWa = trim($request->no_wa);
        $cleanNumber = preg_replace('/\D/', '', $noWa);
        if (str_starts_with($cleanNumber, '0')) {
            $cleanNumber = '62' . substr($cleanNumber, 1);
        }

        $tamu = Tamu::whereDate('jam_masuk', today())
            ->whereIn('status', ['Menunggu', 'Sedang Ditemui'])
            ->get()
            ->first(function ($t) use ($cleanNumber, $noWa) {
                $tamuWa = preg_replace('/\D/', '', $t->no_wa);
                if (str_starts_with($tamuWa, '0')) {
                    $tamuWa = '62' . substr($tamuWa, 1);
                }
                return $tamuWa === $cleanNumber || $t->no_wa === $noWa;
            });

        if (!$tamu) {
            return back()->with('error', 'Kunjungan aktif tidak ditemukan untuk nomor WhatsApp ini hari ini. Pastikan Anda telah melakukan check-in.');
        }

        $tamu->update([
            'status' => 'Selesai',
            'jam_pulang' => now()
        ]);

        return redirect()->route('checkout.success', $tamu->id);
    }

    public function directCheckout(Tamu $tamu)
    {
        if ($tamu->status !== 'Selesai') {
            $tamu->update([
                'status' => 'Selesai',
                'jam_pulang' => now()
            ]);
        }

        return redirect()->route('checkout.success', $tamu->id);
    }

    public function checkoutSuccess(Tamu $tamu)
    {
        return view('publik.checkout-success', compact('tamu'));
    }
}
