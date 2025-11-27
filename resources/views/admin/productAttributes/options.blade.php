@extends('layouts.admin')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-dark" href="{{ route('admin.product-attributes.index') }}">
                Quay laị
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7 col-md-7">
            <div class="card">
                <div class="card-header">
                    {{ $productAttribute->title }}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-ProductAtribute">
                            <thead>
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Tên Biến Thể
                                    </th>
                                    <th>
                                        Tùy chọn
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($valueAttributes as $key => $valueAtribute)
                                    <tr data-entry-id="{{ $valueAtribute->id }}">
                                        <td>
                                            {{ $valueAtribute->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $valueAtribute->name ?? '' }}
                                        </td>
                                        <td>
                                            <form
                                                action="{{ route('admin.product-attributes.delete-value', $valueAtribute->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-xs btn-danger">
                                                    <i class="fal fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-5">
            <div class="card">
                <div class="card-header">
                    Thêm biến thể
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.product-attributes.insert-value') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Tên thuộc tính</label>
                            <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text"
                                name="title" id="title" value="{{ $productAttribute->title }}" readonly>
                            <input type="hidden" name="id" id="" value="{{ $productAttribute->id }}">
                        </div>
                        <div class="form-group">
                            <label for="name">Tên biến thể</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                name="name" id="name" value="">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        
        $(document).on("input", ".colorpicker", function() {
            $(this).parent().find('.hexcolor').val(this.value);
        });
        $(document).on("input", ".hexcolor", function() {
            $(this).parent().find('.colorpicker').val(this.value);
        });
    </script>
@endsection
