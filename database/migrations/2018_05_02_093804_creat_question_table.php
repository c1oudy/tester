<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('question', function (Blueprint $table) {
            $table->increments('id');    //increments自增,主键
            $table->string('title',50);      //integer类型
            $table->string('img',100);    //decimal浮点型
            $table->integer('no');
            $table->integer('type_id');
            $table->integer('dif_id');
        });
        Schema::create('experiment_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
        });
        Schema::create('difficulty', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
