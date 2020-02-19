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



/*
 Documents
*/
Route::group(['prefix' => '/m', 'namespace' => 'm'], function ()
{
    Route::get('',                     'HomeController@index')->name('m.home.index');
    Route::get('about',                'HomeController@about')->name('m.home.about');
    Route::get('ajax',                 'HomeController@ajax')->name('m.home.ajax');
    Route::get('ajaxresult',           'HomeController@ajaxresult')->name('m.home.ajaxresult');
    Route::post('ajaxpostresult',      'HomeController@ajaxpostresult')->name('m.home.ajaxpostresult');
    Route::post('submitbarcode',       'HomeController@submitbarcode')->name('m.home.submitbarcode');

    Route::get('login',                'LoginController@showLoginForm')->name('m.login');
    Route::post('login',               'LoginController@login')->name('m.login.post');
    Route::post('logout',              'LoginController@logout')->name('m.logout');

    Route::group(['prefix' => '/readbarcode'], function () {
        Route::get('',                   'ReadBarCodeController@index')->name('m.readbarcode');
        Route::post('submitbarcode',     'ReadBarCodeController@submitbarcode')->name('m.readbarcode.submitbarcode');
    });

    Route::group(['prefix' => '/order'], function () {
        Route::get('',           'OrderController@index')->name('m.order');
        Route::post('',          'OrderController@submitbarcode')
            ->middleware('clean.barcode')
            ->name('m.order.submitbarcode');
        Route::get('edit/{id}',  'OrderController@edit')->name('m.order.edit');
        Route::post('edit/{id}', 'OrderController@submiteditbarcode')
            ->middleware('clean.barcode')
            ->name('m.order.submiteditbarcode');
    });

    Route::group(['prefix' => '/returnedinvoice'], function () {
        Route::get('',           'ReturnedInvoiceController@index')->name('m.returnedinvoice');
        Route::post('',          'ReturnedInvoiceController@submitbarcode')->name('m.returnedinvoice.submitbarcode');
        Route::get('edit/{id}',  'ReturnedInvoiceController@edit')->name('m.returnedinvoice.edit');
        Route::post('edit/{id}', 'ReturnedInvoiceController@submiteditbarcode')->name('m.returnedinvoice.submiteditbarcode');
    });

    Route::group(['prefix' => '/invoice'], function () {
        Route::get('',           'InvoiceController@index')->name('m.invoice');
        Route::post('',          'InvoiceController@submitbarcode')->name('m.invoice.submitbarcode');
        Route::get('edit/{id}',  'InvoiceController@edit')->name('m.invoice.edit');
        Route::post('edit/{id}', 'InvoiceController@submiteditbarcode')->name('m.invoice.submiteditbarcode');
    });

    Route::group(['prefix' => '/inventory'], function () {
        Route::get('',           'InventoryController@index')->name('m.inventory');
        Route::post('',          'InventoryController@submitbarcode')->name('m.inventory.submitbarcode');
        Route::get('create',     'InventoryController@create')->name('m.inventory.create');
        Route::post('store',     'InventoryController@store')->name('m.inventory.store');
        Route::get('edit/{id}',  'InventoryController@edit')->name('m.inventory.edit');
        Route::post('edit/{id}', 'InventoryController@submiteditbarcode')->name('m.inventory.submiteditbarcode');
    });
});


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

Route::get('/softwareupdate/{fileName}', 'api\v1\SoftwareUpdateController@GetFile');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/contact', 'HomeController@contact')->name('contact');
Route::get('/test', 'HomeController@test')->name('test');
Route::get('/integration1c', 'HomeController@integration1c')->name('integration1c');
Route::get('/categories',   'api\v1\CategoryController@indexAll')->middleware('auth')->name('categories');


//Route::get('/admin', 'SpaController@index')->middleware('auth')->name('admin');
Route::get('/admin', 'SpaController@index')->name('admin');
Route::get('/admin/{any}', 'SpaController@index')->where('any', '.*')->name('admin.any');