@extends('site.index')
@section('content')
<section class="py-2 bg-gray-2  mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-site py-0 d-flex justify-content-center">
                <li class="breadcrumb-item"><a class="text-decoration-none text-body" href="/">Trang Chủ</a>
                </li>
                <li class="breadcrumb-item active pl-0 d-flex align-items-center" aria-current="page">Cửa Hàng
                </li>
            </ol>
        </nav>
    </div>
</section>
<section>
    <div class="container container-xl">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <p class="fs-18 font-weight-500 my-lg-0 my-2" style="color: #696969;">
                Tìm thấy <strong class="font-weight-bold text-secondary" id="product-count">{{ $products->total() }}</strong>
                sản phẩm có sẵn cho bạn
            </p>
            <div class="d-flex align-items-center">
                <div class="switch-layout d-lg-flex align-items-center d-none">
                    <span class="pr-5">Xem</span>
                    <a href="#" class="active pr-5" title="Grid View">
                        <i class="fad fa-th-large fs-18"></i>
                    </a>
                    <a href="#" title="List View">
                        <i class="fad fa-list fs-18"></i>
                    </a>
                </div>
                <div class="dropdown show lh-1 rounded ml-lg-5 ml-0" style="background-color:#f5f5f5">
                    <a href="#"
                        class="dropdown-toggle custom-dropdown-toggle text-decoration-none text-secondary p-3 mw-210 position-relative d-block"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span id="sort-label">Sắp xếp mặc định</span>
                    </a>
                    <div class="dropdown-menu custom-dropdown-item" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item sort-option" href="#" data-sort="newest">Mới nhất</a>
                        <a class="dropdown-item sort-option" href="#" data-sort="oldest">Cũ nhất</a>
                        <a class="dropdown-item sort-option" href="#" data-sort="price_asc">Giá từ thấp đến cao</a>
                        <a class="dropdown-item sort-option" href="#" data-sort="price_desc">Giá từ cao đến thấp</a>
                        <a class="dropdown-item sort-option" href="#" data-sort="name_asc">Tên A-Z</a>
                        <a class="dropdown-item sort-option" href="#" data-sort="name_desc">Tên Z-A</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="mt-7 pb-11 pb-lg-13">
    <div class="container container-xl">
        <div class="row">
            <div class="col-lg-3 primary-sidebar sidebar-sticky pr-lg-8 d-lg-block d-none" id="sidebar">
                <div class="primary-sidebar-inner">
                    <div class="card border-0 mb-6">
                        <div class="card-header bg-transparent border-0 p-0">
                            <h4 class="card-title fs-20 mb-3">Lọc Theo Giá</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" class="form-control" id="minPrice" 
                                           placeholder="Giá từ" min="0" 
                                           value="{{ request('min_price', '') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control" id="maxPrice" 
                                           placeholder="Giá đến" min="0"
                                           value="{{ request('max_price', '') }}">
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary btn-block mt-3" id="applyPriceFilter">
                                Áp dụng
                            </button>
                        </div>
                    </div>
                    <div class="card border-0 mb-6">
                        <div class="card-header bg-transparent border-0 p-0">
                            <h4 class="card-title fs-20 mb-3">Danh Mục Sản Phẩm</h4>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-unstyled mb-0">
                                @foreach($categories as $category)
                                <li class="mb-2">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input filter-category" 
                                               id="category-{{ $category->id }}" 
                                               value="{{ $category->slug }}"
                                               {{ request('category') == $category->slug ? 'checked' : '' }}>
                                        <label class="custom-control-label fs-14 l text-body" 
                                               for="category-{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="card border-0 mb-6">
                        <div class="card-header bg-transparent border-0 p-0">
                            <h4 class="card-title fs-20 mb-3">Thương Hiệu</h4>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-unstyled mb-0">
                                @foreach($brands as $brand)
                                <li class="mb-2">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input filter-brand" 
                                               id="brand-{{ $brand->id }}" 
                                               value="{{ $brand->id }}"
                                               {{ request('brand') == $brand->id ? 'checked' : '' }}>
                                        <label class="custom-control-label text-body" 
                                               for="brand-{{ $brand->id }}">
                                            {{ $brand->name }}
                                        </label>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row" id="products-container">
                    @foreach($products as $product)
                        @include('site.pages.products._product_card', ['product' => $product])
                    @endforeach
                </div>
                <nav class="pt-3" id="pagination-container">
                    {{ $products->links() }}
                </nav>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let currentFilters = {
        category: '{{ request("category", "") }}',
        brand: '{{ request("brand", "") }}',
        min_price: '{{ request("min_price", "") }}',
        max_price: '{{ request("max_price", "") }}',
        sort: '{{ request("sort", "") }}',
        page: 1
    };

    function loadProducts() {
        // Build query string
        let queryParams = {};
        if (currentFilters.category) queryParams.category = currentFilters.category;
        if (currentFilters.brand) queryParams.brand = currentFilters.brand;
        if (currentFilters.min_price) queryParams.min_price = currentFilters.min_price;
        if (currentFilters.max_price) queryParams.max_price = currentFilters.max_price;
        if (currentFilters.sort) queryParams.sort = currentFilters.sort;
        if (currentFilters.page > 1) queryParams.page = currentFilters.page;

        console.log('Loading products with filters:', queryParams);

        // Show loading state
        $('#products-container').html('<div class="col-12 text-center py-5"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');
        
        $.ajax({
            url: '{{ route("site.shop.index") }}',
            type: 'GET',
            data: queryParams,
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            success: function(response) {
                console.log('AJAX response:', response);
                
                if (response && response.success !== false && response.html) {
                    $('#products-container').html(response.html);
                    
                    if (response.pagination) {
                        $('#pagination-container').html(response.pagination);
                    }
                    
                    if (response.total !== undefined) {
                        $('#product-count').text(response.total);
                    }
                    
                    // Reinit tooltips for new content
                    if (typeof $('[data-toggle="tooltip"]').tooltip === 'function') {
                        $('[data-toggle="tooltip"]').tooltip();
                    }
                    
                    // Scroll to top of products
                    if ($('#products-container').length) {
                        $('html, body').animate({
                            scrollTop: $('#products-container').offset().top - 100
                        }, 500);
                    }
                } else {
                    console.error('Invalid response format:', response);
                    let errorMsg = response.message || 'Lỗi khi tải sản phẩm. Vui lòng thử lại.';
                    $('#products-container').html('<div class="col-12 text-center py-5"><p class="text-danger">' + errorMsg + '</p></div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading products:', {xhr: xhr, status: status, error: error});
                console.error('Response text:', xhr.responseText);
                
                let errorMsg = 'Lỗi khi tải sản phẩm. Vui lòng thử lại.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                } else if (xhr.status === 500) {
                    errorMsg = 'Lỗi server. Vui lòng kiểm tra console để biết thêm chi tiết.';
                } else if (xhr.status === 404) {
                    errorMsg = 'Không tìm thấy trang. Vui lòng kiểm tra route.';
                }
                
                $('#products-container').html('<div class="col-12 text-center py-5"><p class="text-danger">' + errorMsg + '</p></div>');
            }
        });
    }

    // Category filter
    $('.filter-category').on('change', function() {
        let selectedCategories = [];
        $('.filter-category:checked').each(function() {
            selectedCategories.push($(this).val());
        });
        currentFilters.category = selectedCategories.join(',');
        currentFilters.page = 1;
        loadProducts();
    });

    // Brand filter
    $('.filter-brand').on('change', function() {
        let selectedBrands = [];
        $('.filter-brand:checked').each(function() {
            selectedBrands.push($(this).val());
        });
        currentFilters.brand = selectedBrands.join(',');
        currentFilters.page = 1;
        loadProducts();
    });

    // Price filter
    $('#applyPriceFilter').on('click', function() {
        currentFilters.min_price = $('#minPrice').val();
        currentFilters.max_price = $('#maxPrice').val();
        currentFilters.page = 1;
        loadProducts();
    });

    // Quick filters
    $('.quick-filter').on('click', function(e) {
        e.preventDefault();
        let filter = $(this).data('filter');
        
        if (filter === 'newest') {
            currentFilters.sort = 'newest';
        } else if (filter === 'sale') {
            // Clear all filters and show only sale products
            currentFilters = {
                category: '',
                brand: '',
                min_price: '',
                max_price: '',
                sort: 'sale',
                page: 1
            };
            $('.filter-category, .filter-brand').prop('checked', false);
            $('#minPrice, #maxPrice').val('');
        }
        
        currentFilters.page = 1;
        loadProducts();
    });

    // Sort options
    $('.sort-option').on('click', function(e) {
        e.preventDefault();
        let sortValue = $(this).data('sort');
        let sortLabel = $(this).text();
        
        currentFilters.sort = sortValue;
        currentFilters.page = 1;
        $('#sort-label').text(sortLabel);
        
        loadProducts();
    });

    // Pagination
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        if (url && url !== '#') {
            try {
                // Parse URL to get page number
                let urlObj = new URL(url, window.location.origin);
                let page = urlObj.searchParams.get('page');
                if (page) {
                    currentFilters.page = parseInt(page);
                    loadProducts();
                }
            } catch (error) {
                console.error('Error parsing pagination URL:', error);
            }
        }
    });
});
</script>
@endsection
