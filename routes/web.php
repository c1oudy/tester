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
    Route::get('/exam', 'ExamController@index');
    Route::get('/evaluation', 'EvaluationController@index');
    Route::get('/practice-index', 'PracticeController@index');
    Route::get('/practice', 'PracticeController@practice');
});
Route::get('/adminlogin', 'Admin\LoginController@index');
Route::post('/adminchecklogin', 'Admin\LoginController@checklogin');
Route::group(['namespace' => 'Admin','middleware' => 'adminlogin'], function(){
    Route::get('/adminhome', 'HomeController@index');

});