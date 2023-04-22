<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Frontsite\BookController;
use App\Http\Controllers\Frontsite\ContentController;
use App\Http\Controllers\Frontsite\MusicController;
use App\Http\Controllers\GeneralPageController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [BookController::class, 'index'])->name('home');


$controller_path = 'App\Http\Controllers';
// Main Page Route
Route::get('/dashboard', $controller_path . '\dashboard\Analytics@index')->name('dashboard-analytics');

// pages
Route::get('/pages/account-settings-account', $controller_path . '\pages\AccountSettingsAccount@index')->name('pages-account-settings-account');
Route::get('/pages/account-settings-notifications', $controller_path . '\pages\AccountSettingsNotifications@index')->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', $controller_path . '\pages\AccountSettingsConnections@index')->name('pages-account-settings-connections');
Route::get('/pages/misc-error', $controller_path . '\pages\MiscError@index')->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', $controller_path . '\pages\MiscUnderMaintenance@index')->name('pages-misc-under-maintenance');

// authentication
Route::get('/auth/login-basic', $controller_path . '\authentications\LoginBasic@index')->name('auth-login-basic');
Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name('auth-register-basic');
Route::get('/auth/forgot-password-basic', $controller_path . '\authentications\ForgotPasswordBasic@index')->name('auth-reset-password-basic');


Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/logout', [LogoutController::class, 'perform'])->name('logout');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/unauthorized', [GeneralPageController::class, 'returnPage401'])->name('unauthorized');
Route::get('music/search', [MusicController::class, 'search'])->name('music.search');
Route::post('content', [ContentController::class, 'store'])->name('content.add');
Route::put('content', [ContentController::class, 'update'])->name('content.update');
Route::delete('content', [ContentController::class, 'destroy'])->name('content.destroy');
Route::get('content/{id}', [ContentController::class, 'show'])->name('content.detail');
Route::post('book/music/', [MusicController::class, 'addMusic']);
Route::get('book/music/{id}', [MusicController::class, 'show']);
Route::get('book/{id}', [BookController::class, 'show']);
Route::post('book/{id}/music', [MusicController::class, 'getMusicList']);

