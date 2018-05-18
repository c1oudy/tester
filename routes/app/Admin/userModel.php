<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class userModel extends Model
{
    //
    const TABLE_NAME="users";
    protected $table = self::TABLE_NAME;
    public $timestamps = false;

    public function getlist(){
        return DB::table('users')         //将两张表拼接起来
        ->join('class', function($join)
        {
            $join->on('users.class_id', '=', 'class.id');
        })->select('users.id', 'users.name','users.email','class.name', 'users.statu')
            ->orderBy('users.statu', 'desc')
            ->get()->toArray();
    }
}
