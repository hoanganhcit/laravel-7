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
            
            // Get attributes from variations meta
            $attributes = [];
            if ($product->variations && $product->variations->count() > 0) {
                foreach ($product->variations as $variation) {
                    if ($variation->meta) {
                        $metaData = json_decode($variation->meta, true);
                        if (is_array($metaData)) {
                            foreach ($metaData as $attrId => $attrValues) {
                                if (!isset($attributes[$attrId])) {
                                    $productAttribute = \App\Models\ProductAttribute::find($attrId);
                                    if ($productAttribute) {
                                        $attributes[$attrId] = [
                                            'id' => $productAttribute->id,
                                            'name' => $productAttribute->title,
                                            'attribute_values' => []
                                        ];
                                    }
                                }
                                
                                if (isset($attributes[$attrId])) {
                                    foreach ($attrValues as $valueData) {
                                        $valueId = $valueData['id'] ?? null;
                                        if ($valueId && !in_array($valueId, array_column($attributes[$attrId]['attribute_values'], 'id'))) {
                                            $attributes[$attrId]['attribute_values'][] = [
                                                'id' => $valueId,
                                                'value' => $valueData['name'] ?? ''
                                            ];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            
            $product->attributes = array_values($attributes);
            
            \Log::info('Product found: ' . $product->name);
            \Log::info('Galleries count: ' . $galleries->count());
            \Log::info('Attributes: ' . json_encode($attributes));
            
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
