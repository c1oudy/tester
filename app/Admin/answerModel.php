<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class answerModel extends Model
{
    //
    const TABLE_NAME="answer";
    protected $table = self::TABLE_NAME;
    public $timestamps = false;
}
