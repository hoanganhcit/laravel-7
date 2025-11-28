<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductAttribute;
use App\Models\ProductTag;
use App\Models\Brand;
use App\Models\GalleryProduct;
use App\Models\ProductReview;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Admin\Traits\ProductTrait;

class ProductController extends Controller
{
    use ProductTrait;

    public function index()
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::with([
            'categories',
            'tags',
            'brand',
            'galleries'
        ])->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        abort_if(Gate::denies('product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = ProductCategory::pluck('name', 'id');
        $tags = ProductTag::pluck('name', 'id');
        $brands = Brand::pluck('name', 'id');
        $productAttributes = ProductAttribute::with('productAttributeValues')->get();

        return view('admin.products.create', compact(
            'categories',
            'tags',
            'brands',
            'productAttributes'
        ));
    }

    public function store(StoreProductRequest $request)
    {

        try {
            DB::beginTransaction();
            $dataCreate = $this->prepareData($request->all());

            $product = Product::create($dataCreate);
            $product->categories()->sync($dataCreate['categories'] ?? []);
            $product->tags()->sync($dataCreate['tags'] ?? []);

            if (!empty($dataCreate['variations'])) {
                $this->handleVariationAction($dataCreate['variations'], $product->id);
            } else {
                $product->variations()->delete();
                $product->is_variation = 0;
                $product->save();
            }

            // Xử lý galleries
            $galleries = $dataCreate['galleries'] ?? [];
            \Log::info('Galleries data:', ['galleries' => $galleries, 'type' => gettype($galleries)]);
            
            if (!empty($galleries) && is_array($galleries)) {
                foreach ($galleries as $gallery) {
                    if (!empty(trim($gallery))) {
                        GalleryProduct::create([
                            'galleries' => trim($gallery),
                            'product_id' => $product->id,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('message', 'Sản phẩm đã được tạo thành công!');
        } catch (\Exception $err) {
            DB::rollBack();
            \Log::error('Error creating product:', ['error' => $err->getMessage(), 'trace' => $err->getTraceAsString()]);
            return back()->withInput()->withErrors(['error' => 'Lỗi khi lưu sản phẩm: ' . $err->getMessage()]);
        }
    }

    public function edit(Product $product)
    {
        abort_if(Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = ProductCategory::pluck('name', 'id');
        $tags = ProductTag::pluck('name', 'id');
        $brands = Brand::pluck('name', 'id');
        $galleries = GalleryProduct::pluck('galleries', 'id');
        $attributes = ProductAttribute::all();
        $productAttributeIds = [];
        $productAttributeHtml = [];

        if (!empty($product->variations)) {
            foreach ($product->variations as $keyVar => $variation) {
                $objMeta = $variation->meta;
                $productAttributeHtmlChild = '';
                $productAttributeIdsChild = [];
                if (!is_null($objMeta)) {
                    $attributeList = $this->prepareMetaForUpdate($objMeta);
                    foreach ($attributeList as $attributeId => $item) {
                        $productAttributeHtmlChild .= $this->getAttributeValuesForUpdate(ProductAttribute::find($attributeId), $keyVar, $item);
                        $productAttributeIdsChild[] = $attributeId;
                    }
                }
                $productAttributeHtml[$variation->id] = $productAttributeHtmlChild;
                $productAttributeIds[$variation->id] = $productAttributeIdsChild;
            }
        }

        $product->load('categories', 'tags', 'brand', 'galleries', 'variations');
        $variationsHtml = $this->get_variations('edit', $product, $attributes, $productAttributeIds, $productAttributeHtml);
        return view('admin.products.edit', compact(
            'categories',
            'product',
            'tags',
            'brands',
            'galleries',
            'attributes',
            'variationsHtml'
        ));
    }

    public function update(Request $request, Product $product)
    {
        try {
            DB::beginTransaction();
            $dataUpdate = $this->prepareData($request->all());
            $product->update($dataUpdate);
            $product->categories()->sync($dataUpdate['categories'] ?? []);
            $product->tags()->sync($dataUpdate['tags'] ?? []);

            if (!empty($dataUpdate['variations'])) {
                $this->handleVariationAction($dataUpdate['variations'], $product->id);
            } else {
                $product->variations()->delete();
                $product->is_variation = 0;
                $product->save();
            }

            // Xử lý galleries
            $galleries = $dataUpdate['galleries'] ?? [];
            \Log::info('Update Galleries data:', ['galleries' => $galleries, 'type' => gettype($galleries)]);
            
            $product->galleries()->delete();
            if (!empty($galleries) && is_array($galleries)) {
                foreach ($galleries as $gallery) {
                    if (!empty(trim($gallery))) {
                        GalleryProduct::create([
                            'galleries' => trim($gallery),
                            'product_id' => $product->id,
                        ]);
                    }
                }
            }
            
            DB::commit();
            return redirect()->route('admin.products.index')->with('message', 'Sản phẩm đã được cập nhật thành công!');
        } catch (\Exception $err) {
            DB::rollBack();
            \Log::error('Error updating product:', ['error' => $err->getMessage(), 'trace' => $err->getTraceAsString()]);
            return back()->withInput()->withErrors(['error' => 'Lỗi khi cập nhật sản phẩm: ' . $err->getMessage()]);
        }
    }

    public function show(Product $product)
    {
        abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->load('categories', 'tags', 'brand');

        return view('admin.products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->delete();

        return back()->with('message', 'Sản phẩm đã được xóa thành công!');
    }

    public function massDestroy(MassDestroyProductRequest $request)
    {
        Product::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function get_variations($action, $product, $attributes, $productAttributeIds, $productAttributeHtml, $isDefault = false, $keyCurrentVariation = 0)
    {
        $variantsHtml = view('admin.products._variations-list', compact(
                'action',
                'product',
                'attributes',
                'productAttributeIds',
                'productAttributeHtml',
                'isDefault',
                'keyCurrentVariation'
            )
        )->render();
        return $variantsHtml;
    }

    public function getAttributeValues(Request $request, ProductAttribute $productAttribute, $keyCurrentVariation = 0, $attrValueSelected = [])
    {
        $keyCurrentVariation = $request->input('keyCurrentVariation', $keyCurrentVariation);
        $productAttributeValues = $productAttribute->productAttributeValues()->get();
        $attributesHtml = view('admin.products._attributes-list', compact(
            'productAttribute',
            'productAttributeValues',
            'keyCurrentVariation',
            'attrValueSelected'
        ))->render();
        return $attributesHtml;
    }

    public function getAttributeValuesForUpdate(ProductAttribute $productAttribute, $keyCurrentVariation = 0, $attrValueSelected = [])
    {
        $productAttributeValues = $productAttribute->productAttributeValues()->get();
        $attributesHtml = view('admin.products._attributes-list', compact(
            'productAttribute',
            'productAttributeValues',
            'keyCurrentVariation',
            'attrValueSelected'
        ))->render();
        return $attributesHtml;
    }

    public function renderNewVariation(Request $request)
    {
        $keyCurrentVariation = $request->input('keyCurrentVariation', 0);
        $attributes = ProductAttribute::all();
        $variationsHtml = $this->get_variations('create', null, $attributes, [], '', false, $keyCurrentVariation);
        return $variationsHtml;
    }

    public function reviews() {
        $reviews = ProductReview::with([
            'product'
        ])->get();
        // dd($reviews);
        return view('admin.products.reviews', compact('reviews'));
    }

    public function reviews_destroy(Request $request, $id) {
        ProductReview::where('id', $id)->delete();
        return back();
    }

    public function reviews_massDestroy(Request $request) {
        ProductReview::whereIn('id', request('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function renderGalleryProduct (Request $request) {
        $gallery_id = $request->gallery_id;
        $product_id = $request->product_id;
        GalleryProduct::where('id', $gallery_id)->delete();
        $product = Product::where('id', $product_id)->first();
        $galleryHtml = view('admin.products._galleries-product', compact(
            'product'
        ))->render();
        return response()->json([
            'galleryHtml' => $galleryHtml
        ]);
    }

}
