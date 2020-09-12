<?php

use Illuminate\Support\Facades\Route;

// Login
Route::post('/auth/login', 'AuthController@apiLogin');

Route::group(['middleware' => ['api']], function () {
    // Logout
    Route::post('/auth/logout', 'AuthController@apiLogout')->name('logout');

    // Get Authenticated User
    Route::get('/auth/user', 'AuthController@user');

    // Branches
    Route::match(['put', 'patch'], '/branches/{contact}/restore', 'BranchesController@restore');
    Route::delete('/branches/{contact}/force-delete', 'BranchesController@forceDestroy');
    Route::get('/branches/search', 'BranchesController@search');
    Route::apiResource('branches', 'BranchesController');

    // Contacts
    Route::match(['put', 'patch'], '/contacts/{contact}/restore', 'ContactsController@restore');
    Route::delete('/contacts/{contact}/force-delete', 'ContactsController@forceDestroy');
    Route::get('/contacts/search', 'ContactsController@search');
    Route::apiResource('contacts', 'ContactsController');

    // Contact Types
    Route::match(['put', 'patch'], '/cotactss-type/{contactType}/restore', 'ContactTypesController@restore');
    Route::delete('/contact-types/{contactType}/force-delete', 'ContactTypesController@forceDestroy');
    Route::get('/contact-types/get-all-contact-types', 'ContactTypesController@getAllContactTypes');
    Route::apiResource('contact-types', 'ContactTypesController');

    // Corporations
    Route::match(['put', 'patch'], '/corporations/{corporation}/restore', 'CorporationsController@restore');
    Route::delete('/corporations/{corporation}/force-delete', 'CorporationsController@forceDestroy');
    Route::get('/corporations/get-all-corporations', 'CorporationsController@getAllCorporations');
    Route::apiResource('corporations', 'CorporationsController');

    // Documents
    Route::post('/documents/get-reference-number-total-count', 'DocumentsController@getReferenceNumberTotalCount');
    Route::post('/documents/get-number-total-count', 'DocumentsController@getNumberTotalCount');

    // Items
    Route::match(['put', 'patch'], '/items/{item}/restore', 'ItemsController@restore');
    Route::delete('/items/{item}/force-delete', 'ItemsController@forceDestroy');
    Route::get('/items/search-for-purchase', 'ItemsController@searchForPurchase');
    Route::get('/items/search-for-sales', 'ItemsController@searchForSales');
    Route::get('/items/search', 'ItemsController@search');
    Route::apiResource('items', 'ItemsController');

    // Item Types
    Route::match(['put', 'patch'], '/item-types/{itemType}/restore', 'ItemTypesController@restore');
    Route::delete('/item-types/{itemType}/force-delete', 'ItemTypesController@forceDestroy');
    Route::get('/item-types/search', 'ItemTypesController@search');
    Route::apiResource('item-types', 'ItemTypesController');

    // Measuring Mass
    Route::match(['put', 'patch'], '/measuring-mass/{measuringMass}/restore', 'MeasuringMassController@restore');
    Route::delete('/measuring-mass/{measuringMass}/force-delete', 'MeasuringMassController@forceDestroy');
    Route::get('/measuring-mass/search', 'MeasuringMassController@search');
    Route::apiResource('measuring-mass', 'MeasuringMassController');

    // Mode Of Payments
    Route::match(['put', 'patch'], '/mode-of-payments/{mode-of-payment}/restore', 'ModeOfPaymentsController@restore');
    Route::delete('/mode-of-payments/{mode-of-payment}/force-delete', 'ModeOfPaymentsController@forceDestroy');
    Route::get('/mode-of-payments/get-all-mode-of-payments', 'ModeOfPaymentsController@getAllModeOfPayments');
    Route::apiResource('mode-of-payments', 'ModeOfPaymentsController');

    // Sales Item Prices
    Route::match(['put', 'patch'], '/sales-item-prices/{salesItemPrice}/restore', 'SalesItemPricesController@restore');
    Route::delete('/sales-item-prices/{salesItemPrice}/force-delete', 'SalesItemPricesController@forceDestroy');
    Route::get('/sales-item-prices/get-sales-item-prices/{salesItemPrice}', 'SalesItemPricesController@getSalesItemPrices');
    Route::apiResource('sales-item-prices', 'SalesItemPricesController');

    // Stocks
    Route::match(['put', 'patch'], '/stocks/{stock}/restore', 'StocksController@restore');
    Route::delete('/stocks/{stock}/force-delete', 'StocksController@forceDestroy');
    Route::get('/stocks/get-all-stocks', 'StocksController@getAllStock');
    Route::get('/stocks/get-all-stocks/{locationType}', 'StocksController@getAllStockPerLocationType');
    Route::get('/stocks/{item}/get-all-stocks-of-item', 'StocksController@getAllStocksOfItem');
    Route::apiResource('stocks', 'StocksController');

    // Transactions
    Route::match(['put', 'patch'], '/transactions/{transaction}/restore', 'TransactionsController@restore');
    Route::delete('/transactions/{transaction}/force-delete', 'TransactionsController@forceDestroy');
    Route::post('/transactions/get-total-transactions', 'TransactionsController@getTotalTransaction');
    Route::apiResource('transactions', 'TransactionsController');

    // Users
    Route::match(['put', 'patch'], '/users/{user}/restore', 'UsersController@restore');
    Route::delete('/users/{user}/force-delete', 'UsersController@forceDestroy');
    Route::apiResource('users', 'UsersController');

    // Warehouses
    Route::match(['put', 'patch'], '/warehouses/{warehouse}/restore', 'WarehousesController@restore');
    Route::delete('/warehouses/{warehouse}/force-delete', 'WarehousesController@forceDestroy');
    Route::get('/warehouses/search', 'WarehousesController@search');
    Route::apiResource('warehouses', 'WarehousesController');
});
