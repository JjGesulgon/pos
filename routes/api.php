<?php

// Auth
Route::post('/auth/login', 'AuthController@apiLogin');

Route::group(['middleware' => ['auth:api']], function () {
    // Logout
    Route::post('/auth/logout', 'AuthController@apiLogout')->name('logout');

    // Get Authenticated User
    Route::get('/auth/user', 'AuthController@user');

    // Contacts
    Route::match(['put', 'patch'], 'contacts/{contact}/restore', 'ContactsController@restore');
    Route::delete('contacts/{contact}/force-delete', 'ContactsController@forceDestroy');
    Route::get('contacts/get-all-contacts', 'ContactsController@getAllContacts');
    Route::resource('contacts', 'ContactsController', [
        'only' => [
            'index', 'store', 'show', 'update', 'destroy'
        ]
    ]);

    // Corporations
    Route::match(['put', 'patch'], 'corporations/{corporation}/restore', 'CorporationsController@restore');
    Route::delete('corporations/{corporation}/force-delete', 'CorporationsController@forceDestroy');
    Route::get('corporations/get-all-corporations', 'CorporationsController@getAllCorporations');
    Route::resource('corporations', 'CorporationsController', [
        'only' => [
            'index', 'store', 'show', 'update', 'destroy'
        ]
    ]);

    // Items
    Route::match(['put', 'patch'], 'items/{item}/restore', 'ItemsController@restore');
    Route::delete('items/{item}/force-delete', 'ItemsController@forceDestroy');
    Route::get('items/get-all-items', 'ItemsController@getAllItems');
    Route::resource('items', 'ItemsController', [
        'only' => [
            'index', 'store', 'show', 'update', 'destroy'
        ]
    ]);

    // Sales Item Prices
    Route::match(['put', 'patch'], 'sales-item-prices/{salesItemPrice}/restore', 'SalesItemPricesController@restore');
    Route::delete('sales-item-prices/{salesItemPrice}/force-delete', 'SalesItemPricesController@forceDestroy');
    Route::get('sales-item-prices/get-sales-item-prices/{salesItemPrice}', 'SalesItemPricesController@getSalesItemPrices');
    Route::resource('sales-item-prices', 'SalesItemPricesController', [
        'only' => [
            'index', 'store', 'show', 'update', 'destroy'
        ]
    ]);

    // Stocks
    Route::match(['put', 'patch'], 'stocks/{stock}/restore', 'StocksController@restore');
    Route::delete('stocks/{stock}/force-delete', 'StocksController@forceDestroy');
    Route::get('stocks/get-all-stocks', 'StocksController@getAllStock');
    Route::get('stocks/get-all-stocks/{locationType}', 'StocksController@getAllStockPerLocationType');
    Route::get('stocks/{item}/get-all-stocks-of-item', 'StocksController@getAllStocksOfItem');
    Route::resource('stocks', 'StocksController', [
        'only' => [
            'index', 'store', 'show', 'update', 'destroy'
        ]
    ]);

    // Transactions
    Route::match(['put', 'patch'], 'transactions/{transaction}/restore', 'TransactionsController@restore');
    Route::delete('transactions/{transaction}/force-delete', 'TransactionsController@forceDestroy');
    Route::resource('transactions', 'TransactionsController', [
        'only' => [
            'index', 'store', 'show', 'update', 'destroy'
        ]
    ]);

    // Users
    Route::match(['put', 'patch'], 'users/{user}/restore', 'UsersController@restore');
    Route::delete('users/{user}/force-delete', 'UsersController@forceDestroy');
    Route::resource('users', 'UsersController', [
        'only' => [
            'index', 'store', 'show', 'update', 'destroy'
        ]
    ]);
});
