<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;
use App\Models\ItemImage;

class RegistrationController extends Controller
{
    //新規登録
    public function item() {

        $states = \App\Models\Item::ITEM_STATES;

        return view('items.item', compact('states'));
    }

    public function itemconf(Request $request) {
        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('items', 'public');
                $imagePaths[] = $path;
            }
        }

        $request->session()->put([
            'images' => $imagePaths,
            'itemname' => $request->input('itemname'),
            'price' => $request->input('price'),
            'state' => $request->input('state'),
            'presentation' => $request->input('presentation'),
        ]);

        return view('Items.item_conf');
    }

    public function itemcomp(Request $request) {
        $item = new Item;

        $item->itemname = $request->session()->get('itemname');
        $item->price = $request->session()->get('price');
        $item->state = $request->session()->get('state');
        $item->presentation = $request->session()->get('presentation');

        $item->user_id = auth()->id();

        $item->save();

        $imagePaths = session('images', []);
        foreach ($imagePaths as $index => $path) {
            ItemImage::create([
                'item_id' => $item->id,
                'image_path' => $path,
                'mainflg' => $index === 0 ? 1 : 0,
            ]);
        }

        $request->session()->forget(['imagePaths', 'itemname', 'price', 'state', 'presentation']);

        return view('Items.item_comp');
    }

    //編集
    public function edititem(Item $item) {

        $states = \App\Models\Item::ITEM_STATES;

        return view('Items.item_edit', [
            'item' => $item,
            'states' => $states,
        ]);
    }

    public function edititemconf(Request $request) {
        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('items', 'public');
                $imagePaths[] = $path;
            }
        }

        $request->session()->put([
            'item_id' => $request->input('id'),
            'images' => $imagePaths,
            'itemname' => $request->input('itemname'),
            'price' => $request->input('price'),
            'state' => $request->input('state'),
            'presentation' => $request->input('presentation'),
        ]);

        return view('Items.item_edit_conf');
    }

    public function edititemcomp(Request $request, Item $item) {

        $item->id = $request->session()->get('item_id');
        $item->itemname = $request->session()->get('itemname');
        $item->price = $request->session()->get('price');
        $item->state = $request->session()->get('state');
        $item->presentation = $request->session()->get('presentation');

        $item->save();

        foreach ($item->itemImages as $oldImage) {
            Storage::disk('public')->delete($oldImage->image_path);
            $oldImage->delete();
        }

        foreach ($newImagePaths as $index => $path) {
            ItemImage::create([
                'item_id' => $item->id,
                'image_path' => $path,
                'mainflg' => $index === 0 ? 1 : 0,
            ]);
        }

        $request->session()->forget(['item_id', 'imagePaths', 'itemname', 'price', 'state', 'presentation']);

        return view('Items.item_edit_comp');
    }
}
