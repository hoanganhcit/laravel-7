<table class="table table-bordered sku_table">
    <thead>
    <tr>
        <td class="text-center">
            <label for="" class="control-label my-0">SKU</label>
        </td>
        <td class="text-center">
            <label for="" class="control-label my-0">Giá bán</label>
        </td>
        <td class="text-center stock_td">
            <label for="" class="control-label my-0">Số lượng</label>
        </td>
        <td class="text-center">
            <label for="" class="control-label my-0">Mặc định</label>
        </td>
        <td class="text-center">
            <label for="" class="control-label my-0">&nbsp;</label>
        </td>
    </tr>
    </thead>
    <tbody>

    @if (!empty($variation))
            <tr class="variant">
                <td class="text-center pt-36">
                    <input class="primary_input_field mt-30 form-control" type="text" name="variations[{{ $keyCurrentVariation }}][sku]"
                           value="{{ $variation->sku ?? '' }}">
                </td>
                <td class="text-center pt-25">
                    <input class="primary_input_field mt-30 price form-control" type="number"
                           name="variations[{{ $keyCurrentVariation }}][price]"
                           value="{{ $variation->price ?? 0 }}" min="0" step="0.001" required="">
                </td>
                <td class="text-center pt-25 stock_td">
                    <input class="primary_input_field mt-30 form-control" type="number" name="variations[{{ $keyCurrentVariation }}][quantity]"
                           value="{{ $variation->quantity ?? 0 }}" min="0"
                           step="0" required="">
                </td>
                <td class="text-center pt-36">
                    <input class="primary_input_field mt-30 form-control rad_is_default" style="width:20px;margin: 0 auto;"
                           type="radio" name="variation_is_default" value="" {{ $variation->is_default == 1 ? 'checked' : '' }}>
                    <input class="hdn_is_default" type="hidden" name="variations[{{ $keyCurrentVariation }}][is_default]" value="{{ $variation->is_default == 1 ? 1 : 0 }}">
                </td>
                <td class="text-center pt-25">
                    <input type="hidden" name="variations[{{ $keyCurrentVariation }}][id]" value="{{ $variation->id ?? '' }}">
                    <a class="btn cursor_pointer btn_variation_remove">
                        <i class="fad fa-trash text-danger"></i>
                    </a>
                </td>
            </tr>
    @else

        <tr class="variant">
            <td class="text-center pt-36">
                <input class="primary_input_field mt-30 form-control" type="text" name="variations[{{ $keyCurrentVariation }}][sku]" value="">
            </td>
            <td class="text-center pt-25">
                <input class="primary_input_field mt-30 price form-control" type="number"
                       name="variations[{{ $keyCurrentVariation }}][price]"
                       value="0" min="0" step="0.001" required="">
            </td>
            <td class="text-center pt-25 stock_td">
                <input class="primary_input_field mt-30 form-control" type="number" name="variations[{{ $keyCurrentVariation }}][quantity]"
                       value="0" min="0"
                       step="0" required="">
            </td>
            <td class="text-center pt-36">
                <input class="primary_input_field mt-30 form-control rad_is_default" style="width:20px;margin: 0 auto;" type="radio"
                       name="variation_is_default" value="" {{ $isDefault == true ? 'checked' : '' }}>
                <input class="hdn_is_default" type="hidden" name="variations[{{ $keyCurrentVariation }}][is_default]" value="{{ $isDefault == true ? '1' : 0 }}">
            </td>
            <td class="text-center pt-25">
                <input type="hidden" name="variations[{{ $keyCurrentVariation }}][id]" value="">
                <a class="btn cursor_pointer btn_variation_remove">
                    <i class="fad fa-trash text-danger"></i>
                </a>
            </td>
        </tr>
    @endif
    </tbody>
</table>
