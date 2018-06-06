<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
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
            return 1;
        }
    }
    public function userlist(){
        $limit = 10;
        if(!isset($_GET['page'])){
            if(!isset($_GET['class'])){
                $data['user'] = userModel::offset(0)->limit($limit)->orderBy('statu', 'asc')->get()->toArray();
                $data['count'] = userModel::count();
            }else{
                $data['user'] = userModel::where(['class_id'=>$_GET['class']])->offset(0)->orderBy('statu', 'asc')->limit($limit)->get()->toArray();
                $data['count'] = userModel::where(['class_id'=>$_GET['class']])->count();
            }
        }else{
            $page =$_GET['page'];
            $offset=($page-1)*$limit;
            if(!isset($_GET['class'])){
                $data['user'] = userModel::offset($offset)->limit($limit)->orderBy('statu', 'asc')->get()->toArray();
                $data['count'] = userModel::count();
            }else{
                $data['user'] = userModel::where(['class_id'=>$_GET['class']])->offset($offset)->limit($limit)->orderBy('statu', 'asc')->get()->toArray();
                $data['count'] = userModel::where(['class_id'=>$_GET['class']])->count();
            }
        }
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
            $reader = $reader->getSheet(0);
            $data = $results = $reader->toArray();
            $classname = $data[0][1];
            $classno =  $data[0][3];
            if(!classModel::where(['tid'=>$classno])->first()){
                $class = new classModel();
                $class->name=$classname;
                $class->tid=$classno;
                $class->statu=1;
                $class->save();
            }
            array_shift($data);
            array_shift($data);
            $classid=classModel::where(['tid'=>$classno])->first()->id;
            foreach($data as $val){
                if(!userModel::where(['stuid'=>$val[2]])->orWhere('email', '=', $val[1])->first()){
                    $user = new userModel();
                    $user->name=$val[0];
                    $user->email=$val[1];
                    $user->stuid=$val[2];
                    $user->password=bcrypt('12345678');
                    $user->class_id=$classid;
                    $user->statu=2;
                    $user->save();
                }
            }
        });
        return redirect(route('userlist'));
    }
}
