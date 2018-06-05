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
use DB;

class ExamController extends Controller
{
    //
    public function examsetting(){
        $data['class'] = classModel::where('id','!=',1)->select('name')->distinct()->get()->toArray();
        return view('Admin/examsetting',$data);
    }
    public function addexam(){
        $class = array();
        foreach($_GET['class'] as $key=>$val){
            $class[]='"'.$key.'"';
        }
        $classlist = [];
        $classlist1 = [];
        foreach($class as $val){
            $classlist1[]=DB::select("select id from class where name =$val and statu=1");
        }
        foreach($classlist1 as $val){
            foreach ($val as $v){
                $classlist[] = $v->id;
            }
        }
        $exam = new examModel();
        $exam->title = $_GET['title'];
        $exam->total = $_GET['total'];
        $exam->major = $_GET['major'];
        $exam->time = $_GET['time']*60;
        $exam->last = $_GET['last'];
        $strClass=implode(',',$class);
        $exam->classlist = $strClass;
        $userlist=userModel::whereIn('class_id',$classlist)->select(['id','class_id'])->get()->toArray();
        $exam->save();
        $exam = examModel::where(['title'=>$_GET['title']])->get()->toArray();
        foreach($userlist as $val){
            $userexam = new userexamModel();
            $classname = classModel::where(['id'=>$val['class_id']])->select(['name'])->get()->toArray();
            $typeid = typeModel::where(['name'=>$classname[0]['name']])->get()->toArray();
            $arrQuestion = array();
            $total = $_GET['total'];
            $major = $_GET['major'];
            $public=$total-$major;
            $question = array_map('reset',questionModel::where(['type_id'=>$typeid[0]['id'],'qid'=>'0'])->select(['id'])->get()->toArray());
            $single = $_GET['danxuan'];
            $max = max(0,$single-$public);
            $numbers = range (0,count($question)-1);
            shuffle ($numbers);
            $zys = rand($max,$single);
            $ggs = $single - $zys;
            $result = array_slice($numbers,0,$zys);
            foreach ($result as $v){
                $arrQuestion[] = $question["$v"];
            }
            $question = array_map('reset',questionModel::where(['type_id'=>2,'qid'=>'0'])->select(['id'])->get()->toArray());
            $numbers = range (0,count($question)-1);
            shuffle($numbers);
            $result = array_slice($numbers,0,$ggs);
            foreach ($result as $v){
                $arrQuestion[] = $question["$v"];
            }
            $question = array_map('reset',questionModel::where(['type_id'=>$typeid[0]['id'],'qid'=>'2'])->select(['id'])->get()->toArray());
            $numbers = range (0,count($question)-1);
            shuffle($numbers);
            $pd = (int)$_GET['panduan'];
            $muit = $total -$pd-$single;
            $min = max(0,$major-$muit-$zys);
            $max = min($pd,$major-$zys);
            $zypd = rand($min,$max);
            $ggpd = $pd - $zypd;
            $result = array_slice($numbers,0,$zypd);
            foreach ($result as $v){
                $arrQuestion[] = $question["$v"];
            }
            $question = array_map('reset',questionModel::where(['type_id'=>2,'qid'=>'2'])->select(['id'])->get()->toArray());
            $numbers = range (0,count($question)-1);
            shuffle ($numbers);
            $result = array_slice($numbers,0,$ggpd);
            foreach ($result as $v){
                $arrQuestion[] = $question["$v"];
            }
            $question = array_map('reset',questionModel::where(['type_id'=>$typeid[0]['id'],'qid'=>'1'])->select(['id'])->get()->toArray());
            $numbers = range (0,count($question)-1);
            shuffle($numbers);
            $zym = $major - $zypd-$zys;
            $ggm = $total - $major -$ggpd -$ggs;
            $result = array_slice($numbers,0,$zym);
            foreach ($result as $v){
                $arrQuestion[] = $question["$v"];
            }
            $question = array_map('reset',questionModel::where(['type_id'=>2,'qid'=>'1'])->select(['id'])->get()->toArray());
            $numbers = range (0,count($question)-1);
            shuffle ($numbers);
            $result = array_slice($numbers,0,$ggm);
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
        $ueid=$_GET['id'];
        $info = userexamModel::where(['examid'=>$_GET['id']])->get()->toArray();
        $user = array();
        foreach ($info as $val){
            $user[] = $val['userid'];
        }
        $sreuser=implode(',',$user);
        $class = DB::select("select class_id from users where id in($sreuser) GROUP BY class_id");
        Excel::create('学生成绩',function($excel) use ($info,$class,$ueid){
            foreach ($class as $val){
                $score=[];
                $sheetname = classModel::where(['id'=>$val->class_id])->get()->toArray()[0]['name'];
                $userid = implode(',',array_map('reset',userModel::where(['class_id'=>$val->class_id])->select(['id'])->get()->toArray()));
                $score = DB::select("select a.name,a.stuid,b.score from users a,userexam b where a.id=b.userid and a.id in ($userid) and b.examid=$ueid");
                $score = array_map(function ($value) {
                    return (array)$value;
                }, $score);
                array_unshift($score,['姓名','学号','分数']);
                $excel->sheet("$sheetname", function($sheet) use ($score){
                    $sheet->rows($score);
                    $sheet->setWidth([
                        'A' => 15,
                        'B' => 15,
                        'C' => 10,
                    ]);
                });

            }
            foreach ($class as $val){
                $sheetname = classModel::where(['id'=>$val->class_id])->get()->toArray()[0]['name'];
                $userid = implode(',',array_map('reset',userModel::where(['class_id'=>$val->class_id])->select(['id'])->get()->toArray()));
                $score = DB::select("select a.name,a.stuid,b.score from users a,userexam b where a.id=b.userid and a.id in ($userid) and b.pass!=1 and b.examid=$ueid");
                $score = array_map(function ($value) {
                    return (array)$value;
                }, $score);
                array_unshift($score,['姓名','学号','分数']);
                $excel->sheet("$sheetname"."（未通过）", function($sheet) use ($score){
                    $sheet->rows($score);
                    $sheet->setWidth([
                        'A' => 15,
                        'B' => 15,
                        'C' => 10,
                    ]);
                });

            }
        })->export('xls');
    }
}
