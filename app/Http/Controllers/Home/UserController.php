<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Admin\classModel;
use App\Admin\userModel;

class UserController extends Controller
{
    //
    protected $user;

    public function addclass(){
        if(isset($_GET['search'])){
            $search = $_GET['search'];
            $data['class']=classModel::whereRaw("tid like '%$search%' or name like '%$search%'")->get()->toArray();
            $data['search'] = $search;
        }
        else{
            $data['class'] = classModel::get()->toArray();
        }
        return view('Home/user/addclass',$data);
    }
    public function useroperate(){
        if($_POST['operate'] = 'addclass'){
            $uid = Auth::user()->toArray();
            $user = userModel::find($uid['id']);
            $user->statu=1;
            $user->class_id=$_POST['classid'];
            $user->save();
            echo 1;
        }
    }
}
