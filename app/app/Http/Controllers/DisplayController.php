<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Buy;
use App\Models\Follow;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class DisplayController extends Controller
{
    //top
    public function index() {

        $user = Auth::user();

        $items = Item::with('mainImage')
                    ->where('sell_flg', 0)
                    ->inRandomOrder()
                    ->get();
        
        return view('top', compact('items', 'user'));
    }

    //検索
    public function search(Request $request)
    {
        $user = Auth::user();
        $query = Item::query();

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('itemname', 'LIKE', "%{$keyword}%")
                ->orWhere('presentation', 'LIKE', "%{$keyword}%");
            });
        }

        if ($request->filled('price_range')) {
            [$min, $max] = explode('-', $request->input('price_range'));
            $query->whereBetween('price', [(int)$min, (int)$max]);
        }

        $items = $query->with('mainImage')->get();

        return view('ichiran.item_search', compact('items', 'user'));
    }

    //商品詳細
    public function iteminfo(Item $item) {

        $item->load('itemImages', 'comments');
        $comments = $item->comments;
        $user = Auth::user();

        if($user && auth()->user()->id !== $item->user_id) {
            $isFavorited = Favorite::where('user_id', auth()->id())
            ->where('item_id', $item->id)
            ->exists();
    
            return view ('items.item_info', compact('item', 'isFavorited', 'user', 'comments'));

        } else {
            return view ('items.item_info', compact('item'));
        }
    }

    //ユーザーページ(マイページ含む)
    public function userpage(User $user) {
        //authにてボタン条件変更
        //usertableから情報取得
    }


    //いいね一覧
    public function favorites(Request $request)
    {
        $user = Auth::user();

        $favoriteItems = $user->favoriteItems;

        return view('ichiran.favorites', compact('favoriteItems', 'user'));
    }

    //購入履歴
    public function buys() {
        //ログイン中ユーザーが購入したものの履歴
        //buystableのユーザーidで引っ張ってこれる
    }

    //フォロー一覧
    public function follows() {
        //followtableのfollwer_idがログイン者
        //情報はfollow_id=user_id の人のを取ってくる
    }

    //売上履歴
    public function sells() {
        //ログイン中のユーザーが出品したものかつsell_flgが1のものを表示
    }

}