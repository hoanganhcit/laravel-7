@extends('layouts.admin')
@section('styles')
    <link href="{{ asset('public/admin/modules/product/css/index.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <form method="POST" action="{{ route('admin.products.update', [$product->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="card">
                    <div class="card-header">
                        Thông tin sản phẩm
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label class="required" for="name">Tên Sản Phẩm</label>
                                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                           type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                                    />
                                    @if ($errors->has('name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="required" for="sku">Mã sản phẩm</label>
                                    <input class="form-control {{ $errors->has('sku') ? 'is-invalid' : '' }}"
                                           type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}">
                                    @if ($errors->has('sku'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('sku') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="required" for="quantity">Số Lượng</label>
                                    <input class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}"
                                           type="number" placeholder="0" name="quantity" id="quantity"
                                           value="{{ old('quantity', $product->quantity) }}">
                                    @if ($errors->has('quantity'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('quantity') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <div class="d-flex justify-between">
                                        <label class="required" for="categories">Danh Mục Sản Phẩm</label>
                                        <div style="padding-bottom: 4px">
                                            <span class="btn btn-info btn-xs select-all"
                                                  style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                            <span class="btn btn-info btn-xs deselect-all"
                                                  style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                        </div>
                                    </div>
                                    <select
                                        class="form-control select2 {{ !empty($errors->get('categories.*')) ? 'is-invalid' : '' }}"
                                        name="categories[]" id="categories" multiple>
                                        <option value="">Chọn Danh Mục</option>
                                        @foreach ($categories as $id => $category)
                                            <option value="{{ $id }}"
                                                {{ in_array($id, old('categories', $product->categories()->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                {{ $category }}</option>
                                        @endforeach
                                    </select>
                                    @if(!empty($errors->get('categories.*')))
                                        @foreach($errors->get('categories.*') as $errCate)
                                            @foreach($errCate as $error)
                                                <div class="invalid-feedback">
                                                    {{ $error }}
                                                </div>
                                            @endforeach
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="required" for="brand">Thương Hiệu</label>
                                    <select
                                        class="form-control select2 {{ $errors->has('brand') ? 'is-invalid' : '' }}"
                                        name="brand" id="brand">
                                        <option value="">Chọn Thương Hiệu</option>
                                        @foreach ($brands as $id => $name)
                                            <option
                                                value="{{ $id }}"
                                                {{ $id == old('brand', $product->brand->id) ? 'selected' : '' }}
                                            >{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('brand'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('brand') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group short-des">
                                    <label for="short_description" class="form-control-label required">Mô tả ngắn</label>
                                    <div>
                                        <textarea type="text" class="form-control content {{ $errors->has('short_description') ? 'is-invalid' : '' }}" name="short_description" id="short_description"
                                                  style="min-height: 100px">{{ old('short_description', $product->short_description) }}</textarea>
                                        @if ($errors->has('short_description'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('short_description') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        Thông tin bán hàng
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label for="price">Giá bán</label>
                                    <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                                           type="number" name="price" id="price" value="{{ old('price', $product->price) }}"
                                           step="0.01" />
                                    @if ($errors->has('price'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('price') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="discount">Giảm giá (%)</label>
                                    <input class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}"
                                           type="text" name="discount" id="discount"
                                           value="{{ old('discount', $product->discount) }}">
                                    @if ($errors->has('discount'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('discount') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="discount_price">Giá đã giảm</label>
                                    <input disabled
                                           class="form-control {{ $errors->has('discount_price') ? 'is-invalid' : '' }}"
                                           type="text" name="discount_price" id="discount_price" value="{{ old('discount_price', $product->discount_price) }}">
                                    @if ($errors->has('discount_price'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('discount_price') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Gallery Hình Ảnh Sản Phẩm
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label for="galleries">Chọn nhiều hình ảnh</label>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm_galleries" data-input="galleries" data-preview="galleries_preview"
                                                class="btn btn-primary text-white">
                                                <i class="fal fa-images"></i> Chọn nhiều hình ảnh
                                            </a>
                                        </span>
                                        <input id="galleries" class="form-control" type="text" name="galleries" 
                                            value="{{ old('galleries', $product->galleries->pluck('galleries')->implode(',')) }}" placeholder="Chọn nhiều ảnh, phân cách bằng dấu phẩy">
                                    </div>
                                    <div id="galleries_preview" style="margin-top:15px;">
                                        @foreach($product->galleries as $gallery)
                                            <img src="{{ $gallery->galleries }}" style="height: 5rem; margin-right: 10px; margin-bottom: 10px;">
                                        @endforeach
                                    </div>
                                    <small class="form-text text-muted">Chọn nhiều ảnh từ file manager. Các URL sẽ được phân cách bằng dấu phẩy.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-between align-center">
                        Kho sản phẩm
                        <div class="text-right">
                            <label class="custom-switch">
                                <input type="checkbox" value="1" name="is_variation"
                                       class="custom-switch-input variant-product variant"
                                    {{ 1 == old('status', $product->is_variation) ? 'checked' : '' }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Sản phẩm có biến thể</span>
                            </label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="low_stock_to_notify">Cảnh báo hàng tồn tối thiểu</label>
                                    <input type="number" name="low_stock_to_notify" value="{{ old('low_stock_to_notify', $product->low_stock_to_notify) }}" class="form-control"
                                           placeholder="Nhập số lượng hàng tồn kho tối thiểu để thông báo">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Tình Trạng</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ 1 == old('status', $product->status) ? 'selected' : '' }}>Còn Hàng</option>
                                        <option value="2" {{ 2 == old('status', $product->status) ? 'selected' : '' }}>Hết Hàng</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row with-variant wraper-variation-list {{ 0 == old('is_variation', $product->is_variation) ? 'd-none' : '' }}"
                             id="div_variations">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label for="product_attribute">Chọn Thuộc Tính (Ví dụ: Dung tích, Màu sắc, Kích thước)</label>
                                    <select name="product_attribute_id" id="product_attribute" class="form-control select2">
                                        <option value="">-- Chọn thuộc tính --</option>
                                        @foreach($attributes as $attribute)
                                            <option value="{{ $attribute->id }}">{{ $attribute->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12" id="variation_values_container" style="display: none;">
                                <div class="form-group">
                                    <label>Chọn các giá trị biến thể</label>
                                    <div id="attribute_values_checkboxes"></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12" id="variations_inputs_container">
                                {!! $variationsHtml !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        Nội dung sản phẩm
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <textarea class="form-control content {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description"
                                              id="description" style="min-height: 500px">{{ old('description', $product->description) }}</textarea>
                                    @if ($errors->has('description'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('description') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="card">
                    <div class="card-header">
                        Đăng sản phẩm
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-success" type="submit">
                                        <i class="fal fa-save"></i> Lưu
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Hình Ảnh Sản Phẩm
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label for="inputPhoto">Hình Ảnh</label>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm_thumbnail" data-input="thumbnail" data-preview="holder"
                                               class="btn btn-primary text-white">
                                                <i class="fal fa-image"></i> Chọn hình ảnh
                                            </a>
                                        </span>
                                        <input id="thumbnail" class="form-control" type="text" name="photo"
                                               value="{{ old('photo', $product->photo) }}">
                                    </div>
                                    <div id="product-{{$product->id}}" style="margin-top:15px;max-height:100px;">
                                        <img src="{{ $product->photo }}" alt="" style="height: 5rem;">
                                    </div>
                                    @error('photo')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        Loại sản phẩm
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="featured_product" value="{{ 1 == old('featured_product', $product->featured_product) ? 1 : 0 }}"
                                               id="featured_product" {{ 1 == old('featured_product', $product->featured_product) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="featured_product"> Sản Phẩm Nổi Bật </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="new_arrival" value="{{ 1 == old('new_arrival', $product->new_arrival) ? 1 : 0 }}"
                                               id="new_arrival" {{ 1 == old('new_arrival', $product->new_arrival) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="new_arrival"> Sản Phẩm Mới </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="on_sale" value="{{ 1 == old('on_sale', $product->on_sale) ? 1 : 0 }}"
                                               id="on_sale" {{ 1 == old('on_sale', $product->on_sale) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="on_sale"> Bán chạy nhất </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        SEO Tool
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="meta_title">Meta Title</label>
                                    <input type="text" name="meta_title" value="{{ $product->meta_title }}" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-between">
                                        <label for="meta_keyworks">Meta Keyworks</label>
                                        <div style="padding-bottom: 4px">
                                            <span class="btn btn-info btn-xs select-all"
                                                  style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                            <span class="btn btn-info btn-xs deselect-all"
                                                  style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                        </div>
                                    </div>
                                    <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}"
                                            name="tags[]" id="tags" multiple>
                                        @foreach ($tags as $id => $tag)
                                            <option value="{{ $id }}"
                                                {{ in_array($id, old('tags', $product->tags()->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                {{ $tag }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('tags'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('tags') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea name="meta_description" class="form-control" id="meta_description" rows="5">{{ $product->meta_description }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection

@section('scripts')
    <script src="{{ asset('public/admin/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="{{ asset('public/admin/modules/product/js/index.js') }}"></script>
    <script src="{{ asset('public/admin/modules/product/js/edit.js') }}"></script>
    <script>
        // Xử lý tự động điền giá cho variations khi thay đổi giá sản phẩm
        $('#price').on('input', function() {
            const basePrice = $(this).val();
            if (basePrice && basePrice > 0) {
                $('input[name$="[price]"]').each(function() {
                    if ($(this).attr('name').includes('variations[')) {
                        $(this).val(basePrice);
                    }
                });
            }
        });
        
        // Xử lý tự động điền giá giảm cho variations
        $('#discount_price').on('input', function() {
            const discountPrice = $(this).val();
            if (discountPrice && discountPrice > 0) {
                $('input[name$="[price]"]').each(function() {
                    if ($(this).attr('name').includes('variations[')) {
                        $(this).val(discountPrice);
                    }
                });
            }
        });
    </script>
@endsection
