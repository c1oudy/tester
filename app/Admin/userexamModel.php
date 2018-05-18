<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class userexamModel extends Model
{
    //
    const TABLE_NAME="userexam";
    protected $table = self::TABLE_NAME;
    public $timestamps = false;
}
