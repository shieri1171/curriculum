<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;
use App\Models\Buy;
use App\Models\User;
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
    public function itemedit($id) {

        $item = Item::with('itemImages')->findOrFail($id);

        $states = \App\Models\Item::ITEM_STATES;

        return view('Items.item_edit', compact('item', 'states'));
    }

    public function itemeditconf(Request $request, Item $item) {
        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('items', 'public');
                $imagePaths[] = $path;
            }
        }

        $request->session()->put([
            'item_id' => $item->id,
            'images' => $imagePaths,
            'itemname' => $request->input('itemname'),
            'price' => $request->input('price'),
            'state' => $request->input('state'),
            'presentation' => $request->input('presentation'),
        ]);

        return view('Items.item_edit_conf');
    }

    public function itemeditcomp(Request $request, Item $item) {

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

    //画像削除
    public function imagedelete($id)
    {
        $image = \App\Models\ItemImage::findOrFail($id);

        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }
    
        $itemId = $image->item_id;
        $image->delete();
    
        return redirect()->route('edit.item', ['item' => $itemId])
                         ->with('success', '画像を削除しました。');
    }

    //削除
    public function itemdelete($id) {

        $item = \App\Models\Item::findOrFail($id);
        $item->delete();

        \Session::flash('err_msg', '削除しました。');
        return view('Items.item_delete_comp');
    }

    //購入 条件分岐　情報ありの場合は直接確認画面へ
    public function buyitem(Item $item) {

        $user = auth()->user();

        session([
            'buyitem' => [
                'item_id' => $item->id,
                'user_id' => $user->id,
            ]
        ]);

        if($user->name && $user->tel && $user->postcode && $user->address) {

            return view('buys.auto_get_to_post');

        }else {

            return view('users.user_info', compact('item'));

        }
    }

    public function buyconf(Request $request) {

        $user = auth()->user();

        $request->session()->put([
            'user_id' => $user->id,
            'item_id' => session('buyitem')['item_id'],
            'name' => $request->input('name', $user->name),
            'tel' => $request->input('tel', $user->tel),
            'postcode' => $request->input('postcode', $user->postcode),
            'address' => $request->input('address', $user->address),
        ]);
        
        $item = Item::with('itemImages')->find(session('item_id'));

        return view('buys.buy_conf', compact('item'));
    }

    public function buycomp(Request $request) {
        $user = auth()->user();
        $buy = new Buy();

        $buy->user_id = $request->session()->get('user_id');
        $buy->item_id = $request->session()->get('item_id');
        $buy->name = $request->session()->get('name');
        $buy->tel = $request->session()->get('tel');
        $buy->postcode = $request->session()->get('postcode');
        $buy->address = $request->session()->get('address');

        $buy->save();

        $user->name = $request->session()->get('name');
        $user->tel = $request->session()->get('tel');
        $user->postcode = $request->session()->get('postcode');
        $user->address = $request->session()->get('address');

        $user->save();

        //itemtable sell_flg 0⇒1へ
        $item = Item::find($buy->item_id);
        $item->sell_flg = 1;
        $item->save();

        $request->session()->forget(['user_id', 'item_id', 'name', 'tel', 'postcode', 'address']);

        return view('buys.buy_comp');

    }

}
