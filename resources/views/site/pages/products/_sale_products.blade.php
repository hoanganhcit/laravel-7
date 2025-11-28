<section>
    <div class="container container-xl">
        <div class="row mt-10 mt-lg-13 mb-6">
            <div class="col-12 text-center" data-animate="fadeInUp">
                <h2 class="mb-3">Sản Phẩm Giảm Giá</h2>
                <p class="mx-auto lh-166" style="max-width: 462px">Được làm từ các thành phần sạch, không độc hại, sản phẩm của chúng tôi được thiết kế dành cho mọi người.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 order-2 order-lg-1">
                <div class="row">
                    @forelse($sale_products as $product)
                    <div class="col-md-4 col-sm-6 mb-3" data-animate="fadeInLeft">
                        <div class="card border-0 product">
                            <div class="position-relative">
                                @if($product->photo)
                                <img src="{{ $product->photo }}" alt="{{ $product->name }}">
                                @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                                @endif
                                <div class="card-img-overlay d-flex p-3">
                                    <div>
                                        @if($product->discount_price && $product->discount_price < $product->price)
                                            @php
                                                $discount_percent = round((($product->price - $product->discount_price) / $product->price) * 100);
                                            @endphp
                                            <span class="badge badge-primary">-{{ $discount_percent }}%</span>
                                        @endif
                                    </div>
                                    <div class="my-auto w-100 content-change-vertical">
                                        <a href="#" data-toggle="tooltip" data-placement="left"
                                            title="Xem sản phẩm"
                                            class="add-to-cart ml-auto d-flex align-items-center justify-content-center text-secondary bg-white hover-white bg-hover-secondary w-48px h-48px rounded-circle mb-2">
                                            <i class="fal fa-box"></i>
                                        </a>
                                        <a href="#" data-toggle="tooltip" data-placement="left" title="Xem nhanh"
                                            data-product-id="{{ $product->id }}"
                                            class="quick-view-btn ml-auto d-flex align-items-center justify-content-center cursor-pointer text-secondary bg-white hover-white bg-hover-secondary w-48px h-48px rounded-circle mb-2">
                                            <i class="fal fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-toggle="tooltip" data-placement="left"
                                            title="Thêm vào giỏ hàng"
                                            data-product-id="{{ $product->id }}"
                                            class="add-to-cart ml-auto d-flex align-items-center justify-content-center text-secondary bg-white hover-white bg-hover-secondary w-48px h-48px rounded-circle mb-2">
                                            <i class="fal fa-shopping-bag"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-0 pt-4 text-center">
                                <p class="card-text font-weight-bold fs-16 mb-1 text-secondary">
                                    @if($product->discount_price && $product->discount_price < $product->price)
                                        <span class="fs-13 font-weight-500 text-decoration-through text-body pr-1">{{ number_format($product->price) }}đ</span>
                                        <span class="text-danger">{{ number_format($product->discount_price) }}đ</span>
                                    @else
                                        <span>{{ number_format($product->price) }}đ</span>
                                    @endif
                                </p>
                                <h2 class="card-title fs-15 font-weight-500 mb-2">
                                    <a href="{{ $product->slug }}">{{ $product->name }}</a>
                                </h2>
                                @if($product->brand)
                                    <p class="text-muted mb-2"><small>{{ $product->brand->name }}</small></p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            Chưa có sản phẩm giảm giá nào.
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
            <div class="col-lg-5 mb-8 mb-lg-0 order-1 order-lg-2" data-animate="fadeInRight">
                <div class="card border-0 hover-shine hover-zoom-in banner banner-04">
                    <div class="card-img bg-img-cover-center" style="background-image: url('{{ asset('public/site/images/banner-34.jpg') }}');">
                    </div>
                    <div class="card-img-overlay d-inline-flex flex-column justify-content-end p-8">
                        <h6 class="card-subtitle mb-1 text-white  lh-166 font-weight-normal">
                            Làm Đẹp</h6>
                        <h3 class="card-title fs-40 lh-13 text-white mb-6">Săn Sale Ngay</h3>
                        <div>
                            <a href="#"
                                class="fs-16 font-weight-600 btn text-secondary hover-white bg-white bg-hover-secondary shadow-1">Khám phá thêm</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>