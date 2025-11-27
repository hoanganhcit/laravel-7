@if (!empty($productAttribute))

    <div class="row wrapper_attribute_{{ $productAttribute->id }}">
        <div class="col-lg-4 col-md-4">
            <input type="hidden" name="variations[{{ $keyCurrentVariation }}][attribute_ids][]" value="{{ $productAttribute->id }}">
            <div class="form-group">
                <input class="primary_input_field form-control" name="variations[{{ $keyCurrentVariation }}][attribute_names][]" type="text"
                       value="{{ $productAttribute->title }}" readonly="">
            </div>
        </div>
        <div class="col-lg-7 col-md-7">
            <select name="variations[{{ $keyCurrentVariation }}][product_attribute_values][{{ $productAttribute->id }}][]" class="form-control select2">

                @if (!empty($productAttributeValues))
                    @foreach ($productAttributeValues as $keyAttr => $productAttributeValue)
                        <option
                            {{ in_array($productAttributeValue->id, $attrValueSelected) ? 'selected' : '' }}
                            value="{{ $productAttributeValue->id }}__{{ $productAttributeValue->name }}">{{ $productAttributeValue->name }}</option>
                    @endforeach
                @endif

            </select>
        </div>
        <div class="col-lg-1 text-center">
            <a class="btn cursor_pointer attribute_remove" data-attribute_id="{{ $productAttribute->id }}" data-parent_div="wraper_attribute_{{ $productAttribute->id }}">
                <i class="fad fa-trash text-danger"></i>
            </a>
        </div>
    </div>

@endif
