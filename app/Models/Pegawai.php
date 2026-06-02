<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $fillable = ['nama', 'nip', 'jabatan', 'departemen', 'no_wa', 'email', 'aktif'];

    protected $casts = ['aktif' => 'boolean'];

    public function tamu(): HasMany
    {
        return $this->hasMany(Tamu::class, 'bertemu_dengan');
    }

    public function getNomorWaFormattedAttribute(): string
    {
        $no = preg_replace('/\D/', '', $this->no_wa);
        if (str_starts_with($no, '0')) {
            $no = '62' . substr($no, 1);
        }
        return $no;
    }
}
