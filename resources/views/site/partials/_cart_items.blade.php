@if (count($cart) > 0)
    @foreach ($cart as $key => $item)
        <div class="cart-item border-bottom pb-2 mb-2" data-cart-key="{{ $key }}">
            <div class="d-flex align-items-center mb-3">
                <div class="mr-3" style="flex-shrink: 0;">
                    @if ($item['image'])
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="rounded-circle"
                            style="width: 50px; height: 50px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <i class="fas fa-image text-muted"></i>
                        </div>
                    @endif
                </div>
                <div class="flex-grow-1" style="min-width: 0;">
                    <a href="{{ $item['slug'] }}" class="text-secondary font-weight-600 d-block mb-1"
                        style="font-size: 14px; line-height: 1.3;">{{ $item['name'] }}</a>
                    @if ($item['variation'])
                        <div class="text-muted" style="font-size: 12px;">
                            @foreach ($item['variation']['attributes'] as $attrId => $values)
                                @foreach ($values as $value)
                                    <span class="d-inline-block mr-2">{{ $value['name'] ?? '' }}</span>
                                @endforeach
                            @endforeach
                        </div>
                    @endif
                    <div class="mt-1">
                        @if ($item['price'] < $item['original_price'])
                            <span class="font-weight-bold text-secondary" style="font-size: 14px;">
                                {{ number_format($item['price']) }}đ
                            </span>
                            <span class="text-muted text-decoration-line-through ml-1" style="font-size: 12px;">
                                {{ number_format($item['original_price']) }}đ
                            </span>
                        @else
                            <span class="font-weight-bold text-secondary" style="font-size: 14px;">
                                {{ number_format($item['price']) }}đ
                            </span>
                        @endif
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <div class="input-group" style="width: 110px;">
                            <div class="input-group-prepend">
                                <button class="btn btn-sm btn-outline-secondary cart-qty-down" type="button"
                                    data-cart-key="{{ $key }}" style="padding: 0.25rem 0.5rem;">
                                    <i class="far fa-minus" style="font-size: 10px;"></i>
                                </button>
                            </div>
                            <input type="number"
                                class="form-control bg-white border-black form-control-sm text-center cart-quantity border-left-0 border-right-0"
                                value="{{ $item['quantity'] }}" min="1" data-cart-key="{{ $key }}"
                                style="padding: 0.25rem 0.5rem; font-weight: 600;">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-outline-secondary cart-qty-up" type="button"
                                    data-cart-key="{{ $key }}" style="padding: 0.25rem 0.5rem;">
                                    <i class="far fa-plus" style="font-size: 10px;"></i>
                                </button>
                            </div>
                        </div>
                        <a href="#" class="remove-cart-item text-danger" data-cart-key="{{ $key }}"
                            title="Xóa">
                            <i class="fad fa-trash" style="font-size: 16px;"></i>
                        </a>
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
