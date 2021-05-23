<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout']);
Route::get('addEmployee/form', [App\Http\Controllers\HomeController::class, 'addEmployee']);
Route::post('addEmployee/store', [App\Http\Controllers\HomeController::class, 'addpostEmployee']);
Route::get('editEmployee/{id}/edittEmployee', [App\Http\Controllers\HomeController::class, 'edittEmployee']);
Route::post('editEmployee/edit', [App\Http\Controllers\HomeController::class, 'editpostEmployee']);
Route::get('deleteEmployee/{id}/deletteEmployee', [App\Http\Controllers\HomeController::class, 'deletteEmployee']);
Route::get('addCompany/form', [App\Http\Controllers\HomeController::class, 'addCompany']);
Route::post('addCompany/store', [App\Http\Controllers\HomeController::class, 'addpostCompany']);
Route::get('/companyList', [App\Http\Controllers\HomeController::class, 'companyList']);
Route::get('editCompany/{id}/edittCompany', [App\Http\Controllers\HomeController::class, 'edittCompany']);
Route::post('editCompany/edit', [App\Http\Controllers\HomeController::class, 'editpostCompany']);
Route::get('deleteCompany/{id}/deletteCompany', [App\Http\Controllers\HomeController::class, 'deletteCompany']);
