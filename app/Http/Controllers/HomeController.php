<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function otp(){
        return view('admin.otp');
    }

    public function register(){
        return view('admin.register');
    }

    public function showLogin()  {
        return view('admin.login');
    }

    public function dashboard(){
        return view('admin.pages-starter'); 
    }

    public function adminall(){
        return view('admin.admin-all');
    }
    
    public function adddepartment(){

        $menu = Menu::select('id','menu','submenu')->get()->groupBy('menu');

        return view('admin.department',compact('menu'));

    }
}