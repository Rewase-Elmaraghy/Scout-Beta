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



Route::group(['middleware'=>'MyMiddleware'],function()
{
    Route::get('categories','categoryController@index');
    Route::get('eachCategory/{id}','categoryController@show');
    Route::get('notifications','categoryController@notifications');                   //admin
    Route::post('eachCategory/{id}/store','categoryController@store');
    Route::get('/home', 'categoryController@index')->name('home');

    Route::get('delete_notification/{id}','categoryController@delete_notification');  //admin
    Route::get('accept_notification/{id}','categoryController@accept_notification');  //admin

    Route::get('notifications_user/ack/{id}','categoryController@notifications_user_ack');
    Route::get('notifications_user/cancel_request/{id}','categoryController@cancel_request');

    Route::get('add_category','categoryController@add_category');                      //admin
    Route::post('create','categoryController@create')->name('create');                 //admin
    Route::post('update/{id}','categoryController@update');                            //admin
    Route::get('delete/{id}','categoryController@destroy')->name('delete');            //admin
    Route::get('restore/{id}','categoryController@restore')->name('restore');          //admin
    Route::get('deleteForever/{id}','categoryController@deleteForever')->name('deleteForever');               //admin
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
