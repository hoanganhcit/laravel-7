<div class="modal fade quick-view" id="quick-view" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0 py-0">
                <button type="button" class="close fs-32" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="row">
                    <div class="col-md-6 pr-xl-5 mb-8 mb-md-0 pl-xl-8">
                        <div class="galleries-product product galleries-product-02 position-relative">
                            <div class="mx-0" id="quickview-gallery-main">
                            </div>
                            <div class="mx-0 mt-3" id="quickview-gallery-nav">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 pl-xl-6 pr-xl-8">
                        <div id="quickview-content"></div>
                    </div>
                </div>
                <div class="row" id="loading_content" style="display: none;">
                    <div class="col-12">
                        <p class="text-center py-5">
                            <i class="fal fa-spinner fa-spin fa-3x text-muted"></i>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Wait for document ready
        $(document).ready(function() {

            // Quick view button click - use event delegation
            $(document).on('click', '.quick-view-btn', function(e) {
                e.preventDefault();
                var productId = $(this).data('product-id');

                // Show modal
                $('#quick-view').modal('show');

                // Destroy existing slick sliders first
                if ($('#quickview-gallery-main').hasClass('slick-initialized')) {
                    $('#quickview-gallery-main').slick('unslick');
                }
                if ($('#quickview-gallery-nav').hasClass('slick-initialized')) {
                    $('#quickview-gallery-nav').slick('unslick');
                }

                // Show loading, hide content
                $('#loading_content').show();
                $('#quickview-content').html('');
                $('#quickview-gallery-main').html('');
                $('#quickview-gallery-nav').html('');

                // Load product data - use absolute URL with proper base path
                var ajaxUrl = '{{ url('product/quick-view') }}/' + productId;

                $.ajax({
                    url: ajaxUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('Response:', response);
                        
                        if (response.success) {
                            var product = response.product;
                            var galleries = response.galleries;

                            // Build gallery HTML - main slider and nav
                            var galleryMainHtml = '';
                            var galleryNavHtml = '';

                            // First item is always product main photo
                            if (product.photo) {
                                galleryMainHtml += '<div class="box px-0">' +
                                    '<div class="card p-0 rounded-0 border-0">' +
                                    '<a href="' + product.photo + '" class="card-img">' +
                                    '<img src="' + product.photo + '" alt="' + product.name +
                                    '" style="width: 100%; height: auto;">' +
                                    '</a></div></div>';

                                galleryNavHtml += '<div class="box px-1">' +
                                    '<div class="card p-0 rounded-0 border">' +
                                    '<img src="' + product.photo + '" alt="' + product.name +
                                    '" style="width: 100%; height: auto; cursor: pointer;">' +
                                    '</div></div>';
                            }

                            // Then add gallery images
                            if (galleries && galleries.length > 0) {
                                galleries.forEach(function(gallery) {
                                    galleryMainHtml += '<div class="box px-0">' +
                                        '<div class="card p-0 rounded-0 border-0">' +
                                        '<a href="' + gallery.galleries +
                                        '" class="card-img">' +
                                        '<img src="' + gallery.galleries + '" alt="' +
                                        product.name +
                                        '" style="width: 100%; height: auto;">' +
                                        '</a></div></div>';

                                    galleryNavHtml += '<div class="box px-1">' +
                                        '<div class="card p-0 rounded-0 border">' +
                                        '<img src="' + gallery.galleries + '" alt="' +
                                        product.name +
                                        '" style="width: 100%; height: auto; cursor: pointer;">' +
                                        '</div></div>';
                                });
                            }

                            $('#quickview-gallery-main').html(galleryMainHtml);
                            $('#quickview-gallery-nav').html(galleryNavHtml);

                            // Re-initialize Slick slider after AJAX content loaded
                            // Destroy existing slick if any
                            if ($('#quickview-gallery-main').hasClass('slick-initialized')) {
                                $('#quickview-gallery-main').slick('unslick');
                            }
                            if ($('#quickview-gallery-nav').hasClass('slick-initialized')) {
                                $('#quickview-gallery-nav').slick('unslick');
                            }

                            // Wait for images to load then initialize slick
                            setTimeout(function() {
                                if (typeof $.fn.slick !== 'undefined') {
                                    // Main slider
                                    $('#quickview-gallery-main').slick({
                                        slidesToShow: 1,
                                        slidesToScroll: 1,
                                        arrows: false,
                                        dots: false,
                                        fade: true,
                                        adaptiveHeight: true,
                                        asNavFor: '#quickview-gallery-nav'
                                    });

                                    // Thumbnail navigation slider
                                    $('#quickview-gallery-nav').slick({
                                        slidesToShow: 4,
                                        slidesToScroll: 1,
                                        asNavFor: '#quickview-gallery-main',
                                        dots: false,
                                        arrows: true,
                                        centerMode: false,
                                        focusOnSelect: true,
                                        prevArrow: '<button type="button" class="slick-prev"><i class="fal fa-arrow-left"></i></button>',
                                        nextArrow: '<button type="button" class="slick-next"><i class="fal fa-arrow-right"></i></button>',
                                        responsive: [{
                                            breakpoint: 768,
                                            settings: {
                                                slidesToShow: 3
                                            }
                                        }]
                                    });
                                    
                                    // Hide loading after slick is initialized
                                    $('#loading_content').hide();
                                }
                            }, 300);

                            // Build price HTML
                            var priceHtml = '';
                            if (product.discount_price && product.discount_price < product
                                .price) {
                                var discountPercent = Math.round(((product.price - product
                                    .discount_price) / product.price) * 100);
                                priceHtml = '<p class="d-flex align-items-center mb-3">' +
                                    '<span class="text-decoration-line-through">' + parseInt(
                                        product.price).toLocaleString() + 'đ</span>' +
                                    '<span class="fs-18 text-danger font-weight-bold ml-3">' +
                                    parseInt(product.discount_price).toLocaleString() +
                                    'đ</span>' +
                                    '<span class="badge badge-primary fs-16 ml-4 font-weight-600 px-3">-' +
                                    discountPercent + '%</span>' +
                                    '</p>';
                            } else {
                                priceHtml = '<p class="d-flex align-items-center mb-3">' +
                                    '<span class="fs-18 text-secondary font-weight-bold">' +
                                    parseInt(product.price).toLocaleString() + 'đ</span>' +
                                    '</p>';
                            }

                            // Build categories
                            var categoriesHtml = '';
                            if (product.categories && product.categories.length > 0) {
                                categoriesHtml = product.categories.map(function(cat) {
                                    return '<a href="/shop?category=' + cat.slug + '" class="d-inline-block">' + cat.name + '</a>';
                                }).join(', ');
                            }
                            
                            var actionAddToCart = '<div class="row align-items-end no-gutters mx-n2">' +
                                '<div class="col-sm-4 form-group px-2 mb-6">' +
                                '<label class="text-secondary font-weight-600 mb-3" for="quickview-number">Quantity: </label>' +
                                '<div class="input-group position-relative w-100">' +
                                '<a href="#" class="down position-absolute pos-fixed-left-center pl-4 z-index-2"><i class="far fa-minus"></i></a>' +
                                '<input name="number" type="number" id="quickview-number" class="form-control w-100 px-6 text-center input-quality text-secondary h-60 fs-18 font-weight-bold border-0" value="1" required>' +
                                '<a href="#" class="up position-absolute pos-fixed-right-center pr-4 z-index-2"><i class="far fa-plus"></i></a>' +
                                '</div>' +
                                '</div>' +
                                '<div class="col-sm-8 mb-6 w-100 px-2">' +
                                '<button type="submit" class="btn btn-lg fs-18 btn-secondary btn-block h-60 bg-hover-primary border-0">Add To Bag</button>' +
                                '</div>' +
                                '</div>';

                            // Build content HTML
                            var contentHtml = '<h2 class="fs-24 mb-3">' + product.name + '</h2>' +
                                priceHtml +
                                (product.brand ?
                                    '<p class="text-muted mb-3"><strong>Thương hiệu:</strong> ' +
                                    product.brand.name + '</p>' : '') +
                                (product.short_description ? '<p class="mb-4">' + product
                                    .short_description + '</p>' : '') +
                                actionAddToCart +
                                '<ul class="list-unstyled border-top pt-4 mt-4">' +
                                '<li class="row mb-2">' +
                                '<span class="d-block col-4 text-secondary font-weight-600 fs-14">SKU:</span>' +
                                '<span class="d-block col-8 fs-14">' + (product.sku || 'N/A') +
                                '</span>' +
                                '</li>' +
                                (categoriesHtml ? '<li class="row mb-2">' +
                                    '<div class="d-block col-4 text-secondary font-weight-600 fs-14">Danh mục:</div>' +
                                    '<div class="d-block col-8 fs-14">' + categoriesHtml +
                                    '</div>' +
                                    '</li>' : '') +
                                '<li class="row mb-2">' +
                                '<span class="d-block col-4 text-secondary font-weight-600 fs-14">Tồn kho:</span>' +
                                '<span class="d-block col-8 fs-14">' + (product.quantity || 0) +
                                '</span>' +
                                '</li>' +
                                '</ul>';

                            $('#quickview-content').html(contentHtml);
                        } else {
                            $('#quickview-content').html(
                                '<p class="text-danger text-center">Không tìm thấy thông tin sản phẩm</p>'
                                );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', xhr.responseText);
                        console.error('Status:', status);
                        console.error('Error:', error);
                        
                        // Hide loading
                        $('#loading_content').hide();
                        
                        $('#quickview-content').html(
                            '<p class="text-danger text-center">Không thể tải thông tin sản phẩm. Vui lòng thử lại.</p>'
                            );
                    }
                });
            });
        });
    </script>
@endpush
