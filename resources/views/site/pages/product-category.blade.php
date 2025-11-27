@extends('site.layouts.app')

@section('content')
<div class="container py-5">
    <!-- Category Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site.index') }}">Trang chủ</a></li>
                    @if($category->parent)
                        <li class="breadcrumb-item"><a href="{{ route('site.product-category.show', $category->parent->id) }}">{{ $category->parent->title }}</a></li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $category->title }}</li>
                </ol>
            </nav>
            
            <h1 class="mb-3">{{ $category->title }}</h1>
            
            @if($category->description)
                <p class="text-muted">{{ $category->description }}</p>
            @endif
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100">
                        @if($product->photo)
                            <img src="{{ $product->photo }}" class="card-img-top" alt="{{ $product->title }}" style="height: 250px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->title }}</h5>
                            
                            @if($product->brand)
                                <p class="text-muted mb-2"><small>{{ $product->brand->name }}</small></p>
                            @endif
                            
                            <div class="mb-2">
                                @if($product->discount_price && $product->discount_price < $product->price)
                                    <span class="text-danger font-weight-bold">{{ number_format($product->discount_price) }}đ</span>
                                    <span class="text-muted text-decoration-line-through ml-2"><small>{{ number_format($product->price) }}đ</small></span>
                                @else
                                    <span class="font-weight-bold">{{ number_format($product->price) }}đ</span>
                                @endif
                            </div>
                            
                            @if($product->variations->count() > 0)
                                @php
                                    $totalQuantity = $product->variations->sum('quantity');
                                @endphp
                                @if($totalQuantity <= 0)
                                    <span class="badge badge-danger">Hết hàng</span>
                                @elseif($product->low_stock_to_notify && $totalQuantity <= $product->low_stock_to_notify)
                                    <span class="badge badge-warning">Sắp hết hàng</span>
                                @endif
                            @endif
                        </div>
                        
                        <div class="card-footer bg-white border-top-0">
                            <a href="#" class="btn btn-primary btn-block">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle mr-2"></i>
            Chưa có sản phẩm nào trong danh mục này.
        </div>
    @endif
</div>
@endsection
