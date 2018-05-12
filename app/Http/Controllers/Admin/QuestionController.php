<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin\difficultysModel;
use App\Admin\typeModel;

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
}
