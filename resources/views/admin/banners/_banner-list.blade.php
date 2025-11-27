<table class=" table table-bordered table-striped table-hover datatable datatable-ProductTag">
    <thead>
        <tr>
            <th width="10">

            </th>
            <th>
                ID
            </th>
            <th>
                Hình Ảnh
            </th>
            <th style="text-align: center">
                Banner Sản Phẩm
            </th>
            <th>
                Tùy chọn
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($banners as $key => $banner)
            <tr data-entry-id="{{ $banner->id }}">
                <td>

                </td>
                <td>
                    {{ $banner->id ?? '' }}
                </td>
                <td>
                    <img src="{{ $banner->photo ?? '' }}" alt="" height="100px">
                </td>
                <td> 
                    <label class="custom-switch pd-0">
                        <input type="checkbox" value="{{ $banner->banner_product ?? '' }}" name="is_banner_product"
                            class="custom-switch-input is_banner_product" {{ $banner->banner_product == 1 ? 'checked' : '' }}  data-id="{{$banner->id}}">
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Hiển Thị</span>
                    </label>
                </td>
                <td>
                    <form action="{{ route('admin.banners.destroy', $banner->id) }}"
                        method="POST"
                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                        style="display: inline-block;">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-xs btn-danger"
                            value="{{ trans('global.delete') }}">
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>