<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class collectModel extends Model
{
    //
    const TABLE_NAME="collect";
    protected $table = self::TABLE_NAME;
    public $timestamps = false;
}
