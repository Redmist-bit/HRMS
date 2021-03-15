<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use App\Models\UserMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public $loginAfterSignUp = true;

    public function login(Request $request)
    {
        $credentials = $request->only("Nama","password");
        $token = null;
        if(!$token = JWTAuth::attempt($credentials)){
            return response()->json([
                "status" => false,
                "message" => "Unauthorized"
            ]);
        }
        $currentUser = JWTAuth::user();
        // $menu = JWTAuth::parseToken()->authenticate();
        return response()->json([
            "status"=>true,
            "token"=>$token,
            "user"=>$currentUser,
        ]);
    }

    public function userdata(){
        $data = collect();
        $sql = DB::select('select * from users order by id');
        $chunk = array_chunk($sql,1000);
        return response()->json(collect($chunk)->collapse());
    }

    public function userCheck(){
        return response()->json([ 'sesi' => auth()->check() ]);
    }

    public function saya()
    {
        return response()->json(auth()->user());
    }



    public function register(Request $request)
    {
        $this->validate($request, [
            "Nama" => "required|string|unique:users",
            "password" => "required|string|min:4|max:50"
        ]);

        $user = new User();
        $user->Kode = $request->Kode;
        $user->Nama = $request->Nama;
        $user->UserMenu = $request->UserMenu;
        $user->password = bcrypt($request->password);
        $user->save();
        if ($user->save()){
            if (UserMenu::where('UserMenu', '=', $user['UserMenu'])->exists()) {
                //do nothing
             }else{
            for ($i=0; $i < count($request->Menu); $i++) {
                $last = DB::table('usermenus')->orderBy('KodeMenu', 'desc')->first();
                if (isset($last) == null) {
                    $fixcode = '01/0001';
                } else {
                    $kode = substr($last->KodeMenu,3);
                    $kode_dpn = substr($last->KodeMenu,0,3);
                    $fixcode = $kode_dpn.str_pad($kode+1, 4, "0", STR_PAD_LEFT);
                };
                $UserMenu = new UserMenu;
                $UserMenu->KodeMenu = $fixcode;
                $UserMenu->Nama = $request->Menu[$i]['Nama'];
                $UserMenu->Object = $request->Menu[$i]['Object'];
                $UserMenu->UserMenu = $user->UserMenu;
                $UserMenu->Visible = $request->Menu[$i]['Visible'];
                $UserMenu->Icon = $request->Menu[$i]['Icon'];
                $UserMenu->save();
                }
            }
        }
        // if ($user->save()){ 
        //         if (isset($request->jabatan['jabatan']) == false) {
        //             $jabatan = new Jabatan;
        //             $jabatan->jabatan;
        //             $jabatan->save();
        //             }else{
        //             //do nothing
        //             }
        // }

        if ($this->loginAfterSignUp) {
            return $this->login($request);
        }

        return response()->json([
            "status"=> true,
            "user" => $user
        ]);
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            "token" => "required"
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                "status" => true,
                "message" => "User logged out berhasil"
            ]);
        } catch (JWTEXeception $exception) {
            return response()->json([
                "status" => false,
                "message" => "user tidak gagal logout"
            ]);
        }
    }
}
