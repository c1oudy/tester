<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
use App\Admin\classModel;
use App\Admin\examModel;
use App\Admin\userModel;
use App\Admin\userexamModel;
use App\Admin\questionModel;
use App\Admin\typeModel;

class ExamController extends Controller
{
    //
    public function examsetting(){
        $data['class'] = classModel::where('id','!=',1)->get()->toArray();
        return view('Admin/examsetting',$data);
    }
    public function addexam(){
        $class = array();
        foreach($_GET['class'] as $key=>$val){
            $class[]=$key;
        }
        $exam = new examModel();
        $exam->title = $_GET['title'];
        $exam->total = $_GET['total'];
        $exam->major = $_GET['major'];
        $exam->time = $_GET['time']*60;
        $exam->last = $_GET['last'];
        $strClass=implode(',',$class);
        $exam->classlist = $strClass;
        $userlist=userModel::whereIn('class_id',$class)->select(['id','class_id'])->get()->toArray();
        $exam->save();
        $exam = examModel::where(['title'=>$_GET['title']])->get()->toArray();
        foreach($userlist as $val){
            $userexam = new userexamModel();
            $userexam->userid=$val['id'];
            $classname = classModel::where(['id'=>$val['class_id']])->select(['name'])->get()->toArray();
            $typeid = typeModel::where(['name'=>$classname[0]['name']])->get()->toArray();
            $question = array_map('reset',questionModel::where(['type_id'=>$typeid[0]['id']])->select(['id'])->get()->toArray());
            $numbers = range (0,count($question)-1);
            shuffle ($numbers);
            $num=$_GET['major'];
            $result = array_slice($numbers,0,$num);
            $arrQuestion = array();
            foreach ($result as $v){
                $arrQuestion[] = $question["$v"];
            }
            $question = array_map('reset',questionModel::where(['type_id'=>2])->select(['id'])->get()->toArray());
            $numbers = range (0,count($question)-1);
            shuffle ($numbers);
            $num=$_GET['total']-count($arrQuestion);
            $result = array_slice($numbers,0,$num);
            foreach ($result as $v){
                $arrQuestion[] = $question["$v"];
            }
            sort($arrQuestion);
            $userexam->examid=$exam[0]['id'];
            $userexam->question=implode(',',$arrQuestion);
            $userexam->userid=$val['id'];
            $userexam->save();
        }
        return redirect(route('examlist'));
    }
    public function examlist(){
        $data['exam'] = examModel::get()->toArray();
        return view('Admin/examlist',$data);
    }
    public function checktitle(){
        $title = $_POST['title'];
        if(examModel::where(['title'=>$title])->get()->toArray()){
            echo 0;exit;
        }
        echo 1;
    }
    public function dowmloadexcel(){
        $info = userexamModel::where(['examid'=>$_POST['id']])->get()->toArray();
        Excel::create('学生成绩',function($excel) use ($info){
            $excel->sheet('score', function($sheet) use ($info){
                $sheet->rows($info);
            });
        })->export('xls');
    }
}
