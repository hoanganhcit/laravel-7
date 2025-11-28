<div class="col-xl-3 col-lg-4 col-md-6">
    <div class="card border-0 product mb-6">
        <div class="position-relative">
            <a href="{{ $product->slug ?? '#' }}">
                @if(isset($product->photo) && $product->photo)
                    <img src="{{ $product->photo }}" alt="{{ $product->name ?? 'Product' }}" class="card-img-top">
                @elseif(isset($product->feature_image_path) && $product->feature_image_path)
                    <img src="{{ asset($product->feature_image_path) }}" alt="{{ $product->name ?? 'Product' }}" class="card-img-top">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                        <i class="fas fa-image fa-3x text-muted"></i>
                    </div>
                @endif
            </a>
            <div class="card-img-overlay d-flex p-3 flex-column">
                <div class="mb-auto d-flex justify-content-center">
                    @if(isset($product->discount_price) && isset($product->price) && $product->discount_price && $product->discount_price < $product->price)
                        <div>
                            <span class="badge badge-primary">
                                -{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%
                            </span>
                        </div>
                    @endif
                    <div class="w-100 content-change-vertical">
                        <a href="{{ $product->slug ?? '#' }}" data-toggle="tooltip" data-placement="left"
                            title="Xem sản phẩm"
                            class="ml-auto d-flex align-items-center justify-content-center text-secondary bg-white hover-white bg-hover-secondary w-48px h-48px rounded-circle mb-2">
                            <i class="fal fa-box"></i>
                        </a>
                        <a href="#" data-toggle="tooltip" data-placement="left" title="Xem nhanh"
                            data-product-id="{{ $product->id ?? '' }}"
                            class="quick-view-btn ml-auto d-flex align-items-center justify-content-center cursor-pointer text-secondary bg-white hover-white bg-hover-secondary w-48px h-48px rounded-circle mb-2">
                            <i class="fal fa-eye"></i>
                        </a>
                        <a href="javascript:;" data-toggle="tooltip" data-placement="left"
                            title="Thêm vào giỏ hàng"
                            data-product-id="{{ $product->id ?? '' }}"
                            class="add-to-cart ml-auto d-flex align-items-center justify-content-center text-secondary bg-white hover-white bg-hover-secondary w-48px h-48px rounded-circle mb-2">
                            <i class="fal fa-shopping-bag"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body pt-4 text-center px-0">
            @if(isset($product->discount_price) && isset($product->price) && $product->discount_price && $product->discount_price < $product->price)
                <p class="card-text font-weight-bold fs-16 mb-1 text-secondary">
                    <span class="fs-13 font-weight-500 text-decoration-through text-body pr-1">
                        {{ number_format($product->price) }}đ
                    </span>
                    <span class="text-danger">{{ number_format($product->discount_price) }}đ</span>
                </p>
            @else
                <p class="card-text font-weight-bold fs-16 mb-1 text-secondary">
                    <span>{{ number_format($product->price ?? 0) }}đ</span>
                </p>
            @endif
            <h2 class="card-title fs-15 font-weight-500 mb-2">
                <a href="{{ $product->slug ?? '#' }}">{{ $product->name ?? 'Sản phẩm' }}</a>
            </h2>
            @if(isset($product->brand) && $product->brand)
                <p class="text-muted mb-2"><small>{{ $product->brand->name ?? '' }}</small></p>
            @endif
        </div>
    </div>
</div>
