<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //
    public function index(){
        return view('Admin/home');
    }
    public function welcome(){
        return view('Admin/welcome');
    }
}