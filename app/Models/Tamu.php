<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tamu extends Model
{
    protected $table = 'tamu';
    protected $fillable = [
        'nama_tamu', 'instansi', 'no_wa', 'kategori_id',
        'tujuan_kunjungan', 'detail_keperluan', 'handled_by',
        'jam_masuk', 'jam_pulang', 'status',
    ];

    protected $casts = [
        'jam_masuk' => 'datetime',
        'jam_pulang' => 'datetime',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriTamu::class, 'kategori_id');
    }

    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function getDurasiAttribute(): string
    {
        if (!$this->jam_pulang) return '-';
        $diff = $this->jam_masuk->diff($this->jam_pulang);
        return sprintf('%02d:%02d', $diff->h + ($diff->days * 24), $diff->i);
    }
}
