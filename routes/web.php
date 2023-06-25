<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontEndController;

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

//Route::redirect('/', '/superman');
Route::get('/', [FrontEndController::class, 'index']);
Route::get('/superman', [LoginController::class, 'login'])->name('superman')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login')->middleware('guest');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');





// Dashboard
Route::get('/dashboard-general-dashboard', function () {
    return view('backend.pages.dashboard-general-dashboard', ['type_menu' => 'dashboard']);
});
Route::group(['middleware' => 'prevent-back-history'], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::resource('berita', BeritaController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('kategori', KategoriController::class);
        // Route::resource('products', ProductController::class);
    });
});
Route::get('/modules-datatables', function () {
    return view('backend.pages.modules-datatables', ['type_menu' => 'modules']);
});