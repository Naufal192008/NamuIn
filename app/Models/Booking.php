<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'nama_tamu',
        'instansi',
        'no_wa',
        'kategori_id',
        'tujuan_kunjungan',
        'bertemu_dengan',
        'detail_keperluan',
        'tanggal_booking',
        'jam_booking',
        'booking_code',
        'status',
        'catatan_staf',
    ];

    protected $casts = [
        'tanggal_booking' => 'date',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriTamu::class, 'kategori_id');
    }

    public function pegawaiTujuan(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'bertemu_dengan');
    }
}
