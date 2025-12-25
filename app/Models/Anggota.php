<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';

    protected $fillable = [
        'kode_anggota',
        'nama',
        'nomor_identitas',
        'email',
        'telepon',
        'alamat',
        'foto',
        'status',
        'tanggal_bergabung',
    ];

    protected $casts = [
        'tanggal_bergabung' => 'date',
    ];

    // Relationships
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'anggota_id');
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeCari($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('nama', 'like', "%{$keyword}%")
                ->orWhere('kode_anggota', 'like', "%{$keyword}%")
                ->orWhere('nomor_identitas', 'like', "%{$keyword}%");
        });
    }

    // Accessors
    public function getUrlFotoAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }
}
