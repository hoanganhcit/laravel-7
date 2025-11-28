<header class="main-header navbar-light header-sticky {{ Request::is('/') ? 'position-absolute fixed-top header-sticky-smart' : '' }} ">
    <div class="sticky-area">
        <div class="container container-xxl">
            <nav class="navbar navbar-expand-xl px-0 py-4 d-block">
                <div class="d-none d-xl-block">
                    <div class="d-flex align-items-center flex-nowrap">
                        <div class="w-50">
                            <div class="d-flex mt-3 mt-xl-0 align-items-center w-100">
                                <a class="navbar-brand d-inline-block py-0" href="{{ url('/') }}">
                                    <img src="{{ asset('public/site/images/logo.png') }}" alt="Như Võ Cosmetics">
                                </a>
                            </div>
                        </div>
                        <div class="w-50">
                            <div class="d-flex align-items-center justify-content-end">
                                <a href="#search-popup" data-gtf-mfp="true"
                                    data-mfp-options='{"type":"inline","focus": "#keyword","mainClass": "mfp-search-form mfp-move-from-top mfp-align-top"}'
                                    class="nav-search d-flex align-items-center pr-3">
                                    <i class="fal fa-search fs-18"></i>
                                </a>
                                <ul
                                    class="navbar-nav flex-row justify-content-xl-end d-flex flex-wrap text-body py-0 navbar-right">
                                    <li class="nav-item">
                                        <a class="nav-link pr-3 py-0" href="#" data-toggle="modal"
                                            data-target="#sign-in">
                                            <i class="fal fa-user"></i>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link position-relative px-4 menu-cart py-0 d-inline-flex align-items-center mr-n2 open-cart"
                                            href="javascript:void(0)">
                                            @php
                                                $cart = session()->get('cart', []);
                                                $total = 0;
                                                $count = 0;
                                                foreach($cart as $item) {
                                                    $total += $item['price'] * $item['quantity'];
                                                    $count += $item['quantity'];
                                                }
                                            @endphp
                                            @if($total > 0)
                                                <span class="mr-2 font-weight-bold fs-15" id="header-cart-total">{{ number_format($total) }}đ</span>
                                            @endif
                                            <i class="fal fa-shopping-bag fs-22"></i>
                                            <span class="position-absolute number header-cart-count">{{ $count }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center d-xl-none justify-between">
                    <div class="mb-logo"><a class="navbar-brand d-inline-block" href="{{ url('/') }}">
                            <img src="{{ asset('public/site/images/logo.png') }}" alt="Như Võ Cosmetics">
                        </a></div>
                    <div class="d-flex navbar-right">
                        <a href="#search-popup" data-gtf-mfp="true"
                            data-mfp-options='{"type":"inline","focus": "#keyword","mainClass": "mfp-search-form mfp-move-from-top mfp-align-top"}'
                            class="nav-search d-flex align-items-center">
                            <i class="fal fa-search fs-18"></i>
                            <span class="d-none d-xl-inline-block ml-2 font-weight-500">Search</span></a>
                        <a class="nav-link position-relative px-4 menu-cart py-0 d-inline-flex align-items-center mr-n2 open-cart"
                            href="javascript:void(0)">
                            @php
                                $cart = session()->get('cart', []);
                                $total = 0;
                                $count = 0;
                                foreach($cart as $item) {
                                    $total += $item['price'] * $item['quantity'];
                                    $count += $item['quantity'];
                                }
                            @endphp
                            @if($total > 0)
                                <span class="mr-2 font-weight-bold fs-15" id="header-cart-total-mobile">{{ number_format($total) }}đ</span>
                            @endif
                            <i class="fal fa-shopping-bag fs-22"></i>
                            <span class="position-absolute number header-cart-count">{{ $count }}</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
