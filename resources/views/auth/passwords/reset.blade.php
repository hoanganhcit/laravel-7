@extends('layouts.app')
@section('content')
    <div class=" py-13 px-9">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card mx-4">
                        <div class="card-body p-4">
                            <p class="fs-24">Đặt Lại Mật Khẩu</p>

                            {{-- <p class="text-muted">Reset Password</p> --}}

                            <form method="POST" action="{{ route('password.request') }}">
                                @csrf

                                <input name="token" value="{{ $token }}" type="hidden">

                                <div class="form-group">
                                    <input id="email" type="email" name="email"
                                        class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" required
                                        autocomplete="email" autofocus placeholder="Email"
                                        value="{{ $email ?? old('email') }}">

                                    @if ($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input id="password" type="password" name="password" class="form-control" required
                                        placeholder="Password">

                                    @if ($errors->has('password'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('password') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input id="password-confirm" type="password" name="password_confirmation"
                                        class="form-control" required placeholder="Confirm Password">
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                                            Đặt lại
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