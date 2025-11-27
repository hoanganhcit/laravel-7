@extends('layouts.admin')
@section('styles')
<style>
    .custom-switch {
        position: relative;
    }
    .custom-switch .custom-switch-input {
        position: absolute;
    }
</style>
@endsection
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.press.create') }}">
                Thêm Tin Tức
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Danh sách tin tức
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Press">
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
                            <th>
                                Tiêu Đề
                            </th>
                            <th style="text-align: center">
                                Nổi Bật
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($press as $key => $press)
                            <tr data-entry-id="{{ $press->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $press->id ?? '' }}
                                </td>
                                <td>
                                    @if ($press->photo)
                                        <img src="{{ $press->photo }}" alt="" width="100">
                                    @else
                                        <img src="{{ asset('public/admin/image/df.jpg') }}" alt="" width="100">
                                    @endif
                                </td>
                                <td>
                                    {{ $press->title ?? '' }}
                                </td>
                                <td style="text-align: center"> 
                                    <label class="custom-switch" style="padding-left: 0">
                                        <input type="checkbox" value="{{ $press->is_show ?? '' }}" name="is_show"
                                            class="custom-switch-input is_show" {{ $press->is_show == 1 ? 'checked' : '' }}  data-id="{{$press->id}}">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.press.edit', $press->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>

                                    <form action="{{ route('admin.press.destroy', $press->id) }}" method="POST"
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
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(document).on("change", ".is_show", function() {
            if (this.checked) {
                $(this).attr('value', '1');
            } else {
                $(this).attr('value', '0');
            }
            var id = $(this).data('id');
            var is_show = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('admin.press.update_show')}}",
                data: {
                    id:id,
                    is_show: is_show
                },
                success: function(data) {
                    // $('.table-responsive').html(data.bannerList);
                }
            });
        });
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.press.massDestroy') }}",
                className: 'btn-danger',
                action: function(e, dt, node, config) {
                    var ids = $.map(dt.rows({
                        selected: true
                    }).nodes(), function(entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                                headers: {
                                    'x-csrf-token': _token
                                },
                                method: 'POST',
                                url: config.url,
                                data: {
                                    ids: ids,
                                    _method: 'DELETE'
                                }
                            })
                            .done(function() {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            let table = $('.datatable-Press:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
