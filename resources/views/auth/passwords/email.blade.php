@extends('layouts.app')
@section('content')
    <div class=" py-13 px-9">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card mx-4">
                        <div class="card-body p-4">
                            <p class="fs-24">Nhập Email Của Bạn</p>

                            <p class="text-muted">Chúng tôi sẽ gửi cho bạn một email để kích hoạt việc đặt lại mật khẩu.</p>

                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="form-group">
                                    <input id="email" type="email"
                                        class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                        required autocomplete="email" autofocus placeholder="Email"
                                        value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-flat btn-block">
                                            Gửi
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
<style>
@media (min-width: 992px) {
    .c-app {
		background: url({{asset('public/admin/images/login-background.webp')}}) no-repeat center top;
		background-color: #f4f6f8 !important;
        background-size: contain;
    }
}
</style>
@endsection