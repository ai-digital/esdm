@extends('backend.layouts.auth')

@section('title', 'Login')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
@endpush

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Login</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                <div class="form-group"> @csrf
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required
                        autofocus>

                    <div class="invalid-feedback">
                        Please fill in your email
                    </div>

                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">Password</label>
                        <div class="float-right">
                            <a href="auth-forgot-password.html" class="text-small">
                                Forgot Password?
                            </a>
                        </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                        Please fill in your password
                    </div>
                    @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <div class="d-block">

                        {!! NoCaptcha::display() !!}

                        @if ($errors->has('g-recaptcha-response'))
                            <span class="help-block">
                                <strong> <span
                                        class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span></strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Login
                    </button>
                </div>
            </form>


        </div>
    </div>
    {{-- <div class="text-muted mt-5 text-center">
        Don't have an account? <a href="auth-register.html">Create One</a>
    </div> --}}
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
