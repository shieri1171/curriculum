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
Route::get('/', [DisplayController::class, 'index']);
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

    //user
    Route::group(['middleware' => 'can:view,User'], function() {
        //ユーザーページ
        Route::get('/User/{User}/detail', [DisplayController::class, 'UserDetail'])->name('User.detail');
        //削除(ユーザー処理)
        Route::post('/delete_User/{User}', [RegistrationController::class, 'DeleteUser'])->name('delete.User');
        //編集
        Route::get('/edit_User/{User}', [RegistrationController::class, 'editUserForm'])->name('edit.User');
        Route::post('/edit_User/{User}', [RegistrationController::class, 'editUser']);
        //論理削除(管理者処理)
        Route::post('/delflg_User/{User}', [RegistrationController::class, 'DelflgUser'])->name('delflg.User');
    });

    //item
    //新規登録
    Route::get('/item', [RegistrationController::class, 'item'])->name('item');
    Route::post('/item-conf', [RegistrationController::class, 'itemconf'])->name('item.conf');
    Route::post('/item-comp', [RegistrationController::class, 'itemcomp'])->name('item.comp');
    
    Route::group(['middleware' => 'can:view,item'], function() {
        //削除(管理・ユーザー)
        Route::post('/delete_item/{item}', [RegistrationController::class, 'Deleteitem'])->name('delete.item');
        //編集
        Route::get('/edit_item/{item}', [RegistrationController::class, 'edititemForm'])->name('edit.item');
        Route::post('/edit_item/{item}', [RegistrationController::class, 'edititem']);
        Route::post('/sellflg_item/{item}', [RegistrationController::class, 'sellflgitem'])->name('sellflg.item');
    });

});