<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Admin\classModel;
use App\Admin\userModel;
use App\Admin\questionModel;
use App\Admin\answerModel;
use App\Admin\collectModel;

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
    public function collect(){
        $collect=collectModel::where(['user'=>Auth::user()->id])->get(['question'])->toArray();
        $questionid=array();
        foreach ($collect as $val){
            $questionid[]=$val['question'];
        }
        if($questionid){
            $data['questionid']=$questionid;
            $data['count']=count($questionid);
            $question = questionModel::where(['id'=>$questionid[0]])->get()->toArray();
            $answer = answerModel::where(['question_id'=>$question[0]['id']])->get()->toArray();
            $colect = collectModel::where(['question'=>$question[0]['id'],'user'=>Auth::user()->id])->get()->toArray();
            $data['collect'] = $colect?1:0;
            $data['question']=$question[0];
            $data['answer']=$answer;
            $data['curid']=$question[0]['id'];
            return view('Home/user/collect',$data);
        }else{
            echo '无收藏';
        }
    }
}
