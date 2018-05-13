<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin\answerModel;
use App\Admin\questionModel;

class PracticeController extends Controller
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
        return view('Home/practice/practice-type');
    }

    public function practice()
    {
        $id=$_GET['type'];
        $questionlist = questionModel::where(['type_id'=>$id])->get(['id'])->toArray();
        $questionid=array();
        foreach($questionlist as $val){
            $questionid[]=$val['id'];
        }
        $data['questionid']=$questionid;
        $data['count']=count($questionid);
//        var_dump($data);exit;
        $question = questionModel::where(['type_id'=>$id])->get()->toArray();
        $answer = answerModel::where(['question_id'=>$question[0]['id']])->get()->toArray();
        $data['question']=$question[0];
        $data['answer']=$answer;
        $data['curid']=$question[0]['id'];
        return view('Home/practice/practice',$data);
    }
}
