<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\MealAdminController;
use App\Http\Controllers\MealFrontController;
use App\Http\Controllers\MealTypeController;
use App\Http\Controllers\DayController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\BookNowController;
use App\Http\Controllers\MealChangeController;
use App\Http\Controllers\ReportController;

Route::get('register', [AuthController::class, 'registerForm'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');
// Login
Route::get('mess', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::get('admin/dashboard/data', [AuthController::class, 'dashboardData']);
Route::get('admin/customer/meals', [AuthController::class, 'customerMeals']);
Route::get('admin/meal-change/meals', [AuthController::class, 'mealChangeMeals']);


Route::resource('meal-types', MealTypeController::class);
Route::resource('days', DayController::class);


Route::prefix('admin')->group(function () {

    // Meal Master
    Route::get('/meals', [MealAdminController::class,'meals']);
    Route::post('/meals/store', [MealAdminController::class,'storeMeal']);

    // Meal Mapping
    Route::get('/meal-map', [MealAdminController::class,'index']);
    Route::get('/meal-map/create', [MealAdminController::class,'create']);
    Route::post('/meal-map/store', [MealAdminController::class,'store']);

    Route::get('/meal-map/delete/{id}', [MealAdminController::class,'delete']);
 

});
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('reports', [ReportController::class, 'reports']);
    Route::get('reports/data', [ReportController::class, 'data']);
});



Route::get('book-now/success', [BookNowController::class, 'success']);

Route::get('/menu', [MealFrontController::class, 'index']);
Route::post('/menu/save', [MealFrontController::class, 'saveSelection']);

Route::get('/',[WebController::class,'index']);

Route::get('/book-now', [BookNowController::class, 'create']);
Route::post('/book-now/step1', [BookNowController::class, 'storeStep1']);

/* STEP 2 – MEAL SELECTION */
Route::get('/book-now/select-meal', [BookNowController::class, 'selectMeal']);
Route::post('/book-now/confirm', [BookNowController::class, 'storeMeals']);

Route::get('meal-change', [MealChangeController::class, 'index']);
// web.php
Route::get('ajax-search', [MealChangeController::class, 'ajaxSearch']);

Route::post('/meal-change/update', [MealChangeController::class, 'update']);
Route::post('meal-change/store', [MealChangeController::class, 'store']);

