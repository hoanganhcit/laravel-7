@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Danh sách đơn hàng
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Order">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                Mã đơn hàng
                            </th>
                            <th>
                                Khách hàng
                            </th>
                            <th>
                                Số sản phẩm
                            </th>
                            <th>
                                Tổng tiền
                            </th>
                            <th>
                                Phương thức thanh toán
                            </th>
                            <th>
                                Tình trạng thanh toán
                            </th>
                            <th>
                                Tình trạng giao hàng
                            </th>
                            <th>
                                Tùy chọn
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $key => $order)
                            <?php
                            $clsPaymentStatus = 'info';
                            $clsDeliveryStatus = 'info';
                            if ($order->payment_status == ORDER_PAYMENT_STATUS_DONE) {
                                $clsPaymentStatus = 'success';
                            } else if ($order->payment_status == ORDER_PAYMENT_STATUS_CANCEL) {
                                $clsPaymentStatus = 'danger';
                            }
                            if ($order->delivery_status == ORDER_DELIVERY_STATUS_DONE) {
                                $clsDeliveryStatus = 'success';
                            } else if ($order->delivery_status == ORDER_DELIVERY_STATUS_CANCEL) {
                                $clsDeliveryStatus = 'danger';
                            }
                            ?>
                            <tr data-entry-id="{{ $order->id }}">
                                <td>

                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" style="color:#000">
                                        <span style="text-transform:uppercase;font-weight:bold">#{{ $order->order_code ?? '' }}</span>
                                    </a>
                                </td>
                                <td>
                                    {{ $order->orderCustomer->name ?? '' }}
                                </td>
                                <td>
                                    {{ $order->total_product ?? '' }}
                                </td>
                                <td>
                                    {{ number_format($order->total_price) ?? '' }} đ
                                </td>
                                <td>
                                    @if($order->payment_method == 1)
                                        <img src="{{ asset('public/site/images/vnpay-logo.svg') }}" alt="VNPAY" style="width:50px">
                                    @elseif($order->payment_method == 2)
                                        <img src="{{ asset('public/site/images/logomm1.png') }}" alt="VNPAY" style="width:30px">
                                    @elseif($order->payment_method == 3)
                                        <span class="badge badge-info">Thanh toán khi nhận hàng</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $clsPaymentStatus }}">
                                        {{ $order->payment_status ? ORDER_PAYMENT_STATUS_LIST[$order->payment_status] : '' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $clsDeliveryStatus }}">
                                        {{ $order->delivery_status ? ORDER_DELIVERY_STATUS_LIST[$order->delivery_status] : '' }}
                                    </span>
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.orders.show', $order->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
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
                url: "{{ route('admin.orders.massDestroy') }}",
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

                ],
                pageLength: 25,
            });
            let table = $('.datatable-Order:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
