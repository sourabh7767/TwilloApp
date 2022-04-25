@extends('layouts.auth')

@section('title') Dashboard @endsection

@section('content')

<!-- Register-->
<div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
    <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
        <h2 class="card-title fw-bold mb-1">Adventure starts here 🚀</h2>
        <p class="card-text mb-2">Make your app management easy and fun!</p>
        <form class="auth-register-form mt-2" method="post" action="{{ route('register') }}">
            @csrf
            <div class="mb-1">
                <label class="form-label" for="register-username">Full Name</label>
                <!-- <input class="form-control" id="register-username" type="text" name="register-username" placeholder="johndoe" aria-describedby="register-username" autofocus="" tabindex="1" /> -->
                <input type="text" name="name" id="register-username" class="form-control @error('name') is-invalid error @enderror" value="{{ old('name') }}" placeholder="Full name">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-1">
                <label class="form-label" for="register-email">Email</label>
                <!-- <input class="form-control" id="register-email" type="text" name="register-email" placeholder="john@example.com" aria-describedby="register-email" tabindex="2" /> -->
                <input type="email" name="email" id="register-email" value="{{ old('email') }}" class="form-control @error('email') is-invalid error @enderror" placeholder="Email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-1">
                <label class="form-label" for="register-password">Password</label>
                <div class="input-group input-group-merge form-password-toggle @error('password') is-invalid @enderror">
                    <!-- <input class="form-control form-control-merge" id="register-password" type="password" name="register-password" placeholder="············" aria-describedby="register-password" tabindex="3" /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span> -->
                    <input type="password" name="password" class="form-control form-control-merge @error('password') is-invalid error @enderror" placeholder="Password">
                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-1">
                <label class="form-label" for="register-password">Confirm Password</label>
                <div class="input-group input-group-merge form-password-toggle @error('password_confirmation') is-invalid @enderror">
                    <!-- <input class="form-control form-control-merge" id="register-password" type="password" name="register-password" placeholder="············" aria-describedby="register-password" tabindex="3" /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span> -->
                    <input type="password" name="password_confirmation" class="form-control form-control-merge @error('password_confirmation') is-invalid error @enderror" placeholder="Password">
                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                    @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-1">
                <div class="form-check">
                    <input class="form-check-input" id="register-privacy-policy" type="checkbox" tabindex="4" />
                    <label class="form-check-label" for="register-privacy-policy">I agree to<a href="#">&nbsp;privacy policy & terms</a></label>
                </div>
            </div>
            <button class="btn btn-primary w-100" tabindex="5">Sign up</button>
        </form>
        <p class="text-center mt-2"><span>Already have an account?</span><a href="{{ route('login') }}"><span>&nbsp;Sign in instead</span></a></p>
    </div>
</div>
<!-- /Register-->

    
@endsection
