<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $fillable = [
        'kunci',
        'nilai',
        'deskripsi',
    ];

    // Static Methods
    public static function ambil($kunci, $default = null)
    {
        $setting = self::where('kunci', $kunci)->first();
        return $setting ? $setting->nilai : $default;
    }

    public static function atur($kunci, $nilai, $deskripsi = null)
    {
        return self::updateOrCreate(
            ['kunci' => $kunci],
            [
                'nilai' => $nilai,
                'deskripsi' => $deskripsi
            ]
        );
    }
}
