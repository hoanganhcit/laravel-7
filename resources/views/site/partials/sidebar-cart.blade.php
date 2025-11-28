<div class="canvas-sidebar cart-canvas">
    <div class="canvas-overlay">
    </div>
    <div class="card border-0 pt-4 pb-7 h-100">
        <div class="px-6 text-right">
            <span class="canvas-close d-inline-block fs-24 mb-1 ml-auto lh-1 text-primary"><i
                    class="fal fa-times"></i></span>
        </div>
        <div class="card-header bg-transparent p-0 mx-6">
            <h3 class="fs-24 mb-5">
                Giỏ Hàng
            </h3>
            <p class="fs-15 font-weight-500 text-body mb-5">
                <span class="d-inline-block mr-2 fs-15 text-secondary">
                    <i class="far fa-shopping-bag"></i>
                </span>
                <span id="cart-item-count">{{ count(session()->get('cart', [])) }}</span> sản phẩm
            </p>
        </div>
        <div class="card-body px-6 pt-7 overflow-y-auto" id="cart-items-container">
            @include('site.partials._cart_items', ['cart' => session()->get('cart', [])])
        </div>
        <div class="card-footer mt-auto border-0 bg-transparent px-6 pb-0 pt-5">
            <div class="d-flex align-items-center mb-2">
                <span class="text-secondary fs-15">Tổng tiền:</span>
                <span class="d-block ml-auto fs-24 font-weight-bold text-secondary" id="cart-total-price">
                    @php
                        $cart = session()->get('cart', []);
                        $total = 0;
                        foreach($cart as $item) {
                            $total += $item['price'] * $item['quantity'];
                        }
                    @endphp
                    {{ number_format($total) }}đ
                </span>
            </div>
            <a href="{{ url('checkout') }}" class="btn btn-secondary btn-block mb-3 bg-hover-primary border-hover-primary">
                Thanh Toán
            </a>
            <a href="{{ url('cart') }}" class="btn btn-outline-secondary btn-block">Xem Giỏ Hàng</a>
        </div>
    </div>
</div>
