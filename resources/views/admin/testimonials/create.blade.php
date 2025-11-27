@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Danh sách đánh giá
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="name">Họ và Tên</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ old('name', '') }}" required>
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="position">Vị trí</label>
                    <input class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" type="text"
                        name="position" id="position" value="{{ old('position', '') }}" required>
                    @if ($errors->has('position'))
                        <div class="invalid-feedback">
                            {{ $errors->first('position') }}
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
                        <input id="thumbnail" class="form-control" type="text" name="photo" value="">
                    </div>
                    <div id="photo" style="margin-top:15px;max-height:100px;"></div>
                    @if ($errors->has('photo'))
                        <div class="invalid-feedback">
                            {{ $errors->first('photo') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="photo">Đánh giá</label>
                    <div class="rating_box">
                        <div class="star-rating">
                            <div class="star-rating__wrap">
                                <input class="star-rating__input" id="star-rating-5" type="radio" name="rate"
                                    value="5">
                                <label class="star-rating__ico fal fa-star" for="star-rating-5"
                                    title="5 out of 5 stars"></label>
                                <input class="star-rating__input" id="star-rating-4" type="radio" name="rate"
                                    value="4">
                                <label class="star-rating__ico fal fa-star" for="star-rating-4"
                                    title="4 out of 5 stars"></label>
                                <input class="star-rating__input" id="star-rating-3" type="radio" name="rate"
                                    value="3">
                                <label class="star-rating__ico fal fa-star" for="star-rating-3"
                                    title="3 out of 5 stars"></label>
                                <input class="star-rating__input" id="star-rating-2" type="radio" name="rate"
                                    value="2">
                                <label class="star-rating__ico fal fa-star" for="star-rating-2"
                                    title="2 out of 5 stars"></label>
                                <input class="star-rating__input" id="star-rating-1" type="radio" name="rate"
                                    value="1">
                                <label class="star-rating__ico fal fa-star" for="star-rating-1"
                                    title="1 out of 5 stars"></label>
                                @if ($errors->has('rate'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('rate') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="required" for="content">Nội Dung</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="content"></textarea>
                    @if ($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.create') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        $('.lfm').filemanager('image', {prefix: '{{url("/laravel-filemanager")}}'});
    </script>
@endsection
