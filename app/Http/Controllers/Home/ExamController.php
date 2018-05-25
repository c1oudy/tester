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
        $userexam = userexamModel::find($id)->toArray();
        if($userexam['pass'] != 0){
            $chose = explode(',',$userexam['answer']);
            $data['chose']=$chose;
            $right = array_map('reset',questionModel::whereIn('id',$questionid)->select(['right'])->get()->toArray());
            $data['right']=$right;
            $data['right1']=$right[0];
            $data['chose1']=$chose[0];
        }
        sort($questionid);
        $data['questionid']=$questionid;
        $data['count']=count($questionid);
        $question = questionModel::whereIn('id',$questionid)->get()->toArray();
        $answer = answerModel::where(['question_id'=>$question[0]['id']])->get()->toArray();
        $colect = collectModel::where(['question'=>$question[0]['id'],'user'=>Auth::user()->id])->get()->toArray();
        $data['collect'] = $colect?1:0;
        $data['question']=$question[0];
        $data['answer']=$answer;
        $data['curid']=$question[0]['id'];
        $lefttime = examModel::where(['id'=>$userexam['examid']])->get()->toArray()[0]['time'];
        $data['lefttime']=10;
        $data['pass']=$userexam['pass'];
        return view('Home/exam/exam',$data);
    }
    public function examlist(){
        $data['now']=strtotime(date('Y-m-d'));
        $userid=Auth::user()->id;
        $userexam=userexamModel::where(['userid'=>$userid])->select(['examid'])->get()->toarray();
        $userexamid=array_map('reset',$userexam);
        $data['exam']=examModel::whereIn('id',$userexamid)->get()->toArray();
        for ($i=0;$i<count($data['exam']);$i++){
            $data['exam']["$i"]['userexam']=userexamModel::where(['userid'=>$userid,'examid'=>$data['exam']["$i"]['id']])->select(['id'])->get()->toArray()[0]['id'];
            $data['exam']["$i"]['pass']=userexamModel::where(['userid'=>$userid,'examid'=>$data['exam']["$i"]['id']])->select(['pass'])->get()->toArray()[0]['pass'];
            $data['exam']["$i"]['score']=userexamModel::where(['userid'=>$userid,'examid'=>$data['exam']["$i"]['id']])->select(['score'])->get()->toArray()[0]['score'];
            $data['exam']["$i"]['timestap']=strtotime($data['exam']["$i"]['last']);
        }
        return view('Home/exam/examlist',$data);
    }
    public function submitpaper(){
        $answer = explode(',',$_POST['answer']);
        $userwxamid = $_POST['ue'];
        $questionid = explode(',',userexamModel::where(['id'=>$userwxamid])->select(['question'])->get()->toArray()[0]['question']);
        sort($questionid);
        $right = array_map('reset', questionModel::whereIn('id',$questionid)->select(['right'])->get()->toArray());
        $score = 0;
        for($i=0;$i<count($right);$i++){
            if($right["$i"] == $answer["$i"]){
                $score++;
            }
        }
        $userexam = userexamModel::find($userwxamid);
        $userexam->score=$score;
        $userexam->answer = implode(',',$answer);
        if($score>=(count($right)*0.6)){
            $userexam->pass = 1;
        }else{
            $userexam->pass = 2;
        }
        $userexam->save();
        return 1;
    }
}
