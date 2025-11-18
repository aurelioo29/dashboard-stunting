<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prediction;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        // pretty JSON utk disimpan (lebih rapi kalau dicek di DB)
        $contribPretty = json_encode($request->contributions, JSON_PRETTY_PRINT);

        $data = [
            'user_id'           => $user->id,
            'usia_bulan'        => $request->usia_bulan,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'bb_balita'         => $request->bb_balita,
            'tb_balita'         => $request->tb_balita,
            'bmi'               => $request->bmi,
            'imunisasi'         => $request->imunisasi,
            'air_bersih'        => $request->air_bersih,
            'sanitasi'          => $request->sanitasi,

            // ⬇️ LANGSUNG RUPIAH
            'pendapatan_rupiah' => (int) $request->pendapatan_rupiah,

            'haz'               => $request->haz,
            'waz'               => $request->waz,
            'whz'               => $request->whz,
            'risk_level'        => $request->risk_level,
            'probability'       => $request->probability,

            'contributions'     => $contribPretty,
        ];

        Prediction::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Prediksi tersimpan',
        ]);
    }
}
