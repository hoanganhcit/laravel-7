<section>
    <div class="slick-slider mx-0 slider"
        data-slick-options='{"slidesToShow": 1,"infinite":true,"autoplay":true,"dots":false,"arrows":false,"fade":true,"cssEase":"ease-in-out","speed":600}'>
        @forelse($banners as $banner)
        <div class="box px-0">
            <div class="bg-img-cover-center py-12 pt-lg-18 pb-lg-17"
                style="background-image: url('{{ $banner->photo }}');">
                <div class="container container-xl py-7">
                    <div class="text-center" style="max-width: 454px" data-animate="fadeInDown">
                        @if($banner->sub_title)
                            <p class="text-primary fs-56 lh-113 mb-6 custom-font">{{ $banner->sub_title }}</p>
                        @endif
                        @if($banner->title)
                            <h1 class="mb-4 fs-56 lh-128">{{ $banner->title }}</h1>
                        @endif
                        @if($banner->description)
                            <p class="fs-18 lh-166 mb-7" style="max-width: 454px">{{ $banner->description }}</p>
                        @endif
                    </div>
                    @if($banner->productCategory)
                    <div class="text-center" style="max-width: 454px" data-animate="fadeInUp">
                        <a href="{{ route('site.product-category.show', $banner->productCategory->id) }}" 
                           class="btn btn-secondary rounded bg-hover-primary border-0">Xem Ngay</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        {{-- Banner mặc định nếu chưa có banner trong DB --}}
        <div class="box px-0">
            <div class="d-flex align-items-center justify-content-center bg-light" style="min-height: 100vh;">
                <div class="text-center">
                    <i class="fas fa-image fa-5x text-muted mb-4"></i>
                    <h3 class="text-muted">Chưa có banner nào</h3>
                    <p class="text-muted">Vui lòng thêm banner trong trang quản trị</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</section>