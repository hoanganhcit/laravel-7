<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Product;
use App\Models\Post;
use App\Models\CmsAbout;
use App\Models\CmsAgencyPolicy;
use App\Models\CmsCertification;
use App\Models\CmsHomepage;
use Symfony\Component\HttpFoundation\Response; 

class CmsController extends Controller
{ 
    public function index()
    {
        $product_featured = Product::pluck('name', 'id');
        $posts = Post::pluck('title', 'id');
        $settings = Setting::first(); 
        $cms_homepage = CmsHomepage::first();
        $products = Product::orderBy('display_order', 'ASC')->get();

        return view('admin.cms.settings', compact(
            'product_featured',
            'posts',
            'settings',
            'cms_homepage',
            'products'
        ));
    } 

    public function update(Request $request)
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'logo' => $request->logo,
                'favicon' => $request->favicon,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'title' => $request->title,
                'keywords' => $request->keywords,
                'description' => $request->description,
            ]
        );
        return back()->with('success', 'Cài đặt đã được cập nhật thành công!');
    } 

    public function homepage (Request $request) {

        CmsHomepage::updateOrCreate(
            ['id' => 1],
            [
                'product_id' => $request->product_id,
                'post_id' => $request->post_id,
            ]
        );
        return back()->with('success', 'Cập nhật trang chủ thành công!');
    }

    public function sortProducts(Request $request)
    {
        $products = Product::get();
        $id = $request->input('id');
        $sorting = $request->input('sorting');
        foreach ($products as $item) {
            return $products = Product::where('id', '=', $id)->update(array('display_order' => $sorting));
        }
        $products_list = view('admin.cms.products-list', compact('products'))->render();
        return $products_list;
    }
  
}
