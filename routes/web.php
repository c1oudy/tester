<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group(['namespace' => 'Home'], function(){
    Route::get('/examl', 'ExamController@examlist')->name('examl');
    Route::get('/evaluation', 'EvaluationController@index');
    Route::get('/practice-index', 'PracticeController@index');
    Route::get('/practice', 'PracticeController@practice')->name('practice');
    Route::get('/addclass', 'UserController@addclass')->name('addclass');
    Route::post('/useroperate', 'UserController@useroperate')->name('useroperate');
    Route::post('/getquestion', 'QuestionController@getquestion')->name('getquestion');
    Route::post('/questionoperate', 'QuestionController@questionoperate')->name('questionoperate');
    Route::post('/changecollect', 'QuestionController@changecollect')->name('changecollect');
    Route::get('/collect', 'UserController@collect');
    Route::get('/exam', 'ExamController@index')->name('exam');
    Route::post('/submitpaper', 'ExamController@submitpaper')->name('submitpaper');
});
Route::get('/adminlogin', 'Admin\LoginController@index');
Route::post('/adminchecklogin', 'Admin\LoginController@checklogin');
Route::group(['namespace' => 'Admin','middleware' => 'adminlogin'], function(){
    Route::get('/adminhome', 'HomeController@index')->name('adminhome');
    Route::get('/adminwelcome', 'HomeController@welcome')->name('adminwelcome');
    Route::get('/admintype', 'QuestionController@type')->name('admintype');
    Route::post('/addtype', 'QuestionController@addtype')->name('addtype');
    Route::get('/classlist', 'UserController@index')->name('classlist');
    Route::post('/editclass', 'UserController@editclass')->name('editclass');
    Route::get('/userlist', 'UserController@userlist')->name('userlist');
    Route::post('/homeuseroperate', 'UserController@useroperate')->name('homeuseroperate');
    Route::post('/uploaduser', 'UserController@uploaduser')->name('uploaduser');
    Route::get('/questionmanage', 'QuestionController@questionmanage')->name('questionmanage');
    Route::post('/uploadquestion', 'QuestionController@uploadquestion')->name('uploadquestion');
    Route::get('/examsetting', 'ExamController@examsetting')->name('examsetting');
    Route::get('/addexam', 'ExamController@addexam')->name('addexam');
    Route::post('/checktitle', 'ExamController@checktitle')->name('checktitle');
    Route::get('/examlist', 'ExamController@examlist')->name('examlist');
    Route::post('/exadowmloadexcelmlist', 'ExamController@dowmloadexcel')->name('dowmloadexcel');
});