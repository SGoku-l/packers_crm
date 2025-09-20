<?php

namespace App\Http\Controllers;

use App\Models\Department;
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

        return view('admin.department');

    }
    public function viewdep(){
        
        $menu = Menu::select('id','menu','submenu')->get()->groupBy('menu');
        $department = Department::with('user')->get();

        return response()->json([
            'status' => true,
            'message' => 'Department Fetch Successfully',
            'department' => $department,
            'menu' => $menu
        ]); 

    }

}