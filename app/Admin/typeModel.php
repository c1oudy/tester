<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class typeModel extends Model
{
    //
    const TABLE_NAME="experiment_type";
    protected $table = self::TABLE_NAME;
    public $timestamps = false;
}
