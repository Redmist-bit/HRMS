<?php

namespace App\Http\Controllers;
use JWTAuth;
use App\Models\UserMenu;
use Illuminate\Http\Request;

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
}
