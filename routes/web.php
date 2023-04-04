<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\ProjectCategoryController;
use App\Http\Controllers\PersonnelCategoryController;
use App\Http\Controllers\MembershipCategoryController;
use App\Http\Controllers\PartnershipCategoryController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::view('home', 'backend.home')->name('home');
    Route::view('account','backend.account')->name('account');

    Route::get('/home', [HomeController::class, 'home'])->name('home');

    Route::resource('/partnership/category', PartnershipCategoryController::class, ['as' => 'partnership']);
    Route::resource('/partnership/catalog', PartnershipController::class, ['as' => 'partnership']);

    Route::resource('/membership/category', MembershipCategoryController::class, ['as' => 'membership']);
    Route::resource('/membership/catalog', MembershipController::class, ['as' => 'membership']);

    Route::resource('/personnel/category',PersonnelCategoryController::class, ['as' => 'personnel']);
    Route::resource('/personnel/catalog', PersonnelController::class, ['as' => 'personnel']);

    Route::resource('/project/category', ProjectCategoryController::class, ['as' => 'project']);
    Route::resource('/project/catalog', ProjectController::class, ['as' => 'project']);

    Route::resource('/profile', ProfileController::class, ['as' => 'profile']);
    // Route::resource('/settings', SettingController::class, ['as' => 'settings']);
});
