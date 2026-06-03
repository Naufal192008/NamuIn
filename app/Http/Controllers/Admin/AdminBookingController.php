<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    protected WhatsAppService $waService;

    public function __construct(WhatsAppService $waService)
    {
        $this->waService = $waService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $date = $request->input('date');

        $query = Booking::query()->with(['kategori', 'pegawaiTujuan']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_tamu', 'like', "%{$search}%")
                  ->orWhere('instansi', 'like', "%{$search}%")
                  ->orWhere('booking_code', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($date) {
            $query->whereDate('tanggal_booking', $date);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Calculate count metrics for stats cards
        $totalCount = Booking::count();
        $diajukanCount = Booking::where('status', 'Diajukan')->count();
        $disetujuiCount = Booking::where('status', 'Disetujui')->count();
        $dibatalkanCount = Booking::where('status', 'Dibatalkan')->count();
        $checkinCount = Booking::where('status', 'Checkin')->count();

        return view('admin.bookings', compact(
            'bookings',
            'totalCount',
            'diajukanCount',
            'disetujuiCount',
            'dibatalkanCount',
            'checkinCount'
        ));
    }

    /**
     * Approve the specified booking.
     */
    public function approve(Booking $booking)
    {
        if ($booking->status !== 'Diajukan') {
            return redirect()->route('admin.bookings.index')->with('error', 'Hanya janji temu dengan status Diajukan yang dapat disetujui.');
        }

        $booking->update([
            'status' => 'Disetujui',
        ]);

        // Send WhatsApp approval notification to guest
        if (!empty($booking->no_wa)) {
            $formattedDate = date('d-m-Y', strtotime($booking->tanggal_booking));
            $pegawaiNama = $booking->pegawaiTujuan ? $booking->pegawaiTujuan->nama : '-';

            $msg = implode("\n", [
                "✅ *Janji Temu Disetujui (NamuIn)*",
                "",
                "Halo, *{$booking->nama_tamu}*!",
                "Pengajuan janji temu Anda telah *DISETUJUI* oleh staf.",
                "",
                "👤 *Bertemu:* {$pegawaiNama}",
                "🗓️ *Tanggal:* {$formattedDate}",
                "🕐 *Waktu:* {$booking->jam_booking} WIB",
                "🔑 *Kode Booking:* *{$booking->booking_code}*",
                "",
                "Simpan Kode Booking di atas. Saat tiba di sekolah, silakan ketik kode tersebut di layar lobi resepsionis untuk melakukan Check-In Instan.",
                "",
                "_Sistem Layanan Tamu *NamuIn*_",
            ]);

            $this->waService->kirimPesan($booking->no_wa, $msg);
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Janji temu berhasil disetujui.');
    }

    /**
     * Reject the specified booking.
     */
    public function reject(Request $request, Booking $booking)
    {
        if ($booking->status !== 'Diajukan') {
            return redirect()->route('admin.bookings.index')->with('error', 'Hanya janji temu dengan status Diajukan yang dapat ditolak.');
        }

        $request->validate([
            'catatan_staf' => 'required|string|max:200',
        ], [
            'catatan_staf.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $booking->update([
            'status' => 'Dibatalkan',
            'catatan_staf' => $request->catatan_staf,
        ]);

        // Send WhatsApp rejection notification to guest
        if (!empty($booking->no_wa)) {
            $formattedDate = date('d-m-Y', strtotime($booking->tanggal_booking));
            $pegawaiNama = $booking->pegawaiTujuan ? $booking->pegawaiTujuan->nama : '-';

            $msg = implode("\n", [
                "❌ *Janji Temu Ditolak (NamuIn)*",
                "",
                "Halo, *{$booking->nama_tamu}*!",
                "Mohon maaf, pengajuan janji temu Anda telah *DITOLAK/DIBATALKAN* oleh staf.",
                "",
                "👤 *Bertemu:* {$pegawaiNama}",
                "🗓️ *Tanggal:* {$formattedDate}",
                "❌ *Alasan:* {$request->catatan_staf}",
                "",
                "Silakan ajukan kembali jadwal janji temu baru di lain waktu.",
                "",
                "_Sistem Layanan Tamu *NamuIn*_",
            ]);

            $this->waService->kirimPesan($booking->no_wa, $msg);
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Janji temu berhasil ditolak.');
    }
}
