@extends('layouts.admin')
@section('styles')
    <link href="{{ asset('public/admin/modules/product/css/index.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
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
                                        type="text" name="name" id="name" value="{{ old('name', '') }}"
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
                                        type="text" name="sku" id="sku" value="{{ old('sku', '') }}">
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
                                        value="{{ old('quantity', '') }}">
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
                                                {{ in_array($id, old('categories', [])) ? 'selected' : '' }}>
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
                                    <label class="required" for="brand_id">Thương Hiệu</label>
                                    <select
                                        class="form-control select2 {{ $errors->has('brand') ? 'is-invalid' : '' }}"
                                        name="brand" id="brand">
                                        <option value="">Chọn Thương Hiệu</option>
                                        @foreach ($brands as $id => $name)
                                            <option
                                            value="{{ $id }}"
                                            {{ $id == old('brand', '') ? 'selected' : '' }}
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
                                            style="min-height: 100px">{{ old('short_description', '') }}</textarea>
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
                                    <label class="required" for="price">Giá bán</label>
                                    <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                                        type="text" name="price" id="price" value="{{ old('price', '') }}" />
                                    @if ($errors->has('price'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('price') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name=""
                                            value="" id="sale_product">
                                        <label class="form-check-label" for="sale_product"> Sản Phẩm Giảm Giá </label>
                                    </div>
                                </div>
                            </div>
                            <div id="sale_product_form" class="" style="display: none">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label for="discount">Giảm giá (%)</label>
                                        <input class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}"
                                            type="text" name="discount" id="discount"
                                            value="{{ old('discount', '') }}">
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
                                            type="text" name="discount_price" id="discount_price" value="">
                                        @if ($errors->has('discount_price'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('discount_price') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="date_discount_period">Thời gian giảm giá</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fal fa-calendar-alt"></i></span>
                                            </div>
                                            <input class="form-control datepicker date_discount_period" type="text"
                                                name="date_discount_period" id="date_discount_period" value="">
                                        </div>
                                        @if ($errors->has('date_discount_period'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('date_discount_period') }}
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
                                            value="{{ old('galleries') }}" placeholder="Chọn nhiều ảnh, phân cách bằng dấu phẩy">
                                    </div>
                                    <div id="galleries_preview" style="margin-top:15px;"></div>
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
                                    class="custom-switch-input variant-product variant">
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
                                    <input type="number" required name="low_stock_to_notify" value="" class="form-control"
                                        placeholder="Nhập số lượng hàng tồn kho tối thiểu để thông báo">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Tình Trạng</label>
                                    <select name="status" class="form-control">
                                        <option value="1">Còn Hàng</option>
                                        <option value="2">Hết Hàng</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row with-variant wraper-variation-list d-none" id="div_variations">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label for="product_attribute">Chọn Thuộc Tính (Ví dụ: Dung tích, Màu sắc, Kích thước)</label>
                                    <select name="product_attribute_id" id="product_attribute" class="form-control select2">
                                        <option value="">-- Chọn thuộc tính --</option>
                                        @foreach($productAttributes as $attribute)
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
                            <div class="col-lg-12 col-md-12" id="variations_inputs_container"></div>
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
                                        id="description" style="min-height: 500px">{{ old('description', '') }}</textarea>
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
                                    <label for="inputPhoto">Hình Ảnh <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm_thumbnail" data-input="thumbnail" data-preview="holder"
                                                class="btn btn-primary text-white">
                                                <i class="fal fa-image"></i> Chọn hình ảnh
                                            </a>
                                        </span>
                                        <input id="thumbnail" class="form-control" type="text" name="photo"
                                            value="{{ old('photo') }}">
                                    </div>
                                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>
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
                                        <input class="form-check-input" type="checkbox" name="featured_product"
                                            value="0" id="featured_product">
                                        <label class="form-check-label" for="featured_product"> Sản Phẩm Nổi Bật </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="new_arrival"
                                            value="0" id="new_arrival">
                                        <label class="form-check-label" for="new_arrival"> Sản Phẩm Mới </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="on_sale" value="0"
                                            id="on_sale">
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
                                    <input type="text" name="meta_title" value="" class="form-control" placeholder="">
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
                                                {{ in_array($id, old('tags', [])) ? 'selected' : '' }}>
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
                                    <textarea name="meta_description" class="form-control" id="" rows="5"></textarea>
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
    <script src="{{ asset('public/admin/modules/product/js/create.js') }}"></script>
    <script>
        const productAttributesData = @json($productAttributes);
        console.log('Product Attributes Data:', productAttributesData);
        
        // Khi chọn attribute
        $('#product_attribute').on('change', function() {
            const attributeId = $(this).val();
            if (!attributeId) {
                $('#variation_values_container').hide();
                $('#variations_inputs_container').html('');
                return;
            }
            
            const attribute = productAttributesData.find(attr => attr.id == attributeId);
            console.log('Selected Attribute:', attribute);
            
            if (!attribute) {
                console.error('Attribute not found');
                return;
            }
            
            // Kiểm tra tên property chính xác
            const attributeValues = attribute.product_attribute_values || [];
            console.log('Attribute Values:', attributeValues);
            
            if (attributeValues.length === 0) {
                alert('Thuộc tính này chưa có giá trị nào. Vui lòng thêm giá trị cho thuộc tính trước.');
                $('#variation_values_container').hide();
                return;
            }
            
            // Hiển thị checkboxes cho các values
            let checkboxesHtml = '<div class="row">';
            attributeValues.forEach(value => {
                checkboxesHtml += `
                    <div class="col-md-4 mb-2">
                        <div class="form-check">
                            <input class="form-check-input variation-value-checkbox" 
                                   type="checkbox" 
                                   value="${value.id}" 
                                   data-value-name="${value.name}"
                                   id="attr_value_${value.id}">
                            <label class="form-check-label" for="attr_value_${value.id}">
                                ${value.name}
                            </label>
                        </div>
                    </div>
                `;
            });
            checkboxesHtml += '</div>';
            
            $('#attribute_values_checkboxes').html(checkboxesHtml);
            $('#variation_values_container').show();
            
            // Lắng nghe sự kiện checkbox change
            $('.variation-value-checkbox').on('change', function() {
                renderVariationInputs(attribute);
            });
        });
        
        // Render input fields cho các values được chọn
        function renderVariationInputs(attribute) {
            const checkedValues = $('.variation-value-checkbox:checked');
            let inputsHtml = '';
            
            if (checkedValues.length > 0) {
                inputsHtml = '<h5 class="mt-3 mb-3">Nhập thông tin cho từng biến thể</h5>';
                
                checkedValues.each(function(index) {
                    const valueId = $(this).val();
                    const valueName = $(this).data('value-name');
                    
                    inputsHtml += `
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong>${attribute.title}: ${valueName}</strong>
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="variations[${index}][attribute_id]" value="${attribute.id}">
                                <input type="hidden" name="variations[${index}][attribute_value_id]" value="${valueId}">
                                <input type="hidden" name="variations[${index}][attribute_name]" value="${attribute.title}">
                                <input type="hidden" name="variations[${index}][value_name]" value="${valueName}">
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>SKU</label>
                                            <input type="text" name="variations[${index}][sku]" class="form-control" placeholder="Mã SKU">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Giá <span class="text-danger">*</span></label>
                                            <input type="number" name="variations[${index}][price]" class="form-control" placeholder="0" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Số lượng <span class="text-danger">*</span></label>
                                            <input type="number" name="variations[${index}][quantity]" class="form-control" placeholder="0" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="default_variation" value="${index}" id="default_${index}" ${index === 0 ? 'checked' : ''}>
                                            <label class="form-check-label" for="default_${index}">
                                                Đặt làm biến thể mặc định
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }
            
            $('#variations_inputs_container').html(inputsHtml);
            
            // Xử lý is_default khi submit form
            $('form').off('submit.variations').on('submit.variations', function(e) {
                const defaultIndex = $('input[name="default_variation"]:checked').val();
                $('input[name$="[is_default]"]').remove(); // Xóa các input cũ
                
                $('.variation-value-checkbox:checked').each(function(index) {
                    const isDefault = (index == defaultIndex) ? 1 : 0;
                    $(`<input type="hidden" name="variations[${index}][is_default]" value="${isDefault}">`).appendTo('form');
                });
            });
        }
    </script>
@endsection
