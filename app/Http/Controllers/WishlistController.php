<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function toggle($id)
{
    $find = Wishlist::where('user_id', auth()->id())
                    ->where('book_id', $id)
                    ->first();

    if ($find) {
        $find->delete();
        return response()->json(['removed' => true]);
    }

    Wishlist::create([
        'user_id' => auth()->id(),
        'book_id' => $id
    ]);

    return response()->json(['added' => true]);
}

}
