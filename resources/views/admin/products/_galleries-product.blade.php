@foreach($product->galleries as $galleries)
<div class="form-group">
    <div class="input-group">
        <span class="input-group-btn">
            <a id="lfm_gallery" data-input="thumbnail-{{$galleries->id}}" data-preview="gallery-{{$galleries->id}}"
                class="btn btn-primary text-white lfm_gallery">
                <i class="fal fa-image"></i> Chọn hình ảnh
            </a>
        </span>
        <input id="thumbnail-{{$galleries->id}}" class="form-control" type="text" name="galleries[]"
                value="{{ $galleries->galleries }}">
        <button type="button" onclick="return confirm('Bạn có muốn xóa hình này?');" class="btn btn-danger btn-sm ml-2 delete-gallery-item" data-product-id={{$product->id}} data-id="{{$galleries->id}}">Xóa</button>
    </div>
    <div id="gallery-{{$galleries->id}}" style="margin-top:15px;max-height:100px;">
        <img src="{{ $galleries->galleries }}" alt="" style="height: 5rem;">
    </div>
</div>
@endforeach