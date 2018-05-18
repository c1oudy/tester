<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input, Validator, Redirect, Session, Captcha,DB;

class LoginController extends Controller
{
    //
    public function __construct()
    {

    }
    public function index(){
        $data['img']=captcha_img();
        return view('Admin/login',$data);
    }
    public function checklogin(Request $request){
        $rules = [
            "username" => 'required',
            "password" => 'required',
            "captcha" => 'required|captcha'
        ];
        $messages = [
            'username.required' => '请输入用户名',
            'password.required' => '请输入密码',
            'captcha.required' => '请输入验证码',
            'captcha.captcha' => '验证码错误，请重试'
        ];
        $validator = Validator::make($_POST, $rules, $messages);
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else {
            $username = $_POST['username'];
            $password = md5($_POST['password']);
            $res = DB::select("select * from users where name = '$username' and password='$password' and role ='admin'");
            if($res){
                session()->put('adminuser', $res[0]);
                return redirect("adminhome");
            }
            $validator->errors()->add('loginstatu', '用户名或密码错误');
            return Redirect::back()->withErrors($validator);
        }
    }
}
