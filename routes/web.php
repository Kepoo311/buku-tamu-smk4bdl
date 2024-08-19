<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeControler;
use App\Http\Controllers\ListTamuController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\CheckGuest;
use App\Http\Middleware\CheckLogin;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', [HomeControler::class,'index'])->name('home');

Route::post('/add/data',[ListTamuController::class,'addData']);

Route::get('/admin',[DashboardController::class,'index'])->middleware(CheckLogin::class)->name('dash');

Route::post('/admin', [DashboardController::class, 'filter'])->middleware(CheckLogin::class)->name('data-tamu.filter');

Route::post('data-tamu/export-all', [DashboardController::class, 'exportAll'])->name('data-tamu.export-all');
Route::post('data-tamu/export-month', [DashboardController::class, 'exportMonth'])->name('data-tamu.export-month');
Route::post('data-tamu/export-date', [DashboardController::class, 'exportDate'])->name('data-tamu.export-date');


Route::get('/login', function () {
    return view('login');
})->middleware(CheckGuest::class)->name('login');

Route::post('/login',[LoginController::class,'login']);
Route::post('/logout',[LoginController::class,'logout']);
