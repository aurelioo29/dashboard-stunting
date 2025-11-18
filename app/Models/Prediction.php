<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    protected $fillable = [
        'user_id',

        // DATA FORM
        'usia_bulan',
        'jenis_kelamin',
        'bb_balita',
        'tb_balita',
        'bmi',
        'imunisasi',
        'air_bersih',
        'sanitasi',
        'pendapatan_rupiah',   // ⬅️ ganti rupiah

        // Z-SCORE
        'haz',
        'waz',
        'whz',

        // HASIL PREDIKSI
        'risk_level',
        'probability',

        // kontribusi faktor (disimpan JSON)
        'contributions',
    ];

    protected $casts = [
        'bb_balita'         => 'float',
        'tb_balita'         => 'float',
        'bmi'               => 'float',
        'pendapatan_rupiah' => 'int',     // ⬅️ rupiah utuh (300000, 1200000, dst)
        'haz'               => 'float',
        'waz'               => 'float',
        'whz'               => 'float',
        'probability'       => 'float',
        'contributions'     => 'array',
    ];
}
