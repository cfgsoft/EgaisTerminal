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

Route::get('/m/home', 'm\HomeController@index')->name('m.home.index');
Route::get('/m/about', 'm\HomeController@about');
Route::post('/m/submitbarcode', 'm\HomeController@submitbarcode');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/contact', 'HomeController@about')->name('contact');
