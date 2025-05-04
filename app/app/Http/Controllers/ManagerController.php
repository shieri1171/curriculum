<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;

class ManagerController extends Controller
{
    //管理画面トップ
    public function manager() {
        return view('management.manager');
    }

    public function manageruser(User $user) {

        $users = User::orderBy('created_at', 'desc')
                     ->get();

        return view('management.manager_user', compact('users'));
    }

    public function manageritem(Item $item) {

        $items = Item::with(['mainImage', 'itemImages'])
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('management.manager_item', compact('items'));
    }

    //ユーザー停止(論理削除)
    public function userdelflg(User $user) {
        $user -> del_flg = 1;

        $user -> save();

        return redirect()->route('manager.user');
    }

    //ユーザー復元処理
    public function userrestore($user_id)
    {
        $user = User::withoutGlobalScopes()->findOrFail($user_id);

        $user->del_flg = 0;
        $user->save();

        return redirect()->route('manager.user');
    }

    //商品論理削除
    public function itemdelflg(Item $item) {

        $item->del_flg = 1;
        $item->save();

        return redirect()->route('manager.item');
    }

    //商品復元処理
    public function itemrestore(Item $item)
    {
        $item->del_flg = 0;
        $item->save();

        return redirect()->route('manager.item');
    }

    //一般ユーザー⇔管理ユーザー
    public function userflg(User $user)
    {
        $user->user_flg = $user->user_flg === 1 ? 0 : 1;
        $user->save();

        return redirect()->route('manager.user');
    }

}
