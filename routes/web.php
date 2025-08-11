<?php

// Welcome Page
Route::view('/', 'auth.login');
Auth::routes();

// Admin Group
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {

    // Dashboard
    Route::get('/', 'HomeController@index')->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::get('users/history', 'UsersController@history')->name('users.history');
    Route::resource('users', 'UsersController');

    // Old Files
    Route::get('oldfiles/index', 'OldfilesController@index')->name('oldfiles.index');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Uploads
    Route::delete('uploads/destroy', 'UploadsController@massDestroy')->name('uploads.massDestroy');
    Route::post('uploads/media', 'UploadsController@storeMedia')->name('uploads.storeMedia');
    Route::post('uploads/ckmedia', 'UploadsController@storeCKEditorImages')->name('uploads.storeCKEditorImages');
    Route::get('uploads/downloadall', 'UploadsController@downloadall')->name('uploads.downloadall');
    Route::get('uploads/remove', 'UploadsController@remove')->name('uploads.remove');
    Route::resource('uploads', 'UploadsController');

});

// Profile Group
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {

    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});

// Frontend Group
Route::group(['as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::resource('users', 'UsersController');

    // Profile CRUD
    Route::get('frontend/profile', 'ProfileController@index')->name('profile.index');
    Route::post('frontend/profile', 'ProfileController@update')->name('profile.update');
    Route::post('frontend/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    Route::post('frontend/profile/password', 'ProfileController@password')->name('profile.password');

    // History CRUD
    Route::get('frontend/history', 'HistoryController@index')->name('history.index');

    // Upload CRUD
    Route::get('uploads/index', 'UploadsController@index')->name('uploads.index');
    Route::get('uploads/create', 'UploadsController@create')->name('uploads.create');
    Route::post('uploads/record_download', 'UploadsController@record_download')->name('uploads.record_download');
    Route::post('uploads/stream_download', 'UploadsController@stream_download')->name('uploads.stream_download');
    Route::delete('uploads/destroy', 'UploadsController@massDestroy')->name('uploads.massDestroy');
    Route::post('uploads/media', 'UploadsController@storeMedia')->name('uploads.storeMedia');
    Route::post('uploads/store', 'UploadsController@store')->name('uploads.store');
    Route::post('uploads/ckmedia', 'UploadsController@storeCKEditorImages')->name('uploads.storeCKEditorImages');


});
