<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DisplayController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ManagerController;
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

//パスワード変更他
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

//ユーザーページ
Route::get('/userpage/{user}', [UserController::class, 'userpage'])->name('userpage');

//停止ユーザー
Route::get('/freeze', function () {
    return view('users.freeze');
})->name('freeze');

Route::group(['middleware' => 'auth'], function() {

    //一覧
    Route::get('/favorites', [DisplayController::class, 'favorites'])->name('favorites'); //いいね一覧
    Route::get('/buys', [DisplayController::class, 'buys'])->name('buys'); //購入履歴
    Route::get('/follows', [DisplayController::class, 'follows'])->name('follows'); //フォロー一覧
    Route::get('/sells', [DisplayController::class, 'sells'])->name('sells'); //売上履歴

    //管理
    Route::get('/manager', [ManagerController::class, 'manager'])->name('manager');
    Route::get('/manager-user', [ManagerController::class, 'manageruser'])->name('manager.user');
    Route::get('/manager-item', [ManagerController::class, 'manageritem'])->name('manager.item');

    //user
    //削除(ユーザー処理)
    Route::delete('/user_delete/{user}', [UserController::class, 'userdelete'])->name('user.delete');
    //編集
    Route::get('/profile-edit/{user}', [UserController::class, 'profileedit'])->name('profile.edit');
    Route::post('/profile-edit-comp', [UserController::class, 'profileeditcomp'])->name('profile.edit.comp');
    //論理削除(管理者処理)
    Route::delete('/user_delflg/{user}', [ManagerController::class, 'userdelflg'])->name('user.delflg');
    // 復元
    Route::post('/user_restore/{user_id}', [ManagerController::class, 'userrestore'])->name('user.restore');
    //一般ユーザー⇔管理ユーザー
    Route::patch('/user_flg/{user}', [ManagerController::class, 'userflg'])->name('user.flg');

    //フォロー
    Route::post('/follow/{user}', [UserController::class, 'follow'])->name('follow');

    //item
    //新規登録
    Route::get('/item', [RegistrationController::class, 'item'])->name('item');
    Route::post('/item-conf', [RegistrationController::class, 'itemconf'])->name('item.conf');
    Route::post('/item-comp', [RegistrationController::class, 'itemcomp'])->name('item.comp');
    
    //削除(ユーザー処理)
    Route::delete('/item-delete/{item}', [RegistrationController::class, 'itemdelete'])->name('item.delete');
    //論理削除(管理者処理)
    Route::delete('/item_delflg/{item}', [ManagerController::class, 'itemdelflg'])->name('item.delflg');
    //復元
    Route::post('/item_restore/{item}', [ManagerController::class, 'itemrestore'])->name('item.restore');
    //編集
    Route::get('/item-edit/{item}', [RegistrationController::class, 'itemedit'])->name('item.edit');
    Route::post('/item-edit-conf/{item}', [RegistrationController::class, 'itemeditconf'])->name('item.edit.conf');
    Route::post('/item-edit-comp/{item}', [RegistrationController::class, 'itemeditcomp'])->name('item.edit.comp');
    //画像削除
    Route::delete('/item-image-delete/{image}', [RegistrationController::class, 'imagedelete'])->name('item.image.delete');

    //購入
    Route::get('/buy/{item}', [RegistrationController::class, 'buyitem'])->name('buy.item'); //条件分岐
    Route::get('/user-info', [UserController::class, 'userinfo'])->name('user.info'); //確認⇒修正の場合
    Route::post('/buy-conf', [RegistrationController::class, 'buyconf'])->name('buy.conf');
    Route::post('/buy-comp', [RegistrationController::class, 'buycomp'])->name('buy.comp');

    //いいね
    Route::post('/favorite', [RegistrationController::class, 'favorite'])->name('favorite');

    //コメント
    Route::post('/comment', [RegistrationController::class, 'comment'])->name('comment');

});