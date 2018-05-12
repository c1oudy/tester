<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Admin\classModel;
use App\Admin\userModel;
use App\Admin\messageModel;

class UserController extends Controller
{
    //
    public function index(){
        $data['class'] = classModel::get()->toArray();
        return view("Admin/classlist",$data);
    }
    public function editclass(){
        $classM = new classModel();
        if($_POST['operate'] == 'editstatu'){
            $id = $_POST['classid'];
            $class = classModel::find($id);
            if($class['statu'] == 1){
                $class->statu=0;
            }elseif($class['statu'] == 0){
                $class->statu=1;
            }
            $class->save();
            return 1;
        }
        if($_POST['operate'] == 'add'){
            $classM->name = $_POST['name'];
            $classM->tid = $_POST['id'];
            $classM->statu = 1;
            $classM->save();
            return 1;
        }
        if($_POST['operate'] == 'delete'){
            $id = $_POST['classid'];
            classModel::destroy($id);
            return 1;
        }
        if($_POST['operate'] == 'edit'){
            $id = $_POST['typeid'];
            $type=typeModel::find($id);
            $type->name=$_POST['name'];
            $type->save();
            return 1;
        }
    }
    public function useroperate(){
        if($_POST['operate'] == 'pass'){
            $uid = $_POST['uid'];
            $uesr = userModel::find($uid);
            $uesr->statu = 2;
            $uesr->save();
            return 1;
        }
        if($_POST['operate'] == 'unpass'){
            $uid = $_POST['uid'];
            $uesr = userModel::find($uid);
            $uesr->statu = 3;
            $uesr->save();
            $message = new messageModel();
            $message->send_id = session()->get('adminuser')->name;
            $message->receive_id = $uid;
            $message->title = '班级审核';
            $message->content = "班级审核被拒绝";
            $message->statu = 0;
            $message->save();
            return 1;
        }
    }
    public function userlist(){
        $data['user'] = userModel::get()->toArray();
        $data['class'] = classModel::get()->toArray();
        foreach ($data['class'] as $val){
            $id = $val['id'];
            $data['class']["$id"]=$val;
        }
        $data['class'][0]=1;
        return view("Admin/userlist",$data);

    }
    public function uploaduser(Request $request){
        $file = $request->file('excel');
        if ($file->isValid()) {
            $ext = $file->getClientOriginalExtension();     // 扩展名
            $realPath = $file->getRealPath();   //临时文件的绝对路径

            // 上传文件
            $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
            // 使用我们新建的uploads本地存储空间（目录）
            //这里的uploads是配置文件的名称
            $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
        }
        Excel::load($realPath, function($reader) {
            $data = $reader->all();
            dd($data);
        });
        var_dump($_POST);
    }
}
