<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'],
    function ()
    {
        Route::post('login', 'Auth\LoginController@loginApi');
        Route::middleware('auth:api')->post('logout', 'Auth\LoginController@logoutApi');
        Route::post('register', 'Auth\RegisterController@register');
    }
);


Route::group(
    ['middleware' => 'auth:api',
     'prefix' => '/v1',
     'namespace' => 'Api\V1',
     'as' => 'api.',
    ],
    function ()
    {
        //Route::post('/login','AuthController@postLogin');
        //Route::post('/register','AuthController@postRegister');
        //Route::middleware('APIToken')->group(function () {
        //    Route::post('/logout','AuthController@postLogout');
        //});

        Route::get('orders/indexMarkLine',  'OrderController@indexMarkLine');
        Route::get('orders/indexErrorLine', 'OrderController@indexErrorLine');
        Route::put('orders/updateMarkLine/{id}', 'OrderController@updateMarkLine');

        Route::get('orders/MarkLine',       'OrderController@indexMarkLine1c');
        Route::put('orders/MarkLine/{id}',  'OrderController@updateMarkLine1c');
        Route::get('orders/PackLine',       'OrderController@indexPackLine1c');
        Route::put('orders/PackLine/{id}',  'OrderController@updatePackLine1c');
        Route::get('orders/ErrorLine',      'OrderController@indexErrorLine1c');
        Route::put('orders/ErrorLine/{id}', 'OrderController@updateErrorLine1c');

        Route::get('returnedinvoices/MarkLine',      'ReturnedInvoiceController@indexMarkLine');
        Route::put('returnedinvoices/MarkLine/{id}', 'ReturnedInvoiceController@updateMarkLine');

        Route::get('invoices/indexReadLine',  'InvoiceController@indexReadLine');
        Route::put('invoices/updateReadLine/{id}', 'InvoiceController@updateReadLine');

        Route::resource('categories',       'CategoryController',   ['except' => ['create', 'edit']]);
        Route::resource('products',         'ProductController',    ['except' => ['create', 'edit']]);
        Route::resource('orders',           'OrderController',      ['except' => ['create', 'edit']]);
        Route::resource('excisestamps',     'ExciseStampController',        ['except' => ['create', 'edit']]);
        Route::resource('excisestampbox',   'ExciseStampBoxController',     ['except' => ['create', 'edit']]);
        Route::resource('excisestamppallet','ExciseStampPalletController',  ['except' => ['create', 'edit']]);
        Route::resource('returnedinvoices', 'ReturnedInvoiceController',    ['except' => ['create', 'edit']]);
        Route::resource('invoices',         'InvoiceController',    ['except' => ['create', 'edit']]);
    }
);