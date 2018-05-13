<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin\answerModel;
use App\Admin\questionModel;

class QuestionController extends Controller
{
    //
    public function getquestion(){
        $id = $_POST['id'];
        $question = questionModel::find($id)->toArray();
        $answer = answerModel::where(['question_id'=>$question['id']])->get()->toArray();
        $data['question']=$question;
        $data['answer']=$answer;
        echo json_encode($data);
    }
}
