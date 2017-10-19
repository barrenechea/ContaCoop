<?php

Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login']);
Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::get('/', function () {
	return redirect()->route('login');
});

Route::group(['middleware' => ['auth', 'init']], function () {
	Route::get('home', 'HomeController@index');

	// Route group for new stuff
	Route::group(['prefix' => 'new'], function () {
		Route::group(['prefix' => 'voucher', 'middleware' => ['can:add_voucher']], function () {
			Route::get('income', 'VoucherController@newIncomeGet');
			Route::post('income', 'VoucherController@newIncomePost');

			Route::get('outcome', 'VoucherController@newOutcomeGet');
			Route::post('outcome', 'VoucherController@newOutcomePost');

			Route::get('transfer', 'VoucherController@newTransferGet');
			Route::post('transfer', 'VoucherController@newTransferPost');
		});

		Route::group(['middleware' => ['can:manage_app']], function () {
			Route::post('account', 'AccountController@new');
			Route::post('bank', 'BankController@new');
			Route::post('identification', 'IdentificationController@new');
		});
	});

	// Route group for update stuff
	Route::group(['prefix' => 'update'], function () {
		Route::group(['middleware' => ['can:manage_app']], function () {
			Route::post('account', 'AccountController@update');
			Route::post('bank', 'BankController@update');
			Route::post('identification', 'IdentificationController@update');

			Route::get('sysconfig', 'SystemController@index');
			Route::post('sysconfig', 'SystemController@updateSysConfig');
		});

		Route::get('voucher/{id}', 'VoucherController@updateGet');
		Route::post('voucher', 'VoucherController@updatePost');
	});

	// Route group for listing stuff
	Route::group(['prefix' => 'list'], function () {
		Route::group(['middleware' => ['can:manage_app']], function () {
			Route::get('accounts', 'AccountController@list');
			Route::get('identifications', 'IdentificationController@list');
			Route::get('banks', 'BankController@list');
		});
	});

	// Route group for deleting stuff
	Route::group(['prefix' => 'delete'], function () {
		Route::group(['middleware' => ['can:manage_app']], function () {
			Route::post('account', 'AccountController@delete');
			Route::post('bank', 'BankController@delete');
			Route::post('identification', 'IdentificationController@delete');
		});

		Route::get('voucher/{id}', 'VoucherController@delete')->middleware('can:delete_voucher');
	});

	// Route group for downloading excel files
	Route::group(['prefix' => 'excel'], function () {
		Route::group(['middleware' => ['can:manage_app']], function () {
			Route::get('accounts', 'ExcelController@getAccounts');
			Route::get('banks', 'ExcelController@getBanks');
			Route::get('identifications', 'ExcelController@getIdentifications');
		});
	});

	// Route group for finding stuff
	Route::group(['prefix' => 'find', 'middleware' => ['can:view_voucher']], function () {
		Route::post('voucher', 'VoucherController@searchVoucher');
	});

	// Route group for voucher visualization
	Route::group(['prefix' => 'view'], function () {
		Route::get('voucher/{type}/{sequence}', 'VoucherController@viewVoucher')->middleware('can:view_voucher');

		Route::post('folios', 'VoucherController@generateFolios');

		Route::get('logs', 'SystemController@getLogs')->middleware('can:view_log');
	});

	// Route group for report generation
	Route::group(['prefix' => 'report', 'middleware' => ['can:view_reports']], function () {
		Route::post('logbook', 'ExcelController@logBook');
		Route::get('generalledger', 'ExcelController@generalLedger');
	});

	// Route group for voucher synchronization
	Route::group(['prefix' => 'sync', 'middleware' => ['can:sync_voucher']], function () {
		Route::get('index', 'SyncController@index');
	});

	// Debug shit and migration
	Route::group(['prefix' => 'debug'], function () {
		Route::group(['prefix' => 'retrieve'], function () {
			Route::get('accounts', 'DebugController@retrieveAccounts');
			Route::get('identifications', 'DebugController@retrieveIdentifications');
			Route::get('banks', 'DebugController@retrieveBanks');
		});
	});
	
});