<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class DisplayController extends Controller
{
    public function index() {

        $items = Item::all();
        
        return view('top',[
            'items'=>$items,
        ]);
    }

}
