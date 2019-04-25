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

Route::group(
    ['prefix' => '/m'
    ],
    function ()
    {
        Route::get('', 'm\HomeController@index')->name('m.home.index');
        //Route::get('/index', 'm\HomeController@index')->name('m.home.index');
        Route::get('/about', 'm\HomeController@about')->name('m.home.about');
        Route::get('/about', 'm\HomeController@about')->name('m.home.about');
        Route::get('/ajax', 'm\HomeController@ajax')->name('m.home.ajax');
        Route::get('/ajaxresult', 'm\HomeController@ajaxresult')->name('m.home.ajaxresult');
        Route::post('/ajaxpostresult', 'm\HomeController@ajaxpostresult')->name('m.home.ajaxpostresult');
        Route::post('/submitbarcode', 'm\HomeController@submitbarcode')->name('m.home.submitbarcode');

        Route::get('/readbarcode', 'm\ReadBarCodeController@index')->name('m.readbarcode');
        Route::get('/readbarcode/index', 'm\ReadBarCodeController@index')->name('m.readbarcode.index');
        Route::post('/readbarcode/submitbarcode', 'm\ReadBarCodeController@submitbarcode')->name('m.readbarcode.submitbarcode');
        Route::post('/readbarcode/submitbarcodeajax', 'm\ReadBarCodeController@submitbarcodeajax')->name('m.readbarcode.submitbarcodeajax');

        Route::get('/order',  'm\OrderController@index')->name('m.order');
        Route::post('/order', 'm\OrderController@submitbarcode')->name('m.order.submitbarcode');
        Route::get('/order/edit/{id}',  'm\OrderController@edit')->name('m.order.edit');
        Route::post('/order/edit/{id}', 'm\OrderController@submiteditbarcode')->name('m.order.submiteditbarcode');

        Route::get('/returnedinvoice',  'm\ReturnedInvoiceController@index')->name('m.returnedinvoice');
        Route::post('/returnedinvoice', 'm\ReturnedInvoiceController@submitbarcode')->name('m.returnedinvoice.submitbarcode');
        //Route::get('/returnedinvoice/index', 'm\ReturnedInvoiceController@index')->name('m.returnedinvoice.index');
        Route::get('/returnedinvoice/edit/{id}',  'm\ReturnedInvoiceController@edit')->name('m.returnedinvoice.edit');
        Route::post('/returnedinvoice/edit/{id}', 'm\ReturnedInvoiceController@submiteditbarcode')->name('m.returnedinvoice.submiteditbarcode');
        //Route::post('/returnedinvoice/submitbarcode', 'm\ReturnedInvoiceController@submitbarcode')->name('m.returnedinvoice.submitbarcode');
        //Route::post('/returnedinvoice/submiteditbarcode', 'm\ReturnedInvoiceController@submiteditbarcode')->name('m.returnedinvoice.submiteditbarcode');

        Route::get('/invoice',  'm\InvoiceController@index')->name('m.invoice');
        Route::post('/invoice', 'm\InvoiceController@submitbarcode')->name('m.invoice.submitbarcode');
        Route::get('/invoice/edit/{id}',  'm\InvoiceController@edit')->name('m.invoice.edit');
        Route::post('/invoice/edit/{id}', 'm\InvoiceController@submiteditbarcode')->name('m.invoice.submiteditbarcode');
    }
);

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
Route::get('/opt/out/TTNHistoryF2Reg/{id?}', 'api\v1\UtmEgaisController@TTNHistoryF2Reg');
Route::get('/info/certificate/RSA', 'api\v1\UtmEgaisController@rsa');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/contact', 'HomeController@contact')->name('contact');
Route::get('/test', 'HomeController@test')->name('test');
Route::get('/integration1c', 'HomeController@integration1c')->name('integration1c');
Route::get('/categories',   'api\v1\CategoryController@indexAll')->middleware('auth')->name('categories');


//Route::get('/admin', 'SpaController@index')->middleware('auth')->name('admin');
Route::get('/admin', 'SpaController@index')->name('admin');
Route::get('/admin/{any}', 'SpaController@index')->where('any', '.*')->name('admin.any');