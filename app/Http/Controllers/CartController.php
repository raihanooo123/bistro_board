<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\CartItem;
use App\Models\Cart;




class CartController extends Controller
{
    

    

    public function addToCart(Request $request)
    {
        try {
            $validated = $request->validate([
                'item_id' => 'required|exists:items,id',
                'size' => 'nullable|string',
                'crust' => 'nullable|string',
                'quantity' => 'required|integer|min:1',
            ]);

            // Assume $cart is fetched or created
            $cart = Cart::firstOrCreate([
                'user_id' => auth()->id(),
                'status' => 'active',
            ]);

            $item = Item::findOrFail($validated['item_id']);

            $cartItem = new CartItem([
                'item_id' => $item->id,
                'size' => $validated['size'],
                'crust' => $validated['crust'],
                'quantity' => $validated['quantity'],
                'unit_price' => $item->price,
            ]);

            // return response()->json($cartItem);


            $cart->items()->save($cartItem);

            return response()->json(['message' => 'Item added to cart successfully']);
        } catch (\Exception $e) {
            Log::error('Error adding item to cart: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to add item to cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }




   

    public function index()
    {
        $carts = Cart::with('items.item')->latest()->get(); // eager load items and their related item info
        return view('cart.index', compact('carts'));
    }

    
    
    

}
