@extends('layouts.admin')
@section('content')
    @can('product_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.products.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.product.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            Danh sách sản phẩm
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Product">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                SKU
                            </th>
                            <th>
                                Tên Sản Phẩm
                            </th>
                            <th>
                                Hình Ảnh
                            </th>
                            <th>
                                Giá
                            </th>
                            <th>
                                Giảm Giá
                            </th>
                            <th>
                                Số Lượng
                            </th>
                            <th>
                                Tình Trạng
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $product)
                            <tr data-entry-id="{{ $product->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $product->sku ?? '' }}
                                </td>
                                <td>
                                    {{ $product->name ?? '' }}
                                </td>
                                <td>
                                    <img src="{{ $product->photo ?? 'public/admin/images/df.jpg' }}" alt=""
                                        height="40">
                                </td>
                                <td>
                                    {{ number_format($product->price) }} đ
                                </td>
                                <td>
                                    @if ($product->discount && $product->discount > 0)
                                        <div class="d-flex gap-2">
                                            <small class="badge badge-danger mr-2">-{{ $product->discount }}%</small>
                                            <span class="text-danger font-weight-bold">
                                                {{ number_format($product->discount_price) }} đ
                                            </span>
                                        </div>
                                    @else
                                        <span class="badge badge-dark">Không giảm giá</span>
                                    @endif
                                </td>
                                <td>
                                    @if (count($product->variations))
                                        @php
                                            $qty = 0;
                                            foreach ($product->variations as $variation) {
                                                $quantity = $variation->quantity;
                                                $qty += $quantity;
                                            }
                                        @endphp
                                        <div>
                                            Còn lại {{ number_format($qty) }} sản phẩm gồm {{ $product->variations->count() }}
                                            thuộc tính
                                            @if($qty <= $product->low_stock_to_notify)
                                                <br><span class="badge badge-warning text-white mt-1">
                                                    <i class="fas fa-exclamation-triangle"></i> Sắp hết hàng
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <div>
                                            Còn lại {{ number_format($product->quantity) }} sản phẩm
                                            @if($product->quantity <= $product->low_stock_to_notify)
                                                <br><span class="badge badge-warning text-white mt-1">
                                                    <i class="fas fa-exclamation-triangle"></i> Sắp hết hàng
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    {{ $product->status == 1 ? 'Còn Hàng' : 'Hết Hàng' }}
                                </td>
                                <td>

                                    @can('product_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.products.edit', $product->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('product_delete')
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger"
                                                value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan

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
            @can('product_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.products.massDestroy') }}",
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
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 25,
            });
            let table = $('.datatable-Product:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
