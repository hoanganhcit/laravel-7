(function ($) {
    "use strict";

    // Cart object
    const Cart = {
        // Get base URL from meta tag or fallback
        getBaseUrl: function() {
            const appUrl = $('meta[name="app-url"]').attr('content');
            return appUrl || window.location.origin + '/laravel-7';
        },

        // Add to cart
        add: function(productId, quantity = 1, variationId = null) {
            $.ajax({
                url: Cart.getBaseUrl() + '/cart/add',
                type: 'POST',
                data: {
                    product_id: productId,
                    quantity: quantity,
                    variation_id: variationId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Update cart UI
                        Cart.updateUI(response);
                        
                        // Show success message
                        Cart.showMessage(response.message || 'Đã thêm vào giỏ hàng', 'success');
                        
                        // Open cart sidebar
                        $('.cart-canvas').addClass('show-canvas');
                    }
                },
                error: function(xhr) {
                    let message = 'Có lỗi xảy ra. Vui lòng thử lại.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    Cart.showMessage(message, 'error');
                }
            });
        },

        // Update cart quantity
        update: function(cartKey, quantity) {
            $.ajax({
                url: Cart.getBaseUrl() + '/cart/update',
                type: 'POST',
                data: {
                    cart_key: cartKey,
                    quantity: quantity,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Cart.updateUI(response);
                        Cart.showMessage(response.message, 'success');
                    }
                },
                error: function(xhr) {
                    let message = 'Có lỗi xảy ra khi cập nhật giỏ hàng.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    Cart.showMessage(message, 'error');
                }
            });
        },

        // Remove from cart
        remove: function(cartKey) {
            if (!confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                return;
            }

            $.ajax({
                url: Cart.getBaseUrl() + '/cart/remove',
                type: 'POST',
                data: {
                    cart_key: cartKey,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Cart.updateUI(response);
                        Cart.showMessage(response.message, 'success');
                    }
                },
                error: function(xhr) {
                    let message = 'Có lỗi xảy ra khi xóa sản phẩm.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    Cart.showMessage(message, 'error');
                }
            });
        },

        // Update cart UI
        updateUI: function(response) {
            if (response.cart_html) {
                $('#cart-items-container').html(response.cart_html);
            }

            if (response.summary) {
                // Update cart count
                $('#cart-item-count').text(response.summary.total_items);
                
                // Update cart total price
                $('#cart-total-price').text(Cart.formatPrice(response.summary.total_price));
                
                // Update header cart count badge
                $('.header-cart-count').text(response.summary.total_items);
                
                // Update header cart total price
                $('#header-cart-total').text(Cart.formatPrice(response.summary.total_price));
                $('#header-cart-total-mobile').text(Cart.formatPrice(response.summary.total_price));
            }
        },

        // Format price
        formatPrice: function(price) {
            return new Intl.NumberFormat('vi-VN').format(price) + 'đ';
        },

        // Show message
        showMessage: function(message, type = 'success') {
            // Using alertify if available
            if (typeof alertify !== 'undefined') {
                if (type === 'success') {
                    alertify.success(message);
                } else {
                    alertify.error(message);
                }
            } else {
                // Fallback to alert
                alert(message);
            }
        }
    };

    // Event handlers
    $(document).ready(function() {
        // Add to cart button click
        $(document).on('click', '.add-to-cart', function(e) {
            e.preventDefault();
            
            const $btn = $(this);
            const productId = $btn.data('product-id') || $btn.closest('.product').find('.quick-view-btn').data('product-id');
            const quantity = $btn.data('quantity') || 1;
            const variationId = $btn.data('variation-id') || null;

            if (!productId) {
                Cart.showMessage('Không tìm thấy thông tin sản phẩm', 'error');
                return;
            }

            // Disable button
            $btn.prop('disabled', true);
            
            Cart.add(productId, quantity, variationId);
            
            // Re-enable button after 1 second
            setTimeout(function() {
                $btn.prop('disabled', false);
            }, 1000);
        });

        // Increase quantity
        $(document).on('click', '.cart-qty-up', function(e) {
            e.preventDefault();
            const cartKey = $(this).data('cart-key');
            const $input = $('input[data-cart-key="' + cartKey + '"]');
            const currentQty = parseInt($input.val()) || 1;
            const newQty = currentQty + 1;
            
            $input.val(newQty);
            Cart.update(cartKey, newQty);
        });

        // Decrease quantity
        $(document).on('click', '.cart-qty-down', function(e) {
            e.preventDefault();
            const cartKey = $(this).data('cart-key');
            const $input = $('input[data-cart-key="' + cartKey + '"]');
            const currentQty = parseInt($input.val()) || 1;
            
            if (currentQty > 1) {
                const newQty = currentQty - 1;
                $input.val(newQty);
                Cart.update(cartKey, newQty);
            }
        });

        // Remove from cart
        $(document).on('click', '.remove-cart-item', function(e) {
            e.preventDefault();
            const cartKey = $(this).data('cart-key');
            Cart.remove(cartKey);
        });

        // Canvas close
        $(document).on('click', '.canvas-close, .canvas-overlay', function() {
            $('.cart-canvas').removeClass('show-canvas');
        });

        // Open cart canvas
        $(document).on('click', '.open-cart', function(e) {
            e.preventDefault();
            $('.cart-canvas').addClass('show-canvas');
        });
    });

    // Expose Cart object globally
    window.Cart = Cart;

})(jQuery);
