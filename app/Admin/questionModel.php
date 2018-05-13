<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class questionModel extends Model
{
    //
    const TABLE_NAME="question";
    protected $table = self::TABLE_NAME;
    public $timestamps = false;
}
