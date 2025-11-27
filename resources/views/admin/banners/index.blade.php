@extends('layouts.admin')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.banners.create') }}">
                Thêm Banner
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Danh Sách Banner
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-Banner">
                    <thead>
                        <tr>
                            <th width="10"></th>
                            <th>ID</th>
                            <th>Hình Ảnh</th>
                            <th>Tiêu Đề Phụ</th>
                            <th>Tiêu Đề</th>
                            <th>Danh Mục Sản Phẩm</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banners as $key => $banner)
                            <tr data-entry-id="{{ $banner->id }}">
                                <td></td>
                                <td>{{ $banner->id ?? '' }}</td>
                                <td>
                                    @if($banner->photo)
                                        <img src="{{ $banner->photo }}" width="100px">
                                    @endif
                                </td>
                                <td>{{ $banner->sub_title ?? '' }}</td>
                                <td>{{ $banner->title ?? '' }}</td>
                                <td>{{ $banner->productCategory->name ?? '' }}</td>
                                <td>
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.banners.edit', $banner->id) }}">
                                        Sửa
                                    </a>
                                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc?');" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
