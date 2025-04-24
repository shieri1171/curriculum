<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    //ログイン
    public function login() {
        return view('Auth.login');
    }

    public function signup() {

        return view('Auth.signup');
    }

    //新規登録
    public function signupconf(Request $request) {

        $request->session()->put([
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ]);

        return view('Auth.signup_conf');
    }

    public function signupcomp(Request $request) {
        $user = new User;

        $user->email = $request->session()->get('email');
        $user->username = $request->session()->get('username');
        $user->password = Hash::make($request->session()->get('password'));

        $user->save();

        $request->session()->forget(['email', 'username', 'password']);

        return view('Auth.signup_comp');
    }

    //ユーザーページ(マイページ含む)
    public function userpage(User $user) {

        $items = $user->item()->with('mainImage')->latest()->get();

        return view('users.userpage', compact('user', 'items'));
    }

    //購入者情報登録
    public function userinfo(Request $request)
    {
        $user = User::find(session('user_id'));

        return view('users.user_info', compact('user'));
    }

    //プロフィール修正
    public function editprofile(User $user) {
        //image username profile name tel postcode addressの修正
        // nullの場所は空欄で他は登録されてる値を入力した状態で表示
        return view('users.profile_edit');
    }

    public function editprofilecomp() {
        //usertable更新
        //登録カラム image username profile name tel postcode address
        return view('users.profile_edit_comp');
    }
    
}