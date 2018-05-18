<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class classModel extends Model
{
    //
    const TABLE_NAME="class";
    protected $table = self::TABLE_NAME;
    public $timestamps = false;
}
