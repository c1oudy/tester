<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ['lefttime'=>4000];
        return view('Home/exam/exam',$data);
    }
    public function examlist(){
        $data[]=1;
        return view('Home/exam/examlist',$data);
    }
}
