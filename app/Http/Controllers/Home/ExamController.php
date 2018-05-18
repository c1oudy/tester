<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Admin\userexamModel;
use App\Admin\examModel;
use App\Admin\questionModel;
use App\Admin\answerModel;
use App\Admin\collectModel;

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
        $id=$_GET['id'];
        $questionid=explode(',',userexamModel::where(['id'=>$id])->select(['question'])->get(['id'])->toArray()[0]['question']);
        $data['questionid']=$questionid;
        $data['count']=count($questionid);
        $question = questionModel::whereIn('id',$questionid)->get()->toArray();
        $answer = answerModel::where(['question_id'=>$question[0]['id']])->get()->toArray();
        $colect = collectModel::where(['question'=>$question[0]['id'],'user'=>Auth::user()->id])->get()->toArray();
        $data['collect'] = $colect?1:0;
        $data['question']=$question[0];
        $data['answer']=$answer;
        $data['curid']=$question[0]['id'];
        $data['lefttime']=1;
        return view('Home/exam/exam',$data);
    }
    public function examlist(){
        $userid=Auth::user()->id;
        $userexam=userexamModel::where(['userid'=>$userid])->select(['examid'])->get()->toarray();
        $userexamid=array_map('reset',$userexam);
        $data['exam']=examModel::whereIn('id',$userexamid)->get()->toArray();
        for ($i=0;$i<count($data['exam']);$i++){
            $data['exam']["$i"]['userexam']=userexamModel::where(['userid'=>$userid,'examid'=>$data['exam']["$i"]['id']])->select(['id'])->get()->toArray()[0]['id'];
            $data['exam']["$i"]['pass']=userexamModel::where(['userid'=>$userid,'examid'=>$data['exam']["$i"]['id']])->select(['pass'])->get()->toArray()[0]['pass'];
        }
//        dd($exam);
        $data[]=1;
        return view('Home/exam/examlist',$data);
    }
    public function submitpaper(){
        $answer = explode(',',$_POST['answer']);
        dd($answer) ;
    }
}
