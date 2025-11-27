@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <div class="rb-layout-item rb-medium-size-50 rb-xsmall-size-100 rb-size-25">
                    <div class="rb-card rb-card-stats rb-theme-default">
                        <div class="rb-card-header rb-card-header-icon ">
                            <div class="card-icon"><i class="fal fa-shopping-bag"></i></div>
                            <div class="rb-card-right">
                                <p class="category">Tổng đơn hàng</p>
                                <h3 class="title"> <span>{{ $orders ?? 0 }}</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="rb-layout-item rb-medium-size-50 rb-xsmall-size-100 rb-size-25">
                    <div class="rb-card rb-card-stats rb-theme-default">
                        <div class="rb-card-header rb-card-header-icon ">
                            <div class="card-icon"><i class="fal fa-shopping-bag"></i></div>
                            <div class="rb-card-right">
                                <p class="category">Đơn hàng mới</p>
                                <h3 class="title"> <span>{{ $order_new ?? 0 }}</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="rb-layout-item rb-medium-size-50 rb-xsmall-size-100 rb-size-25">
                    <div class="rb-card rb-card-stats rb-theme-default">
                        <div class="rb-card-header rb-card-header-icon ">
                            <div class="card-icon"><i class="fal fa-shopping-bag"></i></div>
                            <div class="rb-card-right">
                                <p class="category">Đơn hàng đang chờ xử lý</p>
                                <h3 class="title"> <span>{{ $order_pending ?? 0 }}</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="rb-layout-item rb-medium-size-50 rb-xsmall-size-100 rb-size-25">
                    <div class="rb-card rb-card-stats rb-theme-default">
                        <div class="rb-card-header rb-card-header-icon ">
                            <div class="card-icon"><i class="fad fa-boxes"></i></div>
                            <div class="rb-card-right">
                                <p class="category">Sản Phẩm</p>
                                <h3 class="title"> <span>{{ $products ?? 0 }}</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="rb-layout-item rb-medium-size-50 rb-xsmall-size-100 rb-size-25">
                    <div class="rb-card rb-card-stats rb-theme-default">
                        <div class="rb-card-header rb-card-header-icon ">
                            <div class="card-icon"><i class="fad fa-newspaper"></i></div>
                            <div class="rb-card-right">
                                <p class="category">Bài viết</p>
                                <h3 class="title"> <span>{{ $posts ?? 0 }}</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="rb-layout-item rb-medium-size-50 rb-xsmall-size-100 rb-size-25">
                    <div class="rb-card rb-card-stats rb-theme-default">
                        <div class="rb-card-header rb-card-header-icon ">
                            <div class="card-icon"><i class="fad fa-users"></i></div>
                            <div class="rb-card-right">
                                <p class="category">Khách hàng</p>
                                <h3 class="title"> <span>{{ $customers ?? 0 }}</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="rb-layout-item rb-medium-size-50 rb-xsmall-size-100 rb-size-25">
                    <div class="rb-card rb-card-stats rb-theme-default">
                        <div class="rb-card-header rb-card-header-icon ">
                            <div class="card-icon"><i class="fal fa-sack-dollar"></i></div>
                            <div class="rb-card-right">
                                <p class="category">Tổng Thu nhập</p>
                                <h3 class="title"> <span>{{ number_format($allTotalSales) }}</span> đ</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="rb-layout-item rb-medium-size-50 rb-xsmall-size-100 rb-size-25">
                    <div class="rb-card rb-card-stats rb-theme-default">
                        <div class="rb-card-header rb-card-header-icon ">
                            <div class="card-icon"><i class="fal fa-sack-dollar"></i></div>
                            <div class="rb-card-right">
                                <p class="category">Thu nhập ngày nay</p>
                                <h3 class="title"> <span>{{ number_format($thisDateOrderTotalSales) }}</span> đ</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="rb-layout-item rb-medium-size-50 rb-xsmall-size-100 rb-size-25">
                    <div class="rb-card rb-card-stats rb-theme-default">
                        <div class="rb-card-header rb-card-header-icon ">
                            <div class="card-icon"><i class="fal fa-sack-dollar"></i></div>
                            <div class="rb-card-right">
                                <p class="category">Thu nhập tháng này</p>
                                <h3 class="title"> <span>{{ number_format($thisMonthOrderTotalSales) }}</span> đ</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="rb-layout-item rb-medium-size-50 rb-xsmall-size-100 rb-size-25">
                    <div class="rb-card rb-card-stats rb-theme-default">
                        <div class="rb-card-header rb-card-header-icon ">
                            <div class="card-icon"><i class="fal fa-sack-dollar"></i></div>
                            <div class="rb-card-right">
                                <p class="category">Thu nhập năm nay</p>
                                <h3 class="title"> <span>{{ number_format($thisYearOrderTotalSales) }}</span> đ</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-xs-12">
                <div class="rb-card">
                    <div class="d-flex justify-between heading-card">
                        <h3 class="title_card">Báo cáo bán hàng</h3>
                        <div class="d-flex gap-4 align-items-center ms-auto mt-3 mt-lg-0  pr-3">
                            <div class="date__range">
                              <div class="input-daterange input-group" id="datepicker">
                                <input type="text" id="start_Date" class="input-sm form-control" placeholder="From" name="start" value="{{ $filter_start_date ?? '' }}"/>
                                <input type="text" id="end_Date" class="input-sm form-control" placeholder="To" name="end" value="{{ $filter_end_date ?? '' }}" />
                              </div>
                              <button class="btn btn-primary filter_date" data-url_filter="{{route('admin.index')}}?preview=filter_date">Filter</button>
                            </div>
                            <select class="form-select" id="preview-chart">
                              <option {{ Request::get('preview') == 'this_week' ? ' selected ' : '' }} value="{{route('admin.index')}}?preview=this_week" value="this_week" selected >Tuần Này</option>
                              <option {{ Request::get('preview') == 'last_week' ? ' selected ' : '' }} value="{{route('admin.index')}}?preview=last_week" value="last_week">Tuần Trước</option>
                              <option {{ Request::get('preview') == 'this_month' ? ' selected ' : '' }} value="{{route('admin.index')}}?preview=this_month" value="this_month" >Tháng Này</option>
                              <option {{ Request::get('preview') == 'last_month' ? ' selected ' : '' }} value="{{route('admin.index')}}?preview=last_month" value="last_month">Tháng Trước</option>
                            </select>
                          </div>
                    </div>

                    <div id="chart_sale" data-list-day="{{json_encode($listDay)}}" data-revenue="{{json_encode($arrayRevenueOrderMonth)}}" data-count="{{json_encode($arrayCountOrderMonth)}}"></div>
                </div>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="rb-card" style="min-height: 440px;">
                    <h3 class="title_card">Doanh thu </h3>
                    <div id="earnings" data-total="{{json_encode($pieChart)}}"></div>
                    <div class="pd-6" style="flex-wrap: wrap;">
                        <div class="mx-1">
                          <i class="fad fa-circle mr-2 text-info me-1 small"></i><span class="fs-16">Đã hoàn thành: <span style="text-transform:lowercase">{{ number_format($allTotalSales) }} đ</span> </span>
                        </div>
                        <div class="mx-1">
                          <i class="fad fa-circle mr-2 text-success me-1 small"></i><span class="fs-16">Đang xử lý: <span style="text-transform:lowercase">{{ number_format($allPendingTotalSales) }} đ</span></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-xs-12">
                <div class="rb-card">
                    <h3 class="title_card">Những đơn đặt hàng gần đây</h3>
                    <table class="table table-custom">
                        <thead>
                            <th>
                                Mã đơn hàng
                            </th>
                            <th>
                                Khách hàng
                            </th>
                            <th>
                                Tổng tiền
                            </th>
                            <th>
                                Tình trạng thanh toán
                            </th>
                            <th>
                                Tình trạng giao hàng
                            </th>
                            <th>
                                Ngày Đặt
                            </th>
                        </thead>
                        <tbody>
                            @foreach ($recent_orders as $key => $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" style="color:#000">
                                            <span
                                                style="text-transform:uppercase;font-weight:bold">#{{ $order->order_code ?? '' }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        {{ $order->orderCustomer->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ number_format($order->total_price) ?? '' }} đ
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $order->payment_status == 1 ? 'info' : 'success' }}">
                                            {{ $order->payment_status ? ORDER_PAYMENT_STATUS_LIST[$order->payment_status] : '' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $order->delivery_status == ORDER_DELIVERY_STATUS_PROCESSING ? 'info' : '' }}{{ $order->delivery_status == ORDER_DELIVERY_STATUS_DONE ? 'success' : '' }}{{ $order->delivery_status == ORDER_DELIVERY_STATUS_CANCEL ? 'danger' : '' }}
                                        ">
                                            {{ $order->delivery_status ? ORDER_DELIVERY_STATUS_LIST[$order->delivery_status] : '' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($order->created_at)) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="rb-card">
                    <h3 class="title_card">Sản phẩm bán chạy</h3>
                    <table class="table table-custom ">
                        <thead>
                            <th>
                                #
                            </th>
                            <th>
                                Sản Phẩm
                            </th>
                            <th style="white-space: nowrap;">
                                Đã bán
                            </th>
                        </thead>
                        <tbody>
                            @foreach ($best_seller as $key => $product)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="text-left">
                                                <img src="{{ $product->photo }}" alt="" class="mr-3 rounded"
                                                    width="40">
                                            </div>
                                            <div class="ml-1">{{ $product->name }}</div>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $product->sell }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <link rel="stylesheet" href="{{ asset('public/admin/css/datepicker.css') }}">
    <script src="{{ asset('public/admin/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('public/admin/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(document).on("change","#preview-chart", function () {
            var url = $(this).val();
            if (url) {
            window.location = url;
            }
            return false;
        });
        $(document).on("click",".filter_date", function () {
            event.preventDefault();
            var sDate = $('#start_Date').val();
            var eDate = $('#end_Date').val();
            var url_filter = $(this).data('url_filter');
            url_filter = url_filter + '&start_date=' + sDate + '&end_date=' + eDate;
            if (url_filter) {
                window.location = url_filter;
            }
            return false;
        });
        $(function () {
        $('.input-daterange').datepicker({
            format: "dd-mm-yyyy"
        });

        let listDay = $('#chart_sale').attr('data-list-day');
        listDay = JSON.parse(listDay);

        let revenue = $('#chart_sale').attr('data-revenue');
        revenue = JSON.parse(revenue);

        let count_order = $('#chart_sale').attr('data-count');
        count_order = JSON.parse(count_order);

        var options = {
            series: [{
                name: 'Doanh Số',
                type: 'column',
                data: revenue
            }, {
                name: 'Số đơn hàng',
                type: 'line',
                data: count_order
            }],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                },
                toolbar: {
                    show: false
                }
            },
            stroke: {
                width: [0, 4],
                curve: 'smooth',
            },
            fill: {
                type: 'solid',
                opacity: [0.35, 1],
            },
            labels: listDay,
            dataLabels: {
                enabled: true,
                enabledOnSeries: [1]
            },
            markers: {
                size: 0,
                hover: {
                    sizeOffset: 6
                }
            },
            yaxis: [{
                    title: {
                        text: '',
                    },
                },
                {
                    opposite: true,
                    title: {
                        text: '',
                    },
                },
            ],
            tooltip: {
                y: [
                    {
                        title: {
                            formatter: function (val) {
                                return val
                            }
                        }
                    },
                    {
                        title: {
                            formatter: function (val) {
                                return val
                            }
                        }
                    }
                ]
            },
        };

        var chart = new ApexCharts(document.querySelector("#chart_sale"), options);
        chart.render();

        let done = $('#earnings').attr('data-total');
        done = JSON.parse(done);

        var options_2 = {
            series: done,
            labels: ['Đã hoàn thành:', 'Đang xử lý'],
            chart: {
                type: 'donut',
            },
            legend: {
                show: false
            },
            responsive: [{
                breakpoint: 1367,
                options: {
                    legend: {
                        show: false
                    }
                }
            }]
        };

        var chart_2 = new ApexCharts(document.querySelector("#earnings"), options_2);
        chart_2.render();
    })
    </script>
@endsection
