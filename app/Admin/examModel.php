<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class examModel extends Model
{
    //
    const TABLE_NAME="exam";
    protected $table = self::TABLE_NAME;
    public $timestamps = false;
}
