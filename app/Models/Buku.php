<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';

    protected $fillable = [
        'kategori_id',
        'judul',
        'pengarang',
        'penerbit',
        'isbn',
        'tahun_terbit',
        'stok',
        'tersedia',
        'foto_sampul',
        'status',
    ];

    protected $casts = [
        'tahun_terbit' => 'integer',
        'stok' => 'integer',
        'tersedia' => 'integer',
    ];

    // Relationships
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }

    // Scopes
    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia')->where('tersedia', '>', 0);
    }

    public function scopeByKategori($query, $kategoriId)
    {
        return $query->where('kategori_id', $kategoriId);
    }

    // Accessors
    public function getUrlFotoSampulAttribute()
    {
        return $this->foto_sampul ? asset('storage/' . $this->foto_sampul) : null;
    }
}
