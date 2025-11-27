@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.testimonial.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.testimonials.update", [$testimonial->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">Họ và Tên</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                    id="name" value="{{ old('name', $testimonial->name) }}" required>
                @if ($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="position">Vị trí</label>
                <input class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" type="text"
                    name="position" id="position" value="{{ old('position', $testimonial->position) }}" required>
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
                    <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$testimonial->photo}}">
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
                                value="5" {{ $testimonial->rate == 5 ? 'checked' : '' }}>
                            <label class="star-rating__ico fal fa-star" for="star-rating-5"
                                title="5 out of 5 stars"></label>
                            <input class="star-rating__input" id="star-rating-4" type="radio" name="rate"
                                value="4" {{ $testimonial->rate == 4 ? 'checked' : '' }}>
                            <label class="star-rating__ico fal fa-star" for="star-rating-4"
                                title="4 out of 5 stars"></label>
                            <input class="star-rating__input" id="star-rating-3" type="radio" name="rate"
                                value="3" {{ $testimonial->rate == 3 ? 'checked' : '' }}>
                            <label class="star-rating__ico fal fa-star" for="star-rating-3"
                                title="3 out of 5 stars"></label>
                            <input class="star-rating__input" id="star-rating-2" type="radio" name="rate"
                                value="2" {{ $testimonial->rate == 2 ? 'checked' : '' }}>
                            <label class="star-rating__ico fal fa-star" for="star-rating-2"
                                title="2 out of 5 stars"></label>
                            <input class="star-rating__input" id="star-rating-1" type="radio" name="rate"
                                value="1" {{ $testimonial->rate == 1 ? 'checked' : '' }}>
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
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="content">{{$testimonial->description}}</textarea>
                @if ($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Cập Nhật
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