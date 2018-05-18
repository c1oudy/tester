<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin\userexamModel;
use App\Admin\examModel;
use App\Admin\questionModel;
use App\Admin\answerModel;
use App\Admin\collectModel;
use Auth;

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
        $questionid = explode(',',userexamModel::where(['id'=>$_GET['id']])->get(['question'])->toArray()[0]['question']);
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
        $data['lefttime'] = 1;
        return view('Home/exam/exam',$data);
    }
    public function examlist(){
        $userid = Auth::user()->id;
        $data['userexam'] = userexamModel::where(['userid'=>$userid])->select(['examid','pass'])->get()->toArray();
        $data['examid'] = array_map('reset',$data['userexam']);
        $data['exam'] = examModel::whereIn('id',$data['examid'])->get()->toArray();
        for ($i=0;$i<count($data['exam']);$i++){
            $data['exam']["$i"]['pass']=array_map('reset',userexamModel::where(['userid'=>$userid,'examid'=> $data['exam']["$i"]['id']])->select(['pass'])->get()->toArray())[0];
            $data['exam']["$i"]['userexam']=array_map('reset',userexamModel::where(['userid'=>$userid,'examid'=> $data['exam']["$i"]['id']])->select(['id'])->get()->toArray())[0];
            $data['exam']["$i"]['score']=array_map('reset',userexamModel::where(['userid'=>$userid,'examid'=> $data['exam']["$i"]['id']])->select(['score'])->get()->toArray())[0];
        }
        return view('Home/exam/examlist',$data);
    }
    public function submitpaper(){
        $answer = explode(',',$_POST['answer']);
        $userexamid = $_POST['ue'];
        $userexam = userexamModel::where(['id'=>$userexamid])->get()->toArray()[0];
        $question = questionModel::whereIn('id',explode(',',$userexam['question']))->select(['right'])->get()->toArray();
        $right = array_map('reset',$question);
        $score = 0;
        for($i=0;$i<count($right);$i++){
            if($right["$i"] == $answer["$i"]){
                $score++;
            }
        }
        $userexam = userexamModel::where(['id'=>$userexamid])->get()[0];
        $userexam->score=$score;
        $userexam->answer=implode(',',$answer);

        if($score>=(0.6*count($right))){
            $userexam->pass = 1;
        }else{
            $userexam->pass = 2;
        }
        $userexam->save();
        echo 1;
    }
}
