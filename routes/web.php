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

Route::get('/m', 'm\HomeController@index')->name('m.home.index');
Route::get('/m/index', 'm\HomeController@index')->name('m.home.index');
Route::get('/m/about', 'm\HomeController@about')->name('m.home.about');
Route::post('/m/submitbarcode', 'm\HomeController@submitbarcode')->name('m.home.submitbarcode');

Route::get('/m/readbarcode', 'm\ReadBarCodeController@index')->name('m.readbarcode');
Route::get('/m/readbarcode/index', 'm\ReadBarCodeController@index')->name('m.readbarcode.index');
Route::post('/m/readbarcode/submitbarcode', 'm\ReadBarCodeController@submitbarcode')->name('m.readbarcode.submitbarcode');

Route::get('/m/order', 'm\OrderController@index')->name('m.order');
Route::get('/m/order/index', 'm\OrderController@index')->name('m.order.index');
Route::get('/m/order/edit', 'm\OrderController@edit')->name('m.order.edit');
Route::post('/m/order/submitbarcode', 'm\OrderController@submitbarcode')->name('m.order.submitbarcode');
Route::post('/m/order/submiteditbarcode', 'm\OrderController@submiteditbarcode')->name('m.order.submiteditbarcode');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/contact', 'HomeController@about')->name('contact');
