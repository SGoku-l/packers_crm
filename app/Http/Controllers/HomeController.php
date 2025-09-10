<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function otp(){
        return view('admin.otp');
    }

    public function register(){
        return view('admin.register');
    }
}
