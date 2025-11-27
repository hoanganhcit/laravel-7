<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4 my-0" href="{{ route("admin.index") }}">
            <img src="{{asset('public/admin/images/logo.png')}}" height="35">
            {{-- <span class="logo-title">BONG STORE</span> --}}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.index") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fal fa-tachometer-alt-fast">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fal fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fas fa-circle sm-icon"></i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fas fa-circle sm-icon"></i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fas fa-circle sm-icon"></i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/products*") ? "c-show" : "" }} 
            {{ request()->is("admin/product-categories*") ? "c-show" : "" }} 
            {{ request()->is("admin/brands*") ? "c-show" : "" }} 
            {{ request()->is("admin/product-tags*") ? "c-show" : "" }} 
            {{ request()->is("admin/product-attributes*") ? "c-show" : "" }}
            {{ request()->is("admin/products/reviews") ? "c-show" : "" }} ">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                <i class="fa-fw fal fa-tshirt c-sidebar-nav-icon"></i> Quản lý sản phẩm
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.products.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/products") || request()->is("admin/products/*") ? "c-active" : "" }}">
                        <i class="fas fa-circle sm-icon"></i>
                        Sản Phẩm
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.product-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/product-categories") || request()->is("admin/product-categories/*") ? "c-active" : "" }}">
                        <i class="fas fa-circle sm-icon"></i>
                        Danh Mục Sản Phẩm
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.brands.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/brands") || request()->is("admin/brands/*") ? "c-active" : "" }}">
                        <i class="fas fa-circle sm-icon"></i>
                        Thương Hiệu
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.product-tags.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/product-tags") || request()->is("admin/product-tags/*") ? "c-active" : "" }}">
                        <i class="fas fa-circle sm-icon"></i>
                        Từ Khóa Sản Phẩm
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.product-attributes.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/product-attributes") || request()->is("admin/product-attributes/*") ? "c-active" : "" }}">
                        <i class="fas fa-circle sm-icon"></i>
                        Thuộc Tính Sản Phẩm
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a href="{{route('admin.products.reviews')}}" class="c-sidebar-nav-link">
                        <i class="fas fa-circle sm-icon"></i>
                        Đánh giá sản phẩm
                    </a>
                </li>
            </ul>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.orders.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/orders") || request()->is("admin/orders/*") ? "c-active" : "" }}">
                <i class="fal fa-shopping-bag c-sidebar-nav-icon"></i> Đơn Hàng
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.customers.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/customers") || request()->is("admin/customers/*") ? "c-active" : "" }}">
                <i class="fal fa-users c-sidebar-nav-icon"></i> Khách hàng
            </a>
        </li>
        <li class="c-sidebar-nav-dropdown 
            {{ request()->is("admin/settings*") ? "c-show" : "" }} 
            {{ request()->is("admin/banners*") ? "c-show" : "" }} 
            {{ request()->is("admin/file-manager*") ? "c-show" : "" }} 
            {{ request()->is("admin/testimonials*") ? "c-show" : "" }}">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                <i class="fa-fw  fal fa-cog c-sidebar-nav-icon"></i>
                CMS
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.settings.index") }}" class="c-sidebar-nav-link">
                        <i class="fas fa-circle sm-icon"></i> Cài đặt chung
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.banners.index") }}" class="c-sidebar-nav-link">
                        <i class="fas fa-circle sm-icon"></i> Banner
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.file-manager") }}" class="c-sidebar-nav-link">
                        <i class="fas fa-circle sm-icon"></i> Thư viện hình ảnh
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.testimonials.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/testimonials") || request()->is("admin/testimonials/*") ? "c-active" : "" }}">
                        <i class="fas fa-circle sm-icon"></i> Đánh giá của khách hàng
                    </a>
                </li>
            </ul>
        </li>
        <li class="c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                <i class="fa-fw  fal fa-envelope c-sidebar-nav-icon"></i>
                Quản Lý Liên Hệ
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.subscribers.contacts") }}" class="c-sidebar-nav-link">
                        <i class="fas fa-circle sm-icon"></i> Liên hệ
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.subscribers.index") }}" class="c-sidebar-nav-link">
                        <i class="fas fa-circle sm-icon"></i> Subscribers
                    </a>
                </li>
            </ul>
        </li>
        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/categories*") ? "c-show" : "" }} 
            {{ request()->is("admin/posts*") ? "c-show" : "" }} 
            {{ request()->is("admin/pages*") ? "c-show" : "" }}
            {{ request()->is("admin/tags*") ? "c-show" : "" }}
            {{ request()->is("admin/comments*") ? "c-show" : "" }}
            {{ request()->is("admin/press*") ? "c-show" : "" }}">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                <i class="fa-fw  fal fa-newspaper c-sidebar-nav-icon"></i>
                Quản Lý Bài Viết
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                @can('category_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/categories") || request()->is("admin/categories/*") ? "c-active" : "" }}">
                            <i class="fas fa-circle sm-icon"></i> Danh Mục Bài Viết
                        </a>
                    </li>
                @endcan
                @can('post_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.posts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/posts") || request()->is("admin/posts/*") ? "c-active" : "" }}">
                            <i class="fas fa-circle sm-icon"></i> Bài Viết
                        </a>
                    </li>
                @endcan
                @can('post_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.pages.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/pages") || request()->is("admin/pages/*") ? "c-active" : "" }}">
                        <i class="fas fa-circle sm-icon"></i> Chính Sách Mua Hàng
                    </a>
                </li>
                @endcan
                @can('tag_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.tags.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/tags") || request()->is("admin/tags/*") ? "c-active" : "" }}">
                            <i class="fas fa-circle sm-icon"></i> Từ Khóa
                        </a>
                    </li>
                @endcan
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.comments.index") }}" class="c-sidebar-nav-link">
                        <i class="fas fa-circle sm-icon"></i> Bình Luận Bài Viết
                    </a>
                </li>
            </ul>
        </li>
        
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fal fa-lock-alt c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fal fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>