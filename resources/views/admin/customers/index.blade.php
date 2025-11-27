@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Danh sách khách hàng
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Customer">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                ID
                            </th>
                            <th>
                                Tên khách hàng
                            </th>
                            <th>
                                Email
                            </th> 
                            <th>
                                Số điện thoại
                            </th>
                            <th>
                                Số đơn hàng
                            </th>
                            <th>
                                Tổng đơn
                            </th>
                            <th>
                              
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $key => $customer)
                            <tr data-entry-id="{{ $customer->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $customer->id ?? '' }}
                                </td>
                                <td>
                                    {{ $customer->name ?? '' }}
                                </td>
                                <td>
                                    {{ $customer->email ?? '' }}
                                </td>
                                <td>
                                    {{ $customer->phone ?? '' }}
                                </td>
                                <td>
                                    {{ $customer->orders_customer->count()  ?? '' }}
                                </td>
                                <td>
                                    @php
                                        $total_prices = 0;
                                        foreach($customer->orders_customer as $customer) {
                                            $order_id = $customer->order_id; 
                                            $orderSalesQuery = App\Models\Order::where('id', $order_id)->selectRaw('IF(SUM(total_price) IS NULL, 0, SUM(total_price)) AS total_prices');;
                                            $allTotalQuery = clone $orderSalesQuery;
                                            $allTotal = $allTotalQuery->first();
                                            $total_prices = $allTotal->total_prices;
                                        } 
                                        $total_prices += $total_prices;
                                        // dd($allTotal);
                                    @endphp
                                    {{ number_format($total_prices) }} đ
                                </td>
                                <td>  
                                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST"
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
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.customers.massDestroy') }}",
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
                pageLength: 25,
            });
            let table = $('.datatable-Customer:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
