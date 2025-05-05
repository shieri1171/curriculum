<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Item;
use App\Models\Follow;

use App\Http\Requests\Createuser;
use App\Http\Requests\Createbuy;
use App\Http\Requests\Createprofile;


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
    public function signupconf(Createuser $request) {

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
    public function userinfo(Createbuy $request)
    {
        $user = User::find(session('user_id'));

        return view('users.user_info', compact('user'));
    }

    //プロフィール修正
    public function profileedit(User $user) {

        return view('users.profile_edit', compact('user'));

    }

    public function profileeditcomp(Createprofile $request, User $user) {
        $user = auth()->user();
        
        if ($request->hasFile('image')) {
        $path = $request->file('image')->store('user_images', 'public');
        $user->image = $path;
        }

        $user->username = $request['username'];
        $user->profile = $request['profile'];
        $user->name = $request['name'];
        $user->tel = $request['tel'];
        $user->postcode = $request['postcode'];
        $user->address = $request['address'];

        $user->save();

        return view('users.profile_edit_comp', compact('user'));
    }

    //アカウント削除
    public function userdelete() {
        $user = auth()->user();
        $user->delete();

        return view('top');
    }

    //フォロー
    public function follow($followId) {

        $user = auth()->user();
        
        $isFollowing  = Follow::where('follower_id', $user->id)
                        ->where('follow_id', $followId)
                        ->first();

        if ($isFollowing ) {
            $isFollowing ->delete();
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