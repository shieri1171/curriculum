<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class DisplayController extends Controller
{
    //top
    public function index() {

        $items = Item::all();

        $items = Item::with('mainImage')->get();
        
        return view('top',[
            'items'=>$items,
        ]);
    }

    //検索
    public function search(Request $request)
    {
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

        return view('ichiran.item_search', compact('items'));
    }

    //詳細
    public function iteminfo(Item $item) {

        $item->load('itemImages');
        
        return view ('items.item_info', [
            'item' => $item
        ]);
    }

    //いいね
    public function favorites(Request $request)
    {
        $user = Auth::user();

        $favoriteItems = $user->favoriteItems;

        return view('ichiran.favorites', compact('favoriteItems'));
    }

}