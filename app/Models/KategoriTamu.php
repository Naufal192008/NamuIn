<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriTamu extends Model
{
    protected $table = 'kategori_tamu';
    protected $fillable = ['nama_kategori', 'warna'];

    public function tamu(): HasMany
    {
        return $this->hasMany(Tamu::class, 'kategori_id');
    }
}
