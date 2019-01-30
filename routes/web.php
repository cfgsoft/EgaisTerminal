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
//Route::view('/', 'welcome');

Auth::routes();

Route::get('/m', 'm\HomeController@index')->name('m.home.index');
Route::get('/m/index', 'm\HomeController@index')->name('m.home.index');
Route::get('/m/about', 'm\HomeController@about')->name('m.home.about');
Route::get('/m/ajax', 'm\HomeController@ajax')->name('m.home.ajax');
Route::get('/m/ajaxresult', 'm\HomeController@ajaxresult')->name('m.home.ajaxresult');
Route::post('/m/ajaxpostresult', 'm\HomeController@ajaxpostresult')->name('m.home.ajaxpostresult');
Route::post('/m/submitbarcode', 'm\HomeController@submitbarcode')->name('m.home.submitbarcode');

Route::get('/m/readbarcode', 'm\ReadBarCodeController@index')->name('m.readbarcode');
Route::get('/m/readbarcode/index', 'm\ReadBarCodeController@index')->name('m.readbarcode.index');
Route::post('/m/readbarcode/submitbarcode', 'm\ReadBarCodeController@submitbarcode')->name('m.readbarcode.submitbarcode');
Route::post('/m/readbarcode/submitbarcodeajax', 'm\ReadBarCodeController@submitbarcodeajax')->name('m.readbarcode.submitbarcodeajax');

Route::get('/m/order', 'm\OrderController@index')->name('m.order');
Route::get('/m/order/index', 'm\OrderController@index')->name('m.order.index');
Route::get('/m/order/edit', 'm\OrderController@edit')->name('m.order.edit');
Route::post('/m/order/submitbarcode', 'm\OrderController@submitbarcode')->name('m.order.submitbarcode');
Route::post('/m/order/submiteditbarcode', 'm\OrderController@submiteditbarcode')->name('m.order.submiteditbarcode');

Route::get('/m/returnedinvoice', 'm\ReturnedInvoiceController@index')->name('m.returnedinvoice');
Route::get('/m/returnedinvoice/index', 'm\ReturnedInvoiceController@index')->name('m.returnedinvoice.index');
Route::get('/m/returnedinvoice/edit', 'm\ReturnedInvoiceController@edit')->name('m.returnedinvoice.edit');
Route::post('/m/returnedinvoice/submitbarcode', 'm\ReturnedInvoiceController@submitbarcode')->name('m.returnedinvoice.submitbarcode');
Route::post('/m/returnedinvoice/submiteditbarcode', 'm\ReturnedInvoiceController@submiteditbarcode')->name('m.returnedinvoice.submiteditbarcode');

Route::get('/m/invoice', 'm\InvoiceController@index')->name('m.invoice');
Route::get('/m/invoice/index', 'm\InvoiceController@index')->name('m.invoice.index');
Route::get('/m/invoice/edit', 'm\InvoiceController@edit')->name('m.invoice.edit');
Route::post('/m/invoice/submitbarcode', 'm\InvoiceController@submitbarcode')->name('m.invoice.submitbarcode');
Route::post('/m/invoice/submiteditbarcode', 'm\InvoiceController@submiteditbarcode')->name('m.invoice.submiteditbarcode');

Route::get('/m/login', 'm\LoginController@login')->name('m.login');
Route::post('/m/login/submitbarcode', 'm\LoginController@submitbarcode')->name('m.login.submitbarcode');

Route::get('/api/v1/utmegais', 'api\v1\UtmEgaisController@index')->name('api.v1.utmegais');
Route::get('/api/v1/utmegais/index', 'api\v1\UtmEgaisController@index')->name('api.v1.utmegais.index');
Route::get('/opt/in',  'api\v1\UtmEgaisController@opt_in');
Route::get('/opt/out', 'api\v1\UtmEgaisController@opt_out');
Route::get('/opt/out/WayBill_v3/{id?}', 'api\v1\UtmEgaisController@waybill_v3');
Route::get('/opt/out/FORM2REGINFO/{id?}', 'api\v1\UtmEgaisController@form2RegInfo');
Route::get('/opt/out/WayBillAct_v3/{id?}', 'api\v1\UtmEgaisController@wayBillAct_v3');
Route::get('/opt/out/ReplyRestBCode/{id?}', 'api\v1\UtmEgaisController@replyRestBCode');
Route::get('/info/certificate/RSA', 'api\v1\UtmEgaisController@rsa');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/contact', 'HomeController@contact')->name('contact');
Route::get('/test', 'HomeController@test')->name('test');


Route::get('/admin', 'SpaController@index')->name('admin');
//Route::get('/admin/{any}', 'SpaController@index')->where('any', '.*');