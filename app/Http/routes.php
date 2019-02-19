<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//登录页面相关路由
Route::get('/login', 'LoginController@login');
Route::post('/login', 'LoginController@dologin');   //验证登录
Route::get('logout', 'LoginController@logout');     //退出登录


//后台路由
Route::group(['middleware'=>'login'], function(){

    Route::get('admin','AdminController@index');

    //用户添加
    Route::get('user/add','UserController@add');
    Route::post('user/insert','UserController@insert');
    Route::get('/user/index', 'UserController@index');
    Route::get('/user/edit/{id}', 'UserController@edit');
    Route::post('/user/update', 'UserController@update');
    Route::get('/user/delete/{id}', 'UserController@delete');

    //文章分类路由
    Route::resource('/cate', 'CateController');

    //tag标签路由
    Route::resource('/tag', 'TagController');

    //文章路由
    Route::resource('/post', 'PostController');
});
//测试
Route::get('/test', 'PostController@test');
