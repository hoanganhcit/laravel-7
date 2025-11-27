@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Sửa thuộc tính
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.product-attributes.update", [$productAttribute->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="title">Tên thuộc tính</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $productAttribute->title) }}">
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
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