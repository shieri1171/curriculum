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

    public function signup(Request $request) {

        return view('Auth.signup', [
            'email' => $request->query('email'),
            'username' => $request->query('username')
        ]);
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
    public function profileedit(User $user) {

        return view('users.profile_edit', compact('user'));

    }

    public function profileeditcomp(Request $request, User $user) {
        if ($request->hasFile('image')) {
        $path = $request->file('image')->store('user_images', 'public');
        $user->image = $path;
        }

        $user = auth()->user();
        $user->username = $request['username'];
        $user->profile = $request['profile'];
        $user->name = $request['name'];
        $user->tel = $request['tel'];
        $user->postcode = $request['postcode'];
        $user->address = $request['address'];

        $user->save();

        return view('users.profile_edit_comp');
    }

    //アカウント削除
    public function userdelete() {
        $user = auth()->user();
        $user->delete();

        \Session::flash('err_msg', '削除しました。');
        return view('top');
    }

    //フォロー
    public function follow(Request $request) {
        $user = auth()->user();
        $followId = $request->input('follow_id');

        $already = Follow::where('follower_id', $user->id)
                    ->where('follow_id', $followId)
                    ->first();

        if ($already) {
            $already->delete();
            return response()->json(['status' => 'unfollowed']);
        } else {
            Follow::create([
                'follower_id' => $user->id,
                'follow_id' => $followId,
            ]);
            return response()->json(['status' => 'followed']);
        }
    }

}