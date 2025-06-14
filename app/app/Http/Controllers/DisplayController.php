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
                     ->where('items.del_flg', 0)
                     ->whereHas('user', function ($query) {
                         $query->where('del_flg', 0);
                     })
                     ->where('sell_flg', 0)
                     ->orderBy('created_at', 'desc')
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

        $items = $query->with('mainImage')
                       ->where('items.del_flg', 0)
                       ->whereHas('user', function ($query) {
                           $query->where('del_flg', 0);
                       })
                       ->where('sell_flg', 0)
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('ichiran.item_search', compact('items', 'user'));
    }

    //商品詳細
    public function iteminfo(Item $item) {

        $item->load('itemImages', 'comments');
        $comments = $item->comments;
        $user = Auth::user();
        $followId = $item->user->input;


        if($user && auth()->user()->id !== $item->user_id) {
            $isFavorited = Favorite::where('user_id', auth()->id())
            ->where('item_id', $item->id)
            ->exists();

            $isFollowing  = Follow::where('follower_id', $user->id)
            ->where('follow_id', $followId)
            ->first();
    
            return view ('items.item_info', compact('item', 'isFavorited', 'user', 'comments', 'isFollowing'));

        } else {
            return view ('items.item_info', compact('item', 'user', 'comments'));
        }
    }

    //いいね一覧
    public function favorites(Request $request)
    {
        $user = Auth::user();

        $favoriteItems = $user->favoriteItems()
                              ->where('items.del_flg', 0)
                              ->whereHas('user', function ($query) {
                                  $query->where('del_flg', 0);
                              })
                              ->get();

        return view('ichiran.favorites', compact('favoriteItems', 'user'));
    }

    //購入履歴
    public function buys() {
        $user = Auth::user();

        $buys = Buy::where('user_id', $user->id)
                   ->whereHas('item', function ($query) {
                       $query->where('del_flg', 0)
                           ->whereHas('user', function ($q) {
                                 $q->where('del_flg', 0);
                           });
                   })
                   ->with('item.mainImage')
                   ->latest()
                   ->get();

    return view('ichiran.buys', compact('buys', 'user'));
    }

    //フォロー一覧
    public function follows() {
        $user = Auth::user();
    
        $follows = Follow::where('follower_id', $user->id)
                         ->with('followedUser')
                         ->where('del_flg', 0)
                         ->get();
    
        return view('ichiran.follows', compact('follows', 'user'));
    }

    //売上履歴
    public function sells() {
        $user = Auth::user();
    
        $sells = Item::where('user_id', $user->id)
                     ->where('sell_flg', 1)
                     ->latest()
                     ->get();
    
        return view('ichiran.sells', compact('sells', 'user'));
    }
}