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

    public function userinfo(Request $request)
    {
        $user = Item::find(session('user_id'));
        $back = $request->input('back', null); // hidden で受け取る

        return view('users.user_info', compact('user', 'back'));
    }
}