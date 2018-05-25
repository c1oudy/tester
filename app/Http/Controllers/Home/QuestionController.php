<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Admin\answerModel;
use App\Admin\questionModel;
use App\Admin\collectModel;
use App\Admin\userexamModel;

class QuestionController extends Controller
{
    //
    public function getquestion(){
        $id = $_POST['id'];
        $question = questionModel::find($id)->toArray();
        $answer = answerModel::where(['question_id'=>$question['id']])->get()->toArray();
        if(isset($_POST['ue'])) {
            if (userexamModel::where(['id' => $_POST['ue'], 'pass' => 2])->get()->toarray() || userexamModel::where(['id' => $_POST['ue'], 'pass' => 1])->get()->toarray()) {
                $ueq = userexamModel::where(['id' => $_POST['ue']])->select(['question'])->get()->toArray()[0]['question'];
                $chose = userexamModel::where(['id' => $_POST['ue']])->select(['answer'])->get()->toArray()[0]['answer'];
                $arrchose = explode(',', $chose);
                $index = array_search($id, explode(',', $ueq));
                if ($arrchose["$index"] == $question['right']) {
                    $data['right'] = $arrchose["$index"];
                    $data['wrong'] = 'qqqqqqqqqq';
                } else {
                    $data['right'] = $question['right'];
                    $data['wrong'] = $arrchose["$index"];
                }
            }
        }
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
