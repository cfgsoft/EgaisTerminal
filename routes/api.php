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

Route::group(
    ['prefix' => '/v1',
     'namespace' => 'Api\V1',
     'as' => 'api.'
    ],
    function ()
    {
        Route::get('orders/indexMarkLine',  'OrderController@indexMarkLine');
        Route::get('orders/indexerrorline', 'OrderController@indexErrorLine');
        Route::put('orders/updateMarkLine/{id}', 'OrderController@updateMarkLine');

        Route::get('returnedinvoices/indexMarkLine',  'ReturnedInvoiceController@indexMarkLine');
        Route::put('returnedinvoices/updateMarkLine/{id}', 'ReturnedInvoiceController@updateMarkLine');

        Route::resource('categories',       'CategoryController',   ['except' => ['create', 'edit']]);
        Route::resource('products',         'ProductController',    ['except' => ['create', 'edit']]);
        Route::resource('orders',           'OrderController',      ['except' => ['create', 'edit']]);
        Route::resource('excisestamps',     'ExciseStampController',     ['except' => ['create', 'edit']]);
        Route::resource('excisestampbox',   'ExciseStampBoxController',  ['except' => ['create', 'edit']]);
        Route::resource('returnedinvoices', 'ReturnedInvoiceController', ['except' => ['create', 'edit']]);
        Route::resource('invoices',         'InvoiceController',    ['except' => ['create', 'edit']]);
    }
);