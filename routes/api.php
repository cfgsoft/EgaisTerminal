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
        Route::group(['prefix' => '/orders'], function () {
            Route::get('indexMarkLine',       'OrderController@indexMarkLine');
            Route::get('indexErrorLine',      'OrderController@indexErrorLine');
            Route::put('updateMarkLine/{id}', 'OrderController@updateMarkLine');

            Route::get('MarkLine',       'OrderController@indexMarkLine1c');
            Route::put('MarkLine/{id}',  'OrderController@updateMarkLine1c');
            Route::get('PackLine',       'OrderController@indexPackLine1c');
            Route::put('PackLine/{id}',  'OrderController@updatePackLine1c');
            Route::get('ErrorLine',      'OrderController@indexErrorLine1c');
            Route::put('ErrorLine/{id}', 'OrderController@updateErrorLine1c');
        });

        Route::group(['prefix' => '/returnedinvoices'], function () {
            Route::get('MarkLine', 'ReturnedInvoiceController@indexMarkLine');
            Route::put('MarkLine/{id}', 'ReturnedInvoiceController@updateMarkLine');
        });

        Route::group(['prefix' => '/invoices'], function () {
            Route::get('indexReadLine', 'InvoiceController@indexReadLine');
            Route::put('updateReadLine/{id}', 'InvoiceController@updateReadLine');
        });

        Route::get('categories/indexAll',   'CategoryController@indexAll');

        Route::post('productsegais/store-batch',    'ProductEgaisController@storeBatch');
        Route::post('clientsegais/store-batch',     'ClientEgaisController@storeBatch');
        Route::post('excisestamps/store-batch',     'ExciseStampController@storeBatch');

        Route::resource('categories',       'CategoryController',   ['except' => ['create', 'edit']]);
        Route::resource('products',         'ProductController',    ['except' => ['create', 'edit']]);
        Route::resource('departments',      'DepartmentController',      ['only' => ['store', 'update']]);
        Route::resource('productsegais',    'ProductEgaisController',    ['only' => ['store', 'update']]);
        Route::resource('clientsegais',     'ClientEgaisController',     ['only' => ['store', 'update']]);
        Route::resource('transportmodules', 'TransportModuleController', ['only' => ['store', 'update']]);
        Route::resource('orders',           'OrderController',      ['except' => ['create', 'edit']]);
        Route::resource('excisestamps',     'ExciseStampController',        ['except' => ['create', 'edit']]);
        Route::resource('excisestampbox',   'ExciseStampBoxController',     ['except' => ['create', 'edit']]);
        Route::resource('excisestamppallet','ExciseStampPalletController',  ['except' => ['create', 'edit']]);
        Route::resource('returnedinvoices', 'ReturnedInvoiceController',    ['except' => ['create', 'edit']]);
        Route::resource('invoices',         'InvoiceController',    ['except' => ['create', 'edit']]);
    }
);

Route::group(
    ['prefix' => '/v1',
     'namespace' => 'Api\V1',
     'as' => 'api.',
    ],
    function ()
    {
        Route::resource('departments',      'DepartmentController', ['only' => ['index', 'show']]);
        Route::resource('inventories',      'InventoryController',  ['only' => ['index', 'show', 'store']]);

        Route::group(['prefix' => '/invoicesLic'], function () {
            Route::get('{id}', 'InvoiceController@indexLic');
            //Route::put('MarkLine/{id}', 'ReturnedInvoiceController@updateMarkLine');
        });
    }
);

Route::get('categories/indexAll',   'Api\V1\CategoryController@indexAll'); //->middleware('auth');