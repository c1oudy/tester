<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class messageModel extends Model
{
    //
    const TABLE_NAME="message";
    protected $table = self::TABLE_NAME;
    public $timestamps = false;
}
