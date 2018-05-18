<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class difficultysModel extends Model
{
    //
    const TABLE_NAME="difficulty";
    protected $table = self::TABLE_NAME;
    public $timestamps = false;
}
