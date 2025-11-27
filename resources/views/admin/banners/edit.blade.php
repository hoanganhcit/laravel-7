@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Sửa Banner
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.banners.update', [$banner->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="photo">Hình Ảnh <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                                <i class="fal fa-image mx-2"></i> Chọn hình ảnh
                            </a>
                        </span>
                        <input id="thumbnail" class="form-control" type="text" name="photo" value="{{ old('photo', $banner->photo) }}">
                    </div>
                    <div id="holder" style="margin-top:15px;max-height:100px;">
                        @if($banner->photo)
                            <img src="{{ $banner->photo }}" style="height: 5rem;">
                        @endif
                    </div>
                    @if($errors->has('photo'))
                        <div class="text-danger">
                            {{ $errors->first('photo') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="sub_title">Tiêu Đề Phụ</label>
                    <input class="form-control" type="text" name="sub_title" id="sub_title" value="{{ old('sub_title', $banner->sub_title) }}">
                </div>

                <div class="form-group">
                    <label for="title">Tiêu Đề</label>
                    <input class="form-control" type="text" name="title" id="title" value="{{ old('title', $banner->title) }}">
                </div>

                <div class="form-group">
                    <label for="description">Mô Tả</label>
                    <textarea class="form-control" name="description" id="description" rows="3">{{ old('description', $banner->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="product_categories_id">Danh Mục Sản Phẩm</label>
                    <select class="form-control" name="product_categories_id" id="product_categories_id">
                        <option value="">-- Chọn danh mục --</option>
                        {!! $htmlOption !!}
                    </select>
                </div>

                <div class="form-group">
                    <button class="btn btn-success" type="submit">
                        Cập Nhật
                    </button>
                    <a class="btn btn-secondary" href="{{ route('admin.banners.index') }}">
                        Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        $('#lfm').filemanager('image', {prefix: '{{url("/laravel-filemanager")}}'});
    </script>
@endsection
