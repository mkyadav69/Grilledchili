<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Merchant\DashboardController;
use App\Http\Controllers\Merchant\TrucksController;
use App\Http\Controllers\Merchant\TrucksSettingController;
use App\Http\Controllers\ReportController;

# 1. Registraion & Login
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register-merchant', [AuthController::class, 'registerMerchant'])->name('register_merchant');

Route::get('login', [AuthController::class, 'viewLogin'])->name('login');
Route::get('merchant-login', [AuthController::class, 'merchantLogin'])->name('merchant_login');
Route::get('merchant-otp', [AuthController::class, 'OtpVerificationPage'])->name('merchant_otp');
Route::post('merchant-auth', [AuthController::class, 'authMerchant'])->name('auth_merchant');


# 1. Authentications & Login
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

# 2. Dashboard
Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('get-data', [DashboardController::class, 'getData'])->name('get_data');


# **************** GrilledChili  route & functions **************

# 1. Truck
Route::get('show-trucks', [TrucksController::class, 'showTrucks'])->name('show_trucks');
Route::post('store-trucks', [TrucksController::class, 'storeTrucks'])->name('store_trucks');
Route::get('get-trucks', [TrucksController::class, 'getTrucks'])->name('get_trucks');
Route::post('edit-trucks/{id}',  [TrucksController::class, 'updateTrucks'])->name('edit_trucks');
Route::post('delete-trucks/{id}',  [TrucksController::class, 'deleteTrucks'])->name('delete_trucks');

# 2. Truck Setting
Route::get('show-trucks-setting', [TrucksSettingController::class, 'showTrucksSetting'])->name('show_trucks_setting');
Route::post('store-trucks-setting', [TrucksSettingController::class, 'storeTrucksSetting'])->name('store_trucks_setting');
Route::get('get-trucks-setting', [TrucksSettingController::class, 'getTrucksSetting'])->name('get_trucks_setting');
Route::post('edit-trucks-setting/{id}',  [TrucksSettingController::class, 'updateTrucksSetting'])->name('edit_trucks_setting');
Route::post('delete-trucks-setting/{id}',  [TrucksSettingController::class, 'deleteTrucksSetting'])->name('delete_trucks_setting');

# 3.  Export data
Route::get('download-report', [ReportController::class, 'downloadReport'])->name('download_report');
