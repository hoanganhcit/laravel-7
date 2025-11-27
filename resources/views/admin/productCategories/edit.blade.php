@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Sửa danh mục
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.product-categories.update", [$productCategory->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">Tên danh mục</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name',  $productCategory->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="description">Mổ tả</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $productCategory->description) }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="photo">Hình Ảnh</label>
                <div class="input-group">
                    <span class="input-group-btn">
                        <a data-input="thumbnail" data-preview="photo" class="btn btn-primary text-white lfm">
                            <i class="fal fa-image"></i> Chọn hình ảnh
                        </a>
                    </span>
                  <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo', $productCategory->photo)}}">
                </div>
                <div id="photo" style="margin-top:15px;max-height:100px;"></div> 
                @if($errors->has('photo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('photo') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="parent">Thuộc danh mục</label>
                <select name="category_parent" class="form-control input-sm m-bot15 " >
                    <option value="0">---Danh mục cha---</option>
                    {!! $htmlOption !!}
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
@section('scripts')
<script src="{{asset('public/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script>
    $('.lfm').filemanager('image', {prefix: '{{url("/laravel-filemanager")}}'});
</script>
@endsection