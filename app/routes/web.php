<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DisplayController;
use App\Http\Controllers\RegistrationController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', [DisplayController::class, 'login'])->name('login');
Route::get('/signup', [DisplayController::class, 'signup'])->name('signup');

Route::get('/', [DisplayController::class, 'index']);

Route::get('/item', [DisplayController::class, 'item'])->name('item');
