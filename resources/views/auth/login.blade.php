@extends('layouts.auth')

@section('title') Login @endsection

@section('content')

<!-- Login-->
    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
            <h2 class="card-title fw-bold mb-1">Welcome to Vuexy! 👋</h2>
            <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>
            <form class="auth-login-form mt-2" method="post" action="{{ url('/login') }}">
                @csrf
                <div class="mb-1">
                    <label class="form-label" for="login-email">Email</label>
                    <!-- <input class="form-control" id="login-email" type="text" name="login-email" placeholder="john@example.com" aria-describedby="login-email" autofocus="" tabindex="1" /> -->
                    <input type="email" name="email" value="{{ old('email') }}" id="login-email" placeholder="Enter Your Email" class="form-control @error('email') is-invalid error @enderror">
                    @error('email')
                        <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-1">
                    <!-- <div class="d-flex justify-content-between">
                        <label class="form-label" for="login-password">Password</label><a href="{{ route('password.request') }}"><small>Forgot Password?</small></a>
                    </div> -->
                    <div class="input-group input-group-merge form-password-toggle @error('password') is-invalid @enderror">
                        <!-- <input class="form-control form-control-merge" id="login-password" type="password" name="login-password" placeholder="············" aria-describedby="login-password" tabindex="2" /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span> -->
                        <input type="password" name="password" id="login-password" placeholder="Enter Your Password" class="form-control form-control-merge @error('password') is-invalid error @enderror">
                        <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                        @error('password')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mb-1">
                    <div class="form-check">
                        <input class="form-check-input" id="remember-me" type="checkbox" tabindex="3" />
                        <label class="form-check-label" for="remember-me"> Remember Me</label>
                    </div>
                </div>
                <button class="btn btn-primary w-100" tabindex="4" type="submit">Sign in</button>
            </form>
<!--             <p class="text-center mt-2"><span>New on our platform?</span><a href="{{ route('register') }}"><span>&nbsp;Create an account</span></a></p>
 -->        </div>
    </div>
    <!-- /Login-->
    </div>

@endsection
