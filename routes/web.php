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
Route::get('user/index','UserController@index');

//后台登录页路由
Route::get('admin/login','Admin\LoginController@login');
//验证码路由
Route::get('admin/captcha/{tmp}', 'Admin\LoginController@captcha');