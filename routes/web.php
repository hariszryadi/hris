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

    Route::group(['middleware' => ['auth:admin', 'role']], function () {
        
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
        Route::post('/transaction-leave/show', 'Admin\TransactionLeaveController@show')->name('admin.transactionLeave.show');

        /** Transaksi Lembur */
        Route::get('/transaction-overtime/index', 'Admin\TransactionOvertimeController@index')->name('admin.transactionOvertime.index');
        Route::post('/transaction-overtime/show', 'Admin\TransactionOvertimeController@show')->name('admin.transactionOvertime.show');

        /** Account Pegawai */
        Route::get('/account/index', 'Admin\AccountController@index')->name('admin.account.index');
        Route::get('/account/{id}/edit', 'Admin\AccountController@edit')->name('admin.account.edit');
        Route::post('/account/update', 'Admin\AccountController@update')->name('admin.account.update');
        Route::post('/account/change-status', 'Admin\AccountController@changeStatus')->name('admin.account.changeStatus');

        /** Import */
        Route::get('/import/index', 'Admin\ImportController@index')->name('admin.import.index');
        Route::post('/import/absencye', 'Admin\ImportController@importAbsencye')->name('admin.import.absencye');
        Route::post('/import/destroy', 'Admin\ImportController@destroy')->name('admin.import.destroy');

        /** Role */
        Route::get('/role/index', 'Admin\RoleController@index')->name('admin.role.index');
        Route::get('/role/create', 'Admin\RoleController@create')->name('admin.role.create');
        Route::post('/role/store', 'Admin\RoleController@store')->name('admin.role.store');
        Route::get('/role/{id}/edit', 'Admin\RoleController@edit')->name('admin.role.edit');
        Route::post('/role/update', 'Admin\RoleController@update')->name('admin.role.update');
        Route::post('/role/destroy', 'Admin\RoleController@destroy')->name('admin.role.destroy');
        Route::post('/role/dataTablePermission', 'Admin\RoleController@dataTablePermission')->name('admin.role.dataTablePermission');

        /** User Admin */
        Route::get('/user-admin/index', 'Admin\UserAdminController@index')->name('admin.userAdmin.index');
        Route::get('/user-admin/create', 'Admin\UserAdminController@create')->name('admin.userAdmin.create');
        Route::post('/user-admin/store', 'Admin\UserAdminController@store')->name('admin.userAdmin.store');
        Route::get('/user-admin/{id}/edit', 'Admin\UserAdminController@edit')->name('admin.userAdmin.edit');
        Route::post('/user-admin/update', 'Admin\UserAdminController@update')->name('admin.userAdmin.update');
        Route::post('/user-admin/destroy', 'Admin\UserAdminController@destroy')->name('admin.userAdmin.destroy');

        /** Change Password */
        Route::get('/change-password/index', 'Admin\ChangePasswordController@index')->name('admin.changePassword.index');
        Route::post('/change-password/update', 'Admin\ChangePasswordController@update')->name('admin.changePassword.update');

        /** Report */
        Route::get('/report/leave', 'Admin\ReportController@reportLeave')->name('admin.report.leave');
        Route::get('/report/leave/download', 'Admin\ReportController@downloadReportLeave')->name('admin.report.leave.download');
        Route::get('/report/overtime', 'Admin\ReportController@reportOvertime')->name('admin.report.overtime');
        Route::get('/report/overtime/download', 'Admin\ReportController@downloadReportOvertime')->name('admin.report.overtime.download');
    });
});

/** Empl */
Route::get('/', 'DashboardController@index')->middleware('auth:user')->name('dashboard');
Route::get('/{id}/profile-settings', 'DashboardController@profileSettings')->middleware('auth:user')->name('profileSettings');
Route::post('/update-profile', 'DashboardController@updateProfile')->name('updateProfile');

Route::get('/leave', 'LeaveController@index')->middleware('auth:user')->name('leave');
Route::post('/getInfoLeave', 'LeaveController@getInfoLeave')->name('getInfoLeave');
Route::post('/getCategoryLeave', 'LeaveController@getCategoryLeave')->name('getCategoryLeave');
Route::post('/getLeave', 'LeaveController@getLeave')->name('getLeave');
Route::post('/postLeave', 'LeaveController@postLeave')->name('postLeave');
Route::post('/getStatusRequestLeave', 'LeaveController@getStatusRequestLeave')->name('getStatusRequestLeave');
Route::post('/getEmplRequestLeave', 'LeaveController@getEmplRequestLeave')->name('getEmplRequestLeave');
Route::post('/updateStatusRequestLeave', 'LeaveController@updateStatusRequestLeave')->name('updateStatusRequestLeave');

Route::get('/overtime', 'OvertimeController@index')->middleware('auth:user')->name('overtime');
Route::post('/getInfoOvertime', 'OvertimeController@getInfoOvertime')->name('getInfoOvertime');
Route::post('/postOvertime', 'OvertimeController@postOvertime')->name('postOvertime');
Route::post('/getStatusRequestOvertime', 'OvertimeController@getStatusRequestOvertime')->name('getStatusRequestOvertime');
Route::post('/getEmplRequestOvertime', 'OvertimeController@getEmplRequestOvertime')->name('getEmplRequestOvertime');
Route::post('/updateStatusRequestOvertime', 'OvertimeController@updateStatusRequestOvertime')->name('updateStatusRequestOvertime');

Route::get('/login', 'LoginController@login')->middleware('guest')->name('login');
Route::post('/login', 'LoginController@credentials')->middleware('guest')->name('credentials');
Route::get('/logout', 'LoginController@logout')->middleware('auth:user')->name('logout');

Route::post('/save-token', 'FirebaseController@saveToken')->name('save-token');