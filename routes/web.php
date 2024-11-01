<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('formRegistrasi', [AuthController::class, 'formRegistrasi'])->name('auth.registrasi.form');
Route::post('registrasi', [AuthController::class, 'registrasi'])->name('auth.registrasi');
Route::get('formLogin', [AuthController::class, 'formLogin'])->name('auth.login.form');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/', [HomeController::class, 'index'])->name('home.index')->middleware('auth');

Route::get('tambahTugas', [HomeController::class, 'create'])->name('home.tambah');
Route::post('simpanTugas', [HomeController::class, 'store'])->name('home.simpan');
Route::put('updateStatus/{id}', [HomeController::class, 'updateStatus'])->name('home.update.status');
Route::DELETE('hapusTugas/{id}', [HomeController::class, 'destroy']);
Route::post('uploadGambar/{id}', [HomeController::class, 'uploadGambar'])->name('home.upload');

Route::post('logout', [AuthController::class, 'logout'])->name('logout');
