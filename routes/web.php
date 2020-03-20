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

Route::group(['middleware' => 'MyMiddleware'], function () {
    Route::get('categories', 'categoryController@index');
    Route::post('notifications', 'categoryController@notifications');                                        //admin
    Route::get('notifications', 'categoryController@notifications');
    Route::get('demands', 'categoryController@demands');                                                     //admin -----> validated
    Route::post('store', 'categoryController@store');
    Route::get('/home', 'categoryController@index')->name('home');

    Route::get('/changePassword', function () {return view('scoutViews.changePassword');});            // validation needed
    Route::post('/change', 'categoryController@change')->name('change');                                     // validation needed
    Route::get('/match', 'categoryController@match')->name('match');

    Route::post('delete_notification', 'categoryController@delete_notification');                            //admin -----> validated
    Route::post('accept_notification', 'categoryController@accept_notification');                            //admin -----> validated
    Route::post('accept_all_notification', 'categoryController@accept_all_notification');                    //admin -----> validated
    Route::post('delete_all_notification', 'categoryController@delete_all_notification');                    //admin -----> validated

    Route::get('notifications_user/ack/{id}', 'categoryController@notifications_user_ack');
    Route::get('notifications_user/cancel_request/{id}', 'categoryController@cancel_request');

    Route::get('add_category', 'categoryController@add_category');                                           //admin -----> validated
    Route::post('create', 'categoryController@create')->name('create');                                      //admin
    Route::post('update/{id}', 'categoryController@update');                                                 //admin
    Route::get('delete/{id}', 'categoryController@destroy')->name('delete');                                 //admin -----> validated
    Route::get('restore/{id}', 'categoryController@restore')->name('restore');                               //admin -----> validated
    Route::get('deleteForever/{id}', 'categoryController@deleteForever')->name('deleteForever');             //admin -----> validated

});

Auth::routes();


