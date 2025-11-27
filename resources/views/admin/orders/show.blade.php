@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Đơn hàng mã : #{{$order->order_code}}
        </div>
        <div class="card-body">
            <div class="invoice">
                <form method="POST" action="{{route('admin.orders.update', [$order->id])}}" enctype="multipart/form-data" >
                    @method('PUT')
                    @csrf
                    <div class="row flex-end">
                        <div class="col-lg-12">
                            <div class="d-flex flex-end">
                                <select name="payment_status" id="" class="col-lg-3 form-control mr-4 mb-4">

                                    @foreach(ORDER_PAYMENT_STATUS_LIST as $keyPayment => $paymentStatus)
                                        <option value="{{ $keyPayment }}" {{ $order->payment_status == $keyPayment ? 'selected' : '' }}>{{ $paymentStatus }}</option>
                                    @endforeach

                                </select>
                                <select class="col-lg-3 form-control selectric mr-4 mb-4" name="delivery_status" tabindex="-1">

                                    @foreach(ORDER_DELIVERY_STATUS_LIST as $keyDelivery => $deliveryStatus)
                                        <option value="{{ $keyDelivery }}" {{ $order->delivery_status == $keyDelivery ? 'selected' : '' }}>{{ $deliveryStatus }}</option>
                                    @endforeach

                                </select>
                                <button type="submit" class="btn btn-primary mb-4">Cập nhật</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12 pt-2">
                            <div class="row">
                                <div class="col-md-6 col-12 col-sm-6">
                                    <address>
                                        <strong>Gửi từ:</strong><br>
                                        {{ $settings->title ?? '' }}<br>
                                        {{ $settings->phone ?? '' }}<br>
                                        {{ $settings->address ?? '' }}<br>
                                    </address>
                                </div>
                                <div class="col-md-6 col-12 col-sm-6 text-md-left">
                                    <address>
                                        <strong>Người nhận:</strong><br>
                                        <b>Họ và Tên:</b> {{ $order->orderCustomer->name ?? '' }}<br>
                                        <b>SĐT:</b> {{ $order->orderCustomer->phone ?? '' }}<br>
                                        <b>Địa chỉ:</b> {{ $order->orderCustomer->address ?? '' }} - {{$order->orderCustomer->wards->name_xaphuong}} - {{$order->orderCustomer->province->name_quanhuyen}} - {{$order->orderCustomer->city->name_city}}<br>
                                        <strong>Ngày tạo đơn hàng:</strong>
                                        {{  date('d-m-Y', strtotime($order->created_at)) }}
                                        <br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title mb-2">Tóm tắt đơn hàng</div>
                            <div class="table-responsive">
                                <table class="table table-hover table-md">
                                    <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="40%">Sản Phẩm</th>
                                        <th class="text-center" width="15%">Giá</th>
                                        <th class="text-center" width="15%">Số Lượng</th>
                                        <th class="text-center" width="15%">Phí Ship</th>
                                        <th class="text-right" width="25%">Tổng tiền</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if (!empty($order->orderProducts))
                                        @foreach($order->orderProducts as $keyProduct => $orderProduct)

                                            <tr>
                                                <td>{{ $keyProduct + 1 }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="text-left">
                                                            <img src="https://yooridemo.spagreen.net/public/images/20220328174052image_40x40_media_286.png"
                                                                 alt="" class="mr-3 rounded">
                                                        </div>
                                                        <div class="ml-1">{{ $orderProduct->name }}</div>
                                                    </div>
                                                </td>
                                                <td class="text-center">{{ number_format($orderProduct->price) }} ₫</td>
                                                <td class="text-center">{{ $orderProduct->quantity }}</td>
                                                <td class="text-center">0</td>
                                                <td class="text-right">{{ number_format($orderProduct->price * $orderProduct->quantity) }} ₫</td>
                                            </tr>

                                        @endforeach
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-8">
                                </div>
                                <div class="col-lg-4 text-right">
                                    <table class="table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="invoice-detail-name"> Tạm tính:</td>
                                                <td class="invoice-detail-value">{{ number_format($order->total_price) }} ₫</td>
                                            </tr>
                                            <tr>
                                                <td class="invoice-detail-name">(-) Giảm giá:</td>
                                                <td class="invoice-detail-value">$ 0,00</td>
                                            </tr>
                                            <tr>
                                                <td class="invoice-detail-name">(-) Coupon Discount:</td>
                                                <td class="invoice-detail-value">{{ number_format($order->coupon_code) }} ₫</td>
                                            </tr>
                                            <tr>
                                                <td class="invoice-detail-name"></td>
                                                <td>-------------</td>
                                            </tr>
                                            <tr>
                                                <td class="invoice-detail-name"></td>
                                                <td class="invoice-detail-value">{{ number_format($order->total_price) }} ₫</td>
                                            </tr>
                                            <tr>
                                                <td class="invoice-detail-name">(+) Phí shíp:</td>
                                                <td class="invoice-detail-value">{{ number_format($order->fee_shipping) }} ₫</td>
                                            </tr>
                                            <tr>
                                                <td class="invoice-detail-name"></td>
                                                <td>-------------</td>
                                            </tr>
                                            <tr>
                                                <td class="invoice-detail-name"> Tổng đơn:</td>
                                                <td class="invoice-detail-value">{{ number_format($order->total_price + $order->fee_shipping) }} ₫</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-md-right">
                    <div class="float-lg-left mb-lg-0 mb-3">
                    </div>
                    <a target="_blank" href="https://yooridemo.spagreen.net/admin/orders/invoice/download/767"
                        class="btn btn-warning btn-icon icon-left"><i class="bx bx-download"></i> PDF</a>
                    <a href="#" onclick="window.print()" class="btn btn-info btn-icon icon-left"><i class="bx bx-printer"></i> In hóa đơn</a>
                </div>
            </div>
        </div>
    </div>
@endsection
