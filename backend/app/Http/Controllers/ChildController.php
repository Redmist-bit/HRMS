<?php

namespace App\Http\Controllers;
use JWTAuth;
use App\Models\Child;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ChildController extends Controller
{
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    public function addChild(Request $request)
    {
        $anak = new Child();
        $anak->KodeKaryawan = $request->KodeKaryawan;
        $anak->NamaAnak = $request->NamaAnak;
        $anak->AnakKe = $request->AnakKe;
        $anak->DibuatOleh = $this->user->Kode;
        $anak->DiubahOleh = $this->user->Kode;
        $anak->save();
        return response()->json([
            "status" => 'success',
            "Anak" => $anak
        ]);
    }
}
