<?php

/*
 * The API_ROUTE file defines all the api, that would be part of the api v1.
 */

/**
 * API VERSION 1.0.0 routing mechanism
 */
#'middleware' => [ 'cors' ]
Route::group(['prefix' => 'api/v1', 'namespace' => 'api\v1'], function () {
    /**
     * User routes
     */

    // Open routes ( NO REST VERIFICATIONS ON THESE ROUTES )
    Route::any('user/login', 'UserController@login');

    Route::get('forgotpassword/{username}',         'PasswordResetController@create');      // create PIN
    Route::post('requestaccess/create', 'RequestAccessController@create');                  // Create Request Access
    if (Config::get('oss.demo.enabled'))
    {
    	Route::post('user/create',  'UserController@create');                                   // C    ->  Create Users and get ID
    }
    /*
     * These routes are protected by REST API token
     */
    Route::group(['middleware' => 'rest_auth'], function () {

        /**
         * Request Access API routes
         */

        Route::get('requestaccess',             'RequestAccessController@index');         // Get all Request accesses
        Route::post('requestaccess/show/{id}',  'RequestAccessController@show');          // Show request access by ID

	if (!Config::get('oss.demo.enabled'))
        {
            Route::post('user/create',  'UserController@create');                                   // C    ->  Create Users and get ID
        }

        /**
         * Country API routes
         */
        Route::get('country',                    'CountryController@index');            // Get list of region and selected by user
        Route::get('country/{id}/region',        'CountryController@region');           // Set selected region
        /**
         * Region API routes
         */
        Route::get('region',                    'RegionController@index');            // Get list of region and selected by user
        Route::get('region/{id}/countries',     'RegionController@countries');        // Get countries by region
        Route::post('region/set',               'RegionController@store');            // Set selected region
        Route::get('region/{id}/users',         'RegionController@users');            // Get list of users based on region API


        /**
         * Company API routes
         */
        Route::get('company',                   'CompanyController@index');         // Get list of the companies
        Route::get('company/{id}',              'CompanyController@show');          // Get a company by ID
        Route::get('company/{id}/users',        'CompanyController@users');         // Get users by company by ID
        Route::post('company/{id}',             'CompanyController@update');        // Update a company by ID
        Route::post('company/create',           'CompanyController@store');         // Create a company
        Route::delete('company/{id}',           'CompanyController@destroy');       // Delete a company by ID
        Route::get('company/{id}/products',     'CompanyController@products');          // Get a company by ID


        /**
         * Report API routes
         */
        Route::get('report',            'ReportController@index');          // Show all the reports
        Route::get('report/show/{id}',  'ReportController@show');           // Show report by ID
        Route::post('report/create',    'ReportController@create');         // Create a report


        /**
         * Document API routes
         */
        Route::get('doc',                       'DocController@index');     // Show all docs
        Route::get('doc/{doc_type}/{lang?}',    'DocController@show');      // Show doc by type and lang


        /**
         * User notification api
         */
        Route::get('notificationsettings',                 'NotificationSettingController@index');
        Route::get('notificationsettings/{identifier}',    'NotificationSettingController@toggle');


        /**
         * Password Reset Api
         */
        Route::post('password_reset/{id}',  'PasswordResetController@update');


        /**
         * User API routes
         */
        Route::get('user',                              'UserController@index');        // list all users
        Route::get('user/suspend',                      'UserController@suspend');        // list all users
        Route::get('user/{id}',                         'UserController@show');         // R    ->  Read users data by ID
        Route::post('user/{id}',                        'UserController@update');       // U    ->  Update users data by ID
        Route::post('user/{id}/company/{company_id}',   'UserController@company');      // Add user to a company
        Route::post('user/logout',                      'UserController@logout');       // Logout
        Route::delete('user/{id}',                      'UserController@destroy');      // D    ->  Delete users data by ID
        Route::get('user/{id}/products',                'UserController@products');     // Get list of products by user ID.
        Route::get('user/read_terms',                   'UserController@read_terms');     // Get list of products by user ID.
        Route::post('user/verify_pin',                  'UserController@pin');     // Get list of products by user ID.
        Route::any('user/push_register',               'UserController@register_push'); // register a session for push notifications

        /**
         * Role API routes
         */
        Route::get('role',                                  'RoleController@index');                // list all roles
        Route::get('role/{id}/user/{user_id}',              'RoleController@attach_user');
        Route::get('role/{id}/permission/{permission_id}',  'RoleController@attach_permission');
        Route::get('role/{id}',                             'RoleController@show');
        Route::post('role/create',                          'RoleController@store');
        Route::post('role/{id}',                            'RoleController@update');
        Route::delete('role/{id}',                          'RoleController@destroy');


        /**
         * Permission API
         */
        Route::get('permission',        'PermissionController@index');               // list all roles
        Route::get('permission/{id}',   'PermissionController@show');                // list all roles


        /**
         * Category API routes
         */
        Route::get('category',                      'CategoryController@index');            // Get All Categories
        Route::get('category/main',                 'CategoryController@main');             // Get Main Categories
        Route::get('category/{id}',                 'CategoryController@show');             // Get Category and Sub-category by ID
        Route::get('category/{id}/parent',          'CategoryController@parent');           // Get Parent Category of sub-category
        Route::get('category/{id}/products',        'CategoryController@products');         // Get Products by category id
        Route::post('category/{id}/image/add',      'CategoryController@add');              // Add an image to category
        Route::get('category/image/remove/{id}',    'CategoryController@remove');           // remove an image to category

        /**
         * Product API routes
         */
        Route::get('product',                               'ProductController@index');
        Route::get('product/{id}',                          'ProductController@show');
        Route::post('product/{id}',                         'ProductController@update');
        Route::post('product/create',                       'ProductController@create');
        Route::post('product/approve/{id}',                 'ProductController@approve');
        Route::delete('product/{id}',                       'ProductController@destroy');
        Route::get('product/{id}/flag/{identifier}/add',    'ProductController@add_flag');
        Route::get('product/{id}/flag/{identifier}/remove', 'ProductController@remove_flag');
        Route::get('product/image/{id}/remove',             'ProductController@remove_image');


        /**
         * Product Flag API
         */
        Route::get('flag',                   'ProductFlagController@index');
        Route::post('flag/{id}',              'ProductFlagController@update');
        Route::delete('flag/{id}',           'ProductFlagController@destroy');


        /**
         * Alert API routes
         */
        Route::get('alert',             'AlertController@index');
        Route::get('alert/{id}/seen',   'AlertController@seen');


        /**
         * Offer API routes
         */
        Route::get('offer/{id}',            'OfferController@show');
        Route::get('offer/create/{id}',     'OfferController@store');
        Route::get('offer/deny/{id}',       'OfferController@deny');
        Route::get('offer/approve/{id}',    'OfferController@approve');


        /**
         * Contract API routes
         */
        Route::get('contract',                                      'ContractController@index');
        Route::get('contract/user/{id}',                            'ContractController@user');         // Super user call
        Route::get('contract/company/{id}',                         'ContractController@company');      // Super user call
        Route::post('contract/create',                              'ContractController@store');
        Route::get('contract/folder/{id}',                          'ContractController@folder');
        Route::get('contract/tree',                                 'ContractController@tree');
        Route::get('contract/document/{id}',                        'ContractController@document');
        Route::delete('contract/{id}',                              'ContractController@destroy');
        Route::get('contract/{id}/folder/{folder_id}',              'ContractController@move');
        Route::get('contract/{id}/transaction/{transaction_id}',    'ContractController@transaction');


        /**
         * Transaction API routes
         */
        Route::get('transaction',                               'TransactionController@index');
        Route::get('transaction/{id}',                          'TransactionController@show');
        Route::get('transaction/user/{id}',                     'TransactionController@user');
        Route::get('transaction/company/{id}',                  'TransactionController@company');
        Route::get('transaction/approve/{id}',                  'TransactionController@approve');
        Route::get('transaction/deny/{id}',                     'TransactionController@deny');
        Route::get('transaction/require_validation/{id}',       'TransactionController@require_validation');
        Route::get('transaction/validated/{id}',                'TransactionController@validated');
        Route::get('transaction/validation_failed/{id}',        'TransactionController@validation_failed');
        Route::delete('transaction/{id}',                       'TransactionController@destroy');

        /**
         * SendBird API
         */
        Route::get('message',               'MessageController@index');             // Receive message for the current user
        Route::post('message/send',         'MessageController@message');            // Send message for the current user
        Route::post('message/contract',     'MessageController@contract');          // Send message for the current user
        Route::post('message/channel',      'MessageController@channel');


        Route::post('message/refresh',      'MessageController@refresh');           // Keep refreshing this
        Route::post('message/open',         'MessageController@open');              // Called when the chat is opened
        Route::post('message/reload',       'MessageController@reload');            // Reload the chat messages

        /**
         * Rating API
         */
        Route::post('rate',       'RatingController@create');
    });

});
