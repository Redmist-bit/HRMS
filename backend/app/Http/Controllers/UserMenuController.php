<?php

namespace App\Http\Controllers;
use JWTAuth;
use App\Models\UserMenu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserMenuController extends Controller
{
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    public function menu()
    {
        return $this->user->usermenus()->where('Visible',1)->get();
        // return $data
        // return UserMenu::where('Visible',1)->where('UserMenu',1)->get();
    }
    public function list()
    {
        $menu = User::distinct()->get(['UserMenu']);
        $data = collect();
        foreach ($menu as $c => $val )  {
            $data->push($val['UserMenu']);
        }
        // print_r($data);
        return response()->json($data);
    }
    public function menuselected($usermenu)
    {
        return UserMenu::where('UserMenu',$usermenu)->get();
    }
    public function updatemenu(Request $request, $id,$kode)
    {
        $x = $id ;
        $x.= '/' ;
        $x.= $kode;
        $data = UserMenu::where('KodeMenu',$x)->update([
            "Visible"=>$request->Visible,
        ]);
        if ($data == 1) {
            return response()->json([
                "status"=>'success',
            ],200);
        }else if($data == 0){
            return response()->json([
                "status"=>'tidak ada yg di update',
            ],200);
        }

    }
    public function addMenu(Request $request)
    {
        $menu = new UserMenu();
        $last = DB::table('usermenus')->orderBy('KodeMenu', 'desc')->first();
        if (isset($last) == null) {
            $fixcode = '01/0001';
        } else {
            $kode = substr($last->KodeMenu,3);
            $kode_dpn = substr($last->KodeMenu,0,3);
            $fixcode = $kode_dpn.str_pad($kode+1, 4, "0", STR_PAD_LEFT);
        };
        $menu->KodeMenu = $fixcode;
        $menu->Parent = $request->Parent;
        $menu->Nama = $request->Nama;
        $menu->Object = $request->Object;
        $menu->UserMenu = $request->UserMenu;
        $menu->Visible = $request->Visible;
        $menu->Icon = $request->Icon;
        $menu->save();
    }
    
}
