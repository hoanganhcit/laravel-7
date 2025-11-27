<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\ProductCategory;
use App\Components\Recusive;

class BannersController extends Controller
{
    private $category;
    
    public function __construct(ProductCategory $category) {
        $this->category = $category;
    }

    public function getCategory($CategoryParent) {
        $data = $this->category->all();
        $recusive = new Recusive($data);
        $htmlOption = $recusive->CategoryRecusive($CategoryParent);
        return $htmlOption;
    }

    public function index()
    {
        $banners = Banner::all();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        $htmlOption = $this->getCategory($CategoryParent = '');
        return view('admin.banners.create', compact('htmlOption'));
    }

    public function store(Request $request)
    {
        $banner = Banner::create($request->all());

        return redirect()->route('admin.banners.index');
    }

    public function edit(Banner $banner)
    {
        $htmlOption = $this->getCategory($banner->product_categories_id);
        return view('admin.banners.edit', compact('banner', 'htmlOption'));
    }

    public function update(Request $request, Banner $banner)
    {
        $banner->update($request->all());

        return redirect()->route('admin.banners.index');
    }

    public function destroy(Banner $banner)
    { 
        $banner->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        Banner::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}
