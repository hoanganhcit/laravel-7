@extends('layouts.admin')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.product-attributes.create') }}">
                Thêm thuộc tính
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Danh sách thuộc tính
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-ProductAtribute">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                ID
                            </th>
                            <th>
                                Tên Thuộc Tính
                            </th>
                            <th>
                                Các Biến Thể
                            </th>
                            <th>
                                Tùy Chọn
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productAtributes as $key => $productAtribute)
                            <tr data-entry-id="{{ $productAtribute->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $productAtribute->id ?? '' }}
                                </td>
                                <td>
                                    {{ $productAtribute->title ?? '' }}
                                </td>
                                <td>
                                    @foreach ($productAtribute->productAttributeValues as $key => $item)
                                        <span class="badge badge-info">{{ $item->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-dark text-white"
                                        href="{{ route('admin.product-attributes.options', $productAtribute->id) }}">
                                         Biến thể
                                    </a>
                                    <a class="btn btn-xs btn-info"
                                        href="{{ route('admin.product-attributes.edit', $productAtribute->id) }}">
                                        Sửa
                                    </a>
                                    <form action="{{ route('admin.product-attributes.destroy', $productAtribute->id) }}"
                                        method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                        style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-xs btn-danger">
                                            Xóa
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
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.product-attributes.massDestroy') }}",
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
                    [1, 'asc']
                ],
                pageLength: 25,
            });
            let table = $('.datatable-ProductAtribute:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
