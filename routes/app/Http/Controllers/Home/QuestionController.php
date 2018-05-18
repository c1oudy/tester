<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Admin\answerModel;
use App\Admin\questionModel;
use App\Admin\collectModel;

class QuestionController extends Controller
{
    //
    public function getquestion(){
        $id = $_POST['id'];
        $question = questionModel::find($id)->toArray();
        $answer = answerModel::where(['question_id'=>$question['id']])->get()->toArray();
        $data['collect'] = collectModel::where(['question'=>$question['id'],'user'=>Auth::user()->id])->get()->toArray();
        $data['question']=$question;
        $data['answer']=$answer;
        echo json_encode($data);
    }
    public function questionoperate(){
        $question = questionModel::where(['id'=>$_POST['question_id']])->get()->toArray();
        return $question[0]['right'];
    }
    public function changecollect(){
        $user = auth::user()->id;
        $question = $_POST['question'];
        $collect=collectModel::where(['user'=>$user,'question'=>$question])->get()->toArray();
        if($collect){
            collectModel::destroy($collect[0]['id']);
        }else{
            $collect = new collectModel();
            $collect->user = $user;
            $collect->question = $question;
            $collect->save();
        }
        echo 1;
    }
}
