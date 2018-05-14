<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Excel;
use App\Admin\difficultysModel;
use App\Admin\typeModel;
use App\Admin\questionModel;
use App\Admin\answerModel;

class QuestionController extends Controller
{
    //
    public function type(){
        $data['type'] = typeModel::get()->toArray();
        return view('Admin/type',$data);
    }
    public function addtype(){
        $typeM = new typeModel();
        if($_POST['operate'] == 'delete'){
            $id = $_POST['typeid'];
            typeModel::destroy($id);
            return 1;
        }
        if($_POST['operate'] == 'edit'){
            $id = $_POST['typeid'];
            $type=typeModel::find($id);
            $type->name=$_POST['name'];
            $type->save();
            return 1;
        }
        $typeM = new typeModel();
        $typeM->name = $_POST['name'];
        $typeM->save();
        return 1;
    }
    public function questionmanage(){
        $questionall = questionModel::get()->toArray();
        $data['count']= count($questionall);
        $limit = 10;
        if(!isset($_GET['page'])){
            $data['question'] = questionModel::offset(0)->limit($limit)->get()->toArray();
        }else{
            $page =$_GET['page'];
            $offset=($page-1)*$limit;
            $data['question'] = questionModel::offset($offset)->limit($limit)->get()->toArray();
        }
        foreach ($data['question'] as $val){
            $qid = $val['id'];
            $answeer = answerModel::where(['question_id'=>$qid])->Get()->toArray();
            $answeerAll='';
            foreach($answeer as $val){
                $answeerAll.=$val['no'].'.'.$val['title'].'</br>';
            }
            $data['answer']["$qid"]=$answeerAll;
        }
        return view('Admin/questionmanage',$data);
    }
    public function uploadquestion(Request $request){
        $file = $request->file('excel');
        if ($file->isValid()) {
            $ext = $file->getClientOriginalExtension();
            $realPath = $file->getRealPath();
            $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
            $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
        }
        Excel::load($realPath, function($reader) {
            $readerQ = $reader->getSheet(0);
            $readerA = $reader->getSheet(1);
            $question = $readerQ->toArray();
            array_shift($question);
            $answer = $readerA->toArray();
            array_shift($answer);
            foreach($question as $val){
                $type = typeModel::where(['name'=>$val[2]])->get()->toArray();
                if(!$type){
                    $type = new typeModel();
                    $type->name = $val[2];
                    $type->save();
                    $type = typeModel::where(['name'=>$val[2]])->get()->toArray();
                }
                $question=questionModel::where(['title'=>$val[1]])->get()->toArray();
                if(!$question){
                    $question = new questionModel();
                    $question->type_id=$type[0]["id"];
                    $question->title=$val[1];
                    $question->dif_id=(int)$val[3];
                    $question->right=$val[4];
                    $question->save();
                    $question=questionModel::where(['title'=>$val[1]])->get()->toArray();
                }
                $excelid=$val[0];
                $index["$excelid"]=$question[0]['id'];
            }
            foreach($answer as $val){
                $excelid = (int)$val[0];
                $isset=$val[2];
                if(!answerModel::where(['question_id'=>$index["$excelid"],'title'=>$isset])->get()){
                    $answer =new answerModel();
                    $answer->question_id = $index["$excelid"];
                    $answer->no=$val[1];
                    $answer->title=$val[2];
                    $answer->score=(int)$val[3];
                    $answer->save();
                }
            }
        });
        return redirect(route('questionmanage'));
    }
    
}
