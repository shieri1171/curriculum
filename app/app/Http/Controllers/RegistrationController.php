<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function item() {

        $states = \App\Models\Item::ITEM_STATES;

        return view('items.item', compact('states'));
    }
}
