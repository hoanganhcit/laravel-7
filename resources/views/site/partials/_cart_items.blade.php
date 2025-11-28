@if(count($cart) > 0)
    @foreach($cart as $key => $item)
    <div class="mb-4 d-flex cart-item" data-cart-key="{{ $key }}">
        <a href="#" class="remove-cart-item d-flex align-items-center mr-2 text-muted" data-cart-key="{{ $key }}">
            <i class="fal fa-times"></i>
        </a>
        <div class="media w-100">
            <div class="w-60px mr-3">
                @if($item['image'])
                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="img-fluid">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 60px;">
                        <i class="fas fa-image text-muted"></i>
                    </div>
                @endif
            </div>
            <div class="media-body d-flex">
                <div class="cart-price pr-6">
                    @if($item['price'] < $item['original_price'])
                        <p class="fs-14 font-weight-bold text-secondary mb-1">
                            <span class="font-weight-500 fs-13 text-line-through text-body mr-1">
                                {{ number_format($item['original_price']) }}đ
                            </span>
                            {{ number_format($item['price']) }}đ
                        </p>
                    @else
                        <p class="fs-14 font-weight-bold text-secondary mb-1">
                            {{ number_format($item['price']) }}đ
                        </p>
                    @endif
                    <a href="{{ $item['slug'] }}" class="text-secondary">{{ $item['name'] }}</a>
                    @if($item['variation'])
                        <div class="text-muted fs-13 mt-1">
                            @foreach($item['variation']['attributes'] as $attrId => $values)
                                @foreach($values as $value)
                                    <small>{{ $value['name'] ?? '' }}</small>
                                @endforeach
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="position-relative ml-auto">
                    <div class="input-group">
                        <a href="#" class="cart-qty-down position-absolute pos-fixed-left-center pl-2" 
                           data-cart-key="{{ $key }}">
                            <i class="far fa-minus"></i>
                        </a>
                        <input type="number" 
                               class="cart-quantity number-cart w-90px px-6 text-center h-40px bg-input border-0" 
                               value="{{ $item['quantity'] }}" 
                               min="1"
                               data-cart-key="{{ $key }}"
                               readonly>
                        <a href="#" class="cart-qty-up position-absolute pos-fixed-right-center pr-2"
                           data-cart-key="{{ $key }}">
                            <i class="far fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@else
    <div class="text-center py-5">
        <i class="fal fa-shopping-cart fa-3x text-muted mb-3"></i>
        <p class="text-muted">Giỏ hàng trống</p>
    </div>
@endif
