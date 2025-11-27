<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductAttributeRequest;
use App\Http\Requests\StoreProductAttributeRequest;
use App\Http\Requests\UpdateProductAttributeRequest;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValues;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductAttributesController extends Controller
{
    public function index()
    {
        $productAtributes = ProductAttribute::all();
        return view('admin.productAttributes.index', compact('productAtributes'));
    }

    public function create()
    {
        return view('admin.productAttributes.create');
    }

    public function store(Request $request)
    {
        $productAttribute = ProductAttribute::create($request->all());
        return redirect()->route('admin.product-attributes.index');
    }

    public function edit(ProductAttribute $productAttribute)
    {

        $productAttributeValues = ProductAttributeValues::pluck('name', 'id');

        $productAttribute->load('productAttributeValues');

        return view('admin.productAttributes.edit', compact('productAttribute', 'productAttributeValues'));
    }

    public function update(Request $request, ProductAttribute $productAttribute)
    {
        $productAttribute->update($request->all());
        // $productAttribute->productAttributeValues()->sync($request->input('productAttributeValues', []));

        return redirect()->route('admin.product-attributes.index');
    }

    public function attributeValues($id)
    {
        $productAttribute = ProductAttribute::where('id', $id)->first();
        $valueAttributes = ProductAttributeValues::where('product_attribute_id', $id)->get();
        return view('admin.productAttributes.options', compact('productAttribute', 'valueAttributes'));
    }

    public function attributeValuesStore(Request $request, ProductAttribute $productAttribute)
    {
        $data['name'] = $request->name;
        $data['product_attribute_id'] = $request->id;
        ProductAttributeValues::create($data);
        return back();
    }
    public function attributeValuesDelete($id)
    {
        ProductAttributeValues::where('id', $id)->delete();
        return back();
    }

    public function destroy(ProductAttribute $productAttribute)
    {
        abort_if(Gate::denies('product_attribute_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productAttribute->delete();

        return back();
    }

    public function massDestroy(MassDestroyProductAttributeRequest $request)
    {
        ProductAttribute::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
