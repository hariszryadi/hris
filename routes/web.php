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

/** Guest */

/** Admin */
Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', 'Admin\LoginController@login')->middleware('guest')->name('admin.login');
    Route::post('/login', 'Admin\LoginController@credentials')->middleware('guest')->name('admin.credentials');
    Route::get('/logout', 'Admin\LoginController@logout')->middleware('auth:admin')->name('admin.logout');
    Route::get('/dashboard', function () {
        return view('backend.dashboard');
    })->middleware('auth:admin')->name('admin.dashboard');

    Route::group(['middleware' => 'auth:admin'], function () {
        
        /** Divisi */
        Route::get('/division/index', 'Admin\DivisionController@index')->name('admin.division.index');
        Route::get('/division/create', 'Admin\DivisionController@create')->name('admin.division.create');
        Route::post('/division/store', 'Admin\DivisionController@store')->name('admin.division.store');
        Route::get('/division/{id}/edit', 'Admin\DivisionController@edit')->name('admin.division.edit');
        Route::post('/division/update', 'Admin\DivisionController@update')->name('admin.division.update');
        Route::post('/division/destroy', 'Admin\DivisionController@destroy')->name('admin.division.destroy');

        /** Pegawai */
        Route::get('/employee/index', 'Admin\EmployeeController@index')->name('admin.employee.index');
        Route::get('/employee/create', 'Admin\EmployeeController@create')->name('admin.employee.create');
        Route::post('/employee/store', 'Admin\EmployeeController@store')->name('admin.employee.store');
        Route::get('/employee/{id}/edit', 'Admin\EmployeeController@edit')->name('admin.employee.edit');
        Route::post('/empoyee/update', 'Admin\EmployeeController@update')->name('admin.employee.update');
        Route::post('/employee/destroy', 'Admin\EmployeeController@destroy')->name('admin.employee.destroy');

        /** Kategori Cuti/Izin */
        Route::get('/category-leave/index', 'Admin\CategoryLeaveController@index')->name('admin.categoryLeave.index');
        Route::get('/category-leave/create', 'Admin\CategoryLeaveController@create')->name('admin.categoryLeave.create');
        Route::post('/category-leave/store', 'Admin\CategoryLeaveController@store')->name('admin.categoryLeave.store');
        Route::get('/category-leave/{id}/edit', 'Admin\CategoryLeaveController@edit')->name('admin.categoryLeave.edit');
        Route::post('/category-leave/update', 'Admin\CategoryLeaveController@update')->name('admin.categoryLeave.update');
        Route::post('/category-leave/destroy', 'Admin\CategoryLeaveController@destroy')->name('admin.categoryLeave.destroy');

        /** Slider */
        Route::get('/slider/index', 'Admin\SliderController@index')->name('admin.slider.index');
        Route::get('/slider/create', 'Admin\SliderController@create')->name('admin.slider.create');
        Route::post('/slider/store', 'Admin\SliderController@store')->name('admin.slider.store');
        Route::get('/slider/{id}/edit', 'Admin\SliderController@edit')->name('admin.slider.edit');
        Route::post('/slider/update', 'Admin\SliderController@update')->name('admin.slider.update');
        Route::post('/slider/destroy', 'Admin\SliderController@destroy')->name('admin.slider.destroy');

        /** Transaksi Cuti/Izin */
        Route::get('/transaction-leave/index', 'Admin\TransactionLeaveController@index')->name('admin.transactionLeave.index');

        /** Account Pegawai */
        Route::get('/account/index', 'Admin\AccountController@index')->name('admin.account.index');
        Route::get('/account/{id}/edit', 'Admin\AccountController@edit')->name('admin.account.edit');
        Route::post('/account/update', 'Admin\AccountController@update')->name('admin.account.update');
        Route::post('/account/change-status', 'Admin\AccountController@changeStatus')->name('admin.account.changeStatus');
    });
});

/** Empl */

Route::get('/profile', function () {
    return view('frontend.profile');
})->middleware('auth:user')->name('profile');

Route::get('/', 'DashboardController@index')->middleware('auth:user')->name('dashboard');

Route::get('/leave', 'LeaveController@index')->middleware('auth:user')->name('leave');
Route::post('/getCategoryLeave', 'LeaveController@getCategoryLeave')->name('getCategoryLeave');
Route::post('/getLeave', 'LeaveController@getLeave')->name('getLeave');
Route::post('/postLeave', 'LeaveController@postLeave')->name('postLeave');

Route::get('/overtime', 'OvertimeController@index')->middleware('auth:user')->name('overtime');
Route::post('/postOvertime', 'OvertimeController@postOvertime')->name('postOvertime');

Route::get('/settings', function () {
    return view('frontend.settings');
})->middleware('auth:user')->name('settings');

Route::get('/login', 'LoginController@login')->middleware('guest')->name('login');
Route::post('/login', 'LoginController@credentials')->middleware('guest')->name('credentials');
Route::get('/logout', 'LoginController@logout')->middleware('auth:user')->name('logout');