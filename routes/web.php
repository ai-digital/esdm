<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;


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

Route::redirect('/', '/login');
Route::get('/login', [LoginController::class, 'login'])->name('login.index')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login')->middleware('guest');

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout')->middleware('auth');


Route::get('/home', [HomeController::class, 'index'])->name('home');
// Dashboard
Route::get('/dashboard-general-dashboard', function () {
    return view('backend.pages.dashboard-general-dashboard', ['type_menu' => 'dashboard']);
});
Route::group(['middleware' => ['auth']], function () {
    Route::resource('berita', BeritaController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('kategori', KategoriController::class);
    // Route::resource('products', ProductController::class);
});
Route::get('/modules-datatables', function () {
    return view('backend.pages.modules-datatables', ['type_menu' => 'modules']);
});