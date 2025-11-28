<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variation_id' => 'nullable|exists:variations,id'
        ]);

        $product = Product::with(['variations', 'brand'])->findOrFail($request->product_id);
        
        // Get cart from session
        $cart = session()->get('cart', []);
        
        // Create cart item key (product_id + variation_id if exists)
        $cartKey = $request->product_id;
        if ($request->variation_id) {
            $cartKey .= '_' . $request->variation_id;
            $variation = $product->variations->find($request->variation_id);
            $price = $variation->discount_price ?? $variation->price;
            $variationData = [
                'id' => $variation->id,
                'attributes' => json_decode($variation->meta, true)
            ];
        } else {
            $price = $product->discount_price ?? $product->price;
            $variationData = null;
        }

        // Check if product already in cart
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $request->quantity;
        } else {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'image' => $product->photo ?? $product->feature_image_path,
                'price' => $price,
                'original_price' => $product->price,
                'quantity' => $request->quantity,
                'variation' => $variationData,
                'brand' => $product->brand ? $product->brand->name : null
            ];
        }

        session()->put('cart', $cart);

        // Calculate cart summary
        $summary = $this->getCartSummary($cart);

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng',
            'cart' => $cart,
            'summary' => $summary,
            'cart_html' => view('site.partials._cart_items', ['cart' => $cart])->render()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
            'quantity' => 'required|integer|min:0'
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$request->cart_key])) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại trong giỏ hàng'
            ], 404);
        }

        if ($request->quantity == 0) {
            unset($cart[$request->cart_key]);
        } else {
            $cart[$request->cart_key]['quantity'] = $request->quantity;
        }

        session()->put('cart', $cart);

        $summary = $this->getCartSummary($cart);

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật giỏ hàng',
            'cart' => $cart,
            'summary' => $summary,
            'cart_html' => view('site.partials._cart_items', ['cart' => $cart])->render()
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->cart_key])) {
            unset($cart[$request->cart_key]);
            session()->put('cart', $cart);
        }

        $summary = $this->getCartSummary($cart);

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
            'cart' => $cart,
            'summary' => $summary,
            'cart_html' => view('site.partials._cart_items', ['cart' => $cart])->render()
        ]);
    }

    public function get()
    {
        $cart = session()->get('cart', []);
        $summary = $this->getCartSummary($cart);

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'summary' => $summary
        ]);
    }

    public function clear()
    {
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa toàn bộ giỏ hàng'
        ]);
    }

    private function getCartSummary($cart)
    {
        $totalItems = 0;
        $totalPrice = 0;
        $totalOriginalPrice = 0;

        foreach ($cart as $item) {
            $totalItems += $item['quantity'];
            $totalPrice += $item['price'] * $item['quantity'];
            $totalOriginalPrice += $item['original_price'] * $item['quantity'];
        }

        $totalDiscount = $totalOriginalPrice - $totalPrice;

        return [
            'total_items' => $totalItems,
            'total_price' => $totalPrice,
            'total_original_price' => $totalOriginalPrice,
            'total_discount' => $totalDiscount
        ];
    }
}
