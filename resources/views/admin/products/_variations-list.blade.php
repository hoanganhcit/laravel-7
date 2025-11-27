@if ($action == 'edit')
    @if (!empty($product->variations))
        @foreach($product->variations as $keyVar => $variation)
            <div class="variation-child">
                <hr class="hr-line-up" />
                <div class="wrapper-attribute-list">
                    <div class="form-group">
                        <label class="required" for="">Thuộc tính </label>
                        <select name="variations[{{ $keyVar }}][product_attributes]"
                                class="form-control select_product_attributes select2" multiple>
                            @if (!empty($attributes))
                                @foreach ($attributes as $attribute)
                                    <option
                                        value="{{ $attribute->id }}"
                                        data-url="{{ route('admin.products.getAttributeValues', [$attribute->id]) }}"
                                        {{ in_array($attribute->id, old('product_attributes', $productAttributeIds[$variation->id])) ? 'selected' : '' }}
                                        data-key_current_variation="{{ $keyVar }}"
                                    >{{ $attribute->title }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="customer_choice_options attribute-values" style="">
                        {!! $productAttributeHtml[$variation->id] !!}
                    </div>
                </div>
                <div class="wrapper-other-list">
                    @includeIf('admin.products._other-list', ['variations' => $product->variations, 'isDefault' => $isDefault, 'keyCurrentVariation' => $keyVar])
                </div>
            </div>
        @endforeach
    @endif

@else

    <div class="variation-child">
        <hr class="hr-line-up" />
        <div class="wrapper-attribute-list">
            <div class="form-group">
                <label class="required" for="">Thuộc tính </label>
                <select name="variations[{{ $keyCurrentVariation }}][product_attributes]"
                        class="form-control select_product_attributes select2" multiple>
                    @if (!empty($attributes))
                        @foreach ($attributes as $attribute)
                            <option
                                value="{{ $attribute->id }}"
                                data-url="{{ route('admin.products.getAttributeValues', [$attribute->id]) }}"
                                {{ in_array($attribute->id, old('product_attributes', [])) ? 'selected' : '' }}
                                data-key_current_variation="{{ $keyCurrentVariation }}"
                            >{{ $attribute->title }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="customer_choice_options attribute-values" style="">
            </div>
        </div>
        <div class="wrapper-other-list">
            @includeIf('admin.products._other-list', ['variations' => [], 'isDefault' => $isDefault, 'keyCurrentVariation' => $keyCurrentVariation])
        </div>
    </div>

@endif
