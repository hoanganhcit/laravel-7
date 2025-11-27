<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Newsletter;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Post;
use App\Models\Banner;
use App\Models\CmsHomepage;
use App\Models\CmsAgencyStory;
use App\Models\CmsTestimonial;
use App\Models\ProductCategory;
use App\Models\Setting;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Session;
use Hash;

class HomeController extends Controller
{
    protected $remember_time = 24 * 60 * 60;
    public function index(Request $request) {

        // SEO
        $canonical = $request->url();
        $settings = Setting::first();
        $title = $settings->title;
        $description = $settings->description;
        $keywords = $settings->keywords;

        // Sản phẩm và bài viết nổi bật
        $arrays = CmsHomepage::first();

        $product_feature = Product::where('id', $arrays->product_id)->first();
        $products = Product::orderBy('display_order', 'ASC')->get();
        $post_feature = Post::where('id', $arrays->post_id)->first();

        // Load 6 sản phẩm nổi bật mới nhất
        $featured_products = Product::where('featured_product', 1)
            ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->limit(6)
            ->with(['categories', 'brand', 'variations'])
            ->get();

        // Load banners
        $banners = Banner::all();

        $productCategories = ProductCategory::all();
        Session::put('product_categories', $productCategories ?? []);
        
        return view('site.index', compact(
            'canonical',
            'title',
            'description',
            'keywords',
            'product_feature',
            'post_feature',
            'products',
            'banners',
            'featured_products'
        ));
    }
}
