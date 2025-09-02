<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\PatientController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
	Route::get('/dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::resource('hospitals', HospitalController::class)->except(['show']);
	Route::resource('patients', PatientController::class)->except(['show']);
});
