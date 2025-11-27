<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductCategoryRequest;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Models\ProductCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Components\Recusive;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
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
        abort_if(Gate::denies('product_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productCategories = ProductCategory::all();
        $childs = ProductCategory::with(['childs'])->get();
        return view('admin.productCategories.index', compact('productCategories','childs'));
    }

    public function create()
    {
        abort_if(Gate::denies('product_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $htmlOption = $this->getCategory($CategoryParent = '');
        return view('admin.productCategories.create', compact('htmlOption'));
    }

    public function store(Request $request)
    {
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['slug'] = Str::slug($request->name);
        $data['photo'] = $request->photo;
        $data['category_parent'] = $request->category_parent;

        $productCategory = ProductCategory::create($data);
        return redirect()->route('admin.product-categories.create')->with('success', 'Danh mục đã được thêm thành công!');
    }

    public function edit(ProductCategory $productCategory)
    {
        abort_if(Gate::denies('product_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $category_by_id = $this->category->where('id',$productCategory->id)->get();
        foreach($category_by_id as $val) {
            $parentID = $val->category_parent;
        }
        $htmlOption = $this->getCategory($parentID);

        return view('admin.productCategories.edit', compact('productCategory', 'htmlOption'));
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['slug'] = Str::slug($request->name);
        $data['photo'] = $request->photo;
        $data['category_parent'] = $request->category_parent;

        $productCategory->update($data);
        return redirect()->route('admin.product-categories.index');
    }

    public function show(ProductCategory $productCategory)
    {
        abort_if(Gate::denies('product_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.productCategories.show', compact('productCategory'));
    }

    public function destroy(ProductCategory $productCategory)
    {
        abort_if(Gate::denies('product_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyProductCategoryRequest $request)
    {
        ProductCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}