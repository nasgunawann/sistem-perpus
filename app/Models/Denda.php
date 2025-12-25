<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $table = 'denda';

    protected $fillable = [
        'peminjaman_id',
        'user_id',
        'hari_terlambat',
        'jumlah_denda',
        'jumlah_dibayar',
        'status',
        'tanggal_bayar',
    ];

    protected $casts = [
        'jumlah_denda' => 'decimal:2',
        'jumlah_dibayar' => 'decimal:2',
        'tanggal_bayar' => 'date',
    ];

    // Relationships
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Scopes
    public function scopeBelumBayar($query)
    {
        return $query->where('status', 'belum_bayar');
    }

    public function scopeSudahBayar($query)
    {
        return $query->where('status', 'sudah_bayar');
    }

    // Accessors
    public function getSisaDendaAttribute()
    {
        return $this->jumlah_denda - $this->jumlah_dibayar;
    }
}
