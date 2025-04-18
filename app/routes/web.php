<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DisplayController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

//トップページ
Route::get('/', [DisplayController::class, 'index'])->name('top');
//商品検索
Route::get('/item/search', [DisplayController::class, 'search'])->name('item.search');
//商品詳細
Route::get('/item/{item}/info', [DisplayController::class, 'iteminfo'])->name('item.info');
//ログイン
Route::get('/login', [UserController::class, 'login'])->name('login');
//ユーザー新規登録
Route::get('/signup', [UserController::class, 'signup'])->name('signup');
Route::post('/signup-conf', [UserController::class, 'signupconf'])->name('signup.conf');
Route::post('/signup-comp', [UserController::class, 'signupcomp'])->name('signup.comp');


//パスワード変更

Route::group(['middleware' => 'auth'], function() {

    //一覧
    Route::get('/item/favorites', [DisplayController::class, 'favorites'])->name('item.favorites');

    //user
    //ユーザーページ
    // Route::get('/User/{User}/detail', [DisplayController::class, 'UserDetail'])->name('User.detail');
    //削除(ユーザー処理)
    // Route::post('/delete_User/{User}', [RegistrationController::class, 'DeleteUser'])->name('delete.User');
    //編集
    // Route::get('/edit_User/{User}', [RegistrationController::class, 'editUserForm'])->name('edit.User');
    // Route::post('/edit_User/{User}', [RegistrationController::class, 'editUser']);
    //論理削除(管理者処理)
    // Route::post('/delflg_User/{User}', [RegistrationController::class, 'DelflgUser'])->name('delflg.User');

    //item
    //新規登録
    Route::get('/item', [RegistrationController::class, 'item'])->name('item');
    Route::post('/item-conf', [RegistrationController::class, 'itemconf'])->name('item.conf');
    Route::post('/item-comp', [RegistrationController::class, 'itemcomp'])->name('item.comp');
    
    //削除(管理・ユーザー)
    Route::delete('/delete_item/{item}', [RegistrationController::class, 'Deleteitem'])->name('delete.item');
    //編集
    Route::get('/edit-item/{item}', [RegistrationController::class, 'edititem'])->name('edit.item');
    Route::put('/edit-item-conf/{item}', [RegistrationController::class, 'edititemconf'])->name('edit.item.conf');
    Route::post('/edit-item-comp/{item}', [RegistrationController::class, 'edititemcomp'])->name('edit.item.comp');
    //画像削除
    Route::delete('/delete-item-image/{image}', [RegistrationController::class, 'deleteImage'])->name('delete.item.image');

    //購入
    Route::get('/buy/{item}', [RegistrationController::class, 'buyitem'])->name('buy.item');
    Route::get('/user-info', [UserController::class, 'userinfo'])->name('user.info');
    Route::post('/buy-conf', [RegistrationController::class, 'buyconf'])->name('buy.conf');
    Route::post('/buy-comp', [RegistrationController::class, 'buycomp'])->name('buy.comp');

});