<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Brand;
use App\Models\Setting;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // SEO
        $canonical = $request->url();
        $settings = Setting::first();
        $title = 'Shop - ' . ($settings->title ?? 'Store');
        $description = $settings->description ?? '';
        $keywords = $settings->keywords ?? '';

        // Get filter parameters
        $categorySlug = $request->get('category');
        $brandId = $request->get('brand');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $sort = $request->get('sort', 'newest');
        $perPage = $request->get('per_page', 12);

        // Build query
        $query = Product::where('status', 1);

        // Filter by category (support multiple categories)
        if ($categorySlug) {
            $categorySlugs = explode(',', $categorySlug);
            $query->whereHas('categories', function($q) use ($categorySlugs) {
                $q->whereIn('slug', $categorySlugs);
            });
        }

        // Filter by brand (support multiple brands)
        if ($brandId) {
            $brandIds = explode(',', $brandId);
            $query->whereIn('brand_id', $brandIds);
        }

        // Filter by price range
        if ($minPrice) {
            $query->where(function($q) use ($minPrice) {
                $q->where('discount_price', '>=', $minPrice)
                  ->orWhere(function($q2) use ($minPrice) {
                      $q2->whereNull('discount_price')->where('price', '>=', $minPrice);
                  });
            });
        }
        if ($maxPrice) {
            $query->where(function($q) use ($maxPrice) {
                $q->where('discount_price', '<=', $maxPrice)
                  ->orWhere(function($q2) use ($maxPrice) {
                      $q2->whereNull('discount_price')->where('price', '<=', $maxPrice);
                  });
            });
        }

        // Sorting
        switch ($sort) {
            case 'price_asc':
                $query->orderByRaw('COALESCE(discount_price, price) ASC');
                break;
            case 'price_desc':
                $query->orderByRaw('COALESCE(discount_price, price) DESC');
                break;
            case 'name_asc':
                $query->orderBy('name', 'ASC');
                break;
            case 'name_desc':
                $query->orderBy('name', 'DESC');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'ASC');
                break;
            case 'sale':
                // Only show products with discount
                $query->whereNotNull('discount_price')
                      ->whereColumn('discount_price', '<', 'price')
                      ->orderBy('created_at', 'DESC');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'DESC');
                break;
        }

        // Get products with relations
        $products = $query->with(['categories', 'brand', 'variations'])
            ->paginate($perPage);

        // Get all categories and brands for filter
        $categories = ProductCategory::all();
        $brands = Brand::all();

        // If AJAX request, return JSON with HTML snippets
        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            try {
                $html = '';
                foreach ($products as $product) {
                    $html .= view('site.pages.products._product_card', compact('product'))->render();
                }

                return response()->json([
                    'success' => true,
                    'html' => $html,
                    'pagination' => $products->links()->render(),
                    'total' => $products->total(),
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage()
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lỗi khi tải sản phẩm: ' . $e->getMessage()
                ], 500);
            }
        }

        return view('site.pages.products.shop', compact(
            'products',
            'categories',
            'brands',
            'canonical',
            'title',
            'description',
            'keywords'
        ));
    }
}
