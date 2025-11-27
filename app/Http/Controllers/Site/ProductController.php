<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function quickView($id)
    {
        try {
            \Log::info('QuickView request for product ID: ' . $id);
            
            $product = Product::with(['categories', 'brand', 'variations'])
                ->find($id);
            
            if (!$product) {
                \Log::error('Product not found with ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                    'product_id' => $id
                ], 404);
            }
            
            // Get galleries
            $galleries = \DB::table('gallery_products')
                ->where('product_id', $id)
                ->whereNull('deleted_at')
                ->get();
            
            \Log::info('Product found: ' . $product->name);
            \Log::info('Galleries count: ' . $galleries->count());
            
            return response()->json([
                'success' => true,
                'product' => $product,
                'galleries' => $galleries
            ]);
        } catch (\Exception $e) {
            \Log::error('QuickView error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => 'Product not found or error loading product data'
            ], 500);
        }
    }
}
