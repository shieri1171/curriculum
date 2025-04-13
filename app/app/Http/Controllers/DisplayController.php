<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class DisplayController extends Controller
{
    public function index() {

        $items = Item::all();

        $items = Item::with('mainImage')->get();
        
        return view('top',[
            'items'=>$items,
        ]);
    }

    public function iteminfo(Item $item) {

        $item->load('itemImages');
        
        return view ('items.item_info', [
            'item' => $item
        ]);
    }

}
