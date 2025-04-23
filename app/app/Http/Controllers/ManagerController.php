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

        $users = User::all();

        return view('management.manager_user', compact('users'));
    }

    public function manageritem(Item $item) {

        $items = Item::all();

        return view('management.manager_item', compact('items'));
    }

}
