@extends('site.index')
@section('content')
    @include('site.pages._banner')
    @include('site.pages.products._featured_products')
    <section class="pt-9 pt-lg-10">
        <div class="container container-xl">
            <div class="row">
                <div class="col-12 col-lg-6 mb-6 mb-lg-0">
                    <div class="card border-0 banner banner-01 hover-zoom-in hover-shine" data-animate="fadeInUp">
                        <div class="card-img bg-img-cover-center"
                            style="background-image: url('{{ asset('public/site/images/banner-01.jpg') }}');"></div>
                        <div class="card-img-overlay d-inline-flex flex-column p-6 p-md-8">
                            <h6 class="card-subtitle mb-2 text-secondary letter-spacing-01">Hàng Mới Về</h6>
                            <h3 class="card-title fs-34 lh-129" style="max-width: 310px">Xem thêm các sản phẩm mới nhất
                            </h3>
                            <div class="mt-4">
                                <a href="#"
                                    class="fs-16 font-weight-600 btn text-secondary hover-white bg-white bg-hover-secondary shadow-1">Xem Thêm</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="card border-0 banner banner-01 hover-zoom-in hover-shine" data-animate="fadeInUp">
                        <div class="card-img bg-img-cover-center"
                            style="background-image: url('{{ asset('public/site/images/banner-02.jpg') }}');"></div>
                        <div class="card-img-overlay d-inline-flex flex-column p-6 p-md-8">
                            <h3 class="card-title fs-34 lh-129 mb-2">Giảm giá nhiều mặt hàng</h3>
                            <p class="card-text text-secondary font-weight-500" style="max-width: 236px;">
                                Tiết kiệm tới 50% cho các sản phẩm được chọn trong đợt giảm giá này.
                            </p>
                            <div class="mt-2">
                                <a href="#"
                                    class="fs-16 font-weight-600 btn text-secondary hover-white bg-white bg-hover-secondary shadow-1">Xem Thêm</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('site.pages.products._sale_products')
    <section class="pt-11 pb-xl-9 pb-5" style="background-color: #f7f7f7">
        <div class="container container-xl">
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-transparent border-0 align-items-center text-center mb-xl-0 mb-6"
                        data-animate="fadeInUp">
                        <div class="card-img">
                            <i class="fal fa-truck fs-48"></i>
                        </div>
                        <div class="card-body text-center">
                            <h3 class="card-title fs-20 mb-2">Miễn phí vận chuyển</h3>
                            <p class="cart-text mb-0">Miễn phí vận chuyển cho đơn hàng trên 1 triệu đồng</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-transparent border-0 align-items-center text-center mb-xl-0 mb-6"
                        data-animate="fadeInUp">
                        <div class="card-img">
                            <i class="fal fa-repeat fs-48"></i>
                        </div>
                        <div class="card-body text-center">
                            <h3 class="card-title fs-20 mb-2">Hoàn trả</h3>
                            <p class="cart-text mb-0">Trong vòng 30 ngày để đổi trả.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-transparent border-0 align-items-center text-center mb-xl-0 mb-6"
                        data-animate="fadeInUp">
                        <div class="card-img">
                            <i class="fal fa-headset fs-48"></i>
                        </div>
                        <div class="card-body text-center">
                            <h3 class="card-title fs-20 mb-2">Hỗ trợ trực tuyến</h3>
                            <p class="cart-text mb-0">24 giờ một ngày, 7 ngày một tuần</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-transparent border-0 align-items-center text-center mb-xl-0 mb-6"
                        data-animate="fadeInUp">
                        <div class="card-img">
                            <i class="fal fa-credit-card fs-48"></i>
                        </div>
                        <div class="card-body text-center">
                            <h3 class="card-title fs-20 mb-2">Thanh toán linh hoạt</h3>
                            <p class="cart-text mb-0">Thanh toán bằng nhiều phương thức </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
