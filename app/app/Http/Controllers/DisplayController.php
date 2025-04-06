<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function index() {

        $item = Item::all();
        
        return view('top',[
            'items'=>$items,
        ]);
    }
}
