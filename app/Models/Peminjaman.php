<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'kode_peminjaman',
        'anggota_id',
        'buku_id',
        'user_id',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_kembali',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_kembali' => 'date',
    ];

    // Relationships
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function denda()
    {
        return $this->hasOne(Denda::class, 'peminjaman_id');
    }

    // Scopes
    public function scopeSedangDipinjam($query)
    {
        return $query->where('status', 'dipinjam');
    }

    public function scopeSudahKembali($query)
    {
        return $query->where('status', 'dikembalikan');
    }

    public function scopeTerlambat($query)
    {
        return $query->where('status', 'terlambat')
            ->orWhere(function ($q) {
                $q->where('status', 'dipinjam')
                    ->whereDate('tanggal_jatuh_tempo', '<', now());
            });
    }

    // Helper Methods
    public function isTerlambat()
    {
        if ($this->status === 'dikembalikan') {
            return false;
        }
        return Carbon::parse($this->tanggal_jatuh_tempo)->isPast();
    }

    public function hitungHariTerlambat()
    {
        if (!$this->isTerlambat()) {
            return 0;
        }

        $tanggalAcuan = $this->tanggal_kembali ?? now();
        return Carbon::parse($this->tanggal_jatuh_tempo)->diffInDays($tanggalAcuan);
    }
}
