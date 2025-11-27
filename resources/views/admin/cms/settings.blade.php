@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="{{ asset('public/admin/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/site/css/alertify.min.css') }}">
    <style>
        .sort_display_order {
            padding: 0;
            list-style-type: none;
        }

        .sort_display_order li {
            margin-bottom: 1rem;
            background: transparent;
            cursor: all-scroll;
            border-color: #eee;
            border-radius: 4px;
            padding: 3px;
        }

        .product-list-item {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            position: relative;
        }

        .photo-50 {
            margin-right: 1rem;
        }
    </style>
@endsection
@section('content')
    <form method="POST" action="{{ route('admin.settings.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Cài đặt chung
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="photo">Logo</label>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a data-input="logo_thumbnail" data-preview="photo"
                                                class="btn btn-primary text-white lfm">
                                                <i class="fal fa-image"></i> Chọn hình ảnh
                                            </a>
                                        </span>
                                        <input id="logo_thumbnail" class="form-control" type="text" name="logo"
                                            value="{{ old('logo', $settings->logo ?? '') }}">
                                    </div>
                                    <div id="photo" style="margin-top:15px;max-height:100px;">
                                        @if ($settings && $settings->logo)
                                            <img src="{{ $settings->logo }}" alt="" style="height: 5rem;">
                                        @endif
                                    </div>
                                    @if ($errors->has('photo'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('photo') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="favicon">Favicon</label>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a data-input="thumbnail" data-preview="favicon"
                                                class="btn btn-primary text-white lfm">
                                                <i class="fal fa-image"></i> Chọn hình ảnh
                                            </a>
                                        </span>
                                        <input id="thumbnail" class="form-control" type="text" name="favicon"
                                            value="{{ $settings->favicon ?? '' }}">
                                    </div>
                                    <div id="favicon" style="margin-top:15px;max-height:100px;">
                                        @if ($settings && $settings->favicon)
                                            <img src="{{ $settings->favicon }}" alt="" style="height: 5rem;">
                                        @endif
                                    </div>
                                    @if ($errors->has('favicon'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('favicon') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="meta_title">Địa chỉ</label>
                                    <input type="text" class="form-control " name="address" placeholder=""
                                        value="{{ $settings->address ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="meta_title">Email</label>
                                    <input type="text" class="form-control " name="email" placeholder=""
                                        value="{{ $settings->email ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">Số điện thoại</label>
                                    <input type="text" class="form-control " name="phone" placeholder=""
                                        value="{{ $settings->phone ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger">Cập nhật</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.settings.homepage') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            Cài Đặt Trang Chủ
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="meta_title">Sản phẩm nổi bật</label>
                                        <select
                                            class="form-control select2 {{ $errors->has('product_id') ? 'is-invalid' : '' }}"
                                            name="product_id" id="product_id">
                                            @foreach ($product_featured as $id => $name)
                                                <option value="{{ $id }}"
                                                    {{ $id == old('product_id', $cms_homepage->product_id ?? '') ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('product_id'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('product_id') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_title">Bài viết nổi bật</label>
                                        <select
                                            class="form-control select2 {{ $errors->has('post_id') ? 'is-invalid' : '' }}"
                                            name="post_id" id="post_id">
                                            @foreach ($posts as $id => $name)
                                                <option value="{{ $id }}"
                                                    {{ $id == old('post_id', $cms_homepage->post_id ?? '') ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('post_id'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('post_id') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger">Cập nhật</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Hiển thị sản phẩm
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                @include('admin.cms.products-list')
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
                                    <label for="meta_title">Title</label>
                                    <input type="text" name="title" value="{{ $settings->title ?? '' }}"
                                        class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="meta_title">Keywords</label>
                                    <input type="text" class="form-control tagsinput-example" name="keywords"
                                        placeholder="Từ khoá" value="{{ $settings->keywords ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">Description</label>
                                    <textarea name="description" class="form-control" id="" rows="5">{{ $settings->description ?? '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger">Cập nhật</button>
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
    <script src="{{ asset('public/admin/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="{{ asset('public/admin/js/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('public/site/js/alertify.min.js') }}"></script>
    <script>
        $(".tagsinput-example").tagsinput('items');
        $('.lfm').filemanager('image', {prefix: '{{url("/laravel-filemanager")}}'});

        $(document).ready(function() {
            $(".sortable-products").sortable({
                stop: function() {
                    $.map($(this).find('li'), function(el) {
                        var id = el.id;
                        var sorting = $(el).index() + 1;
                        console.log(id);
                        $.ajax({
                            url: '{{ route('admin.settings.sortProducts') }}',
                            type: 'GET',
                            data: {
                                id: id,
                                sorting: sorting
                            },
                        });
                    });
                }
            });
        });
    </script>
@endsection
