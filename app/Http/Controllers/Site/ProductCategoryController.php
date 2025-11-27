<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function show($id)
    {
        $category = ProductCategory::findOrFail($id);
        
        // Lấy tất cả sản phẩm trong danh mục này và các danh mục con
        $categoryIds = $this->getAllCategoryIds($category);
        
        $products = Product::whereHas('categories', function($query) use ($categoryIds) {
                $query->whereIn('product_categories.id', $categoryIds);
            })
            ->where('status', 1)
            ->with(['categories', 'brand', 'variations'])
            ->paginate(12);
        
        return view('site.pages.product-category', compact('category', 'products'));
    }
    
    /**
     * Lấy tất cả ID của danh mục và các danh mục con
     */
    private function getAllCategoryIds($category)
    {
        $ids = [$category->id];
        
        if ($category->children->count() > 0) {
            foreach ($category->children as $child) {
                $ids = array_merge($ids, $this->getAllCategoryIds($child));
            }
        }
        
        return $ids;
    }
}
