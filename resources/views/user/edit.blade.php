@extends('layouts.admin')

@section('title') Edit User @endsection

@section('content')

@push('page_style')

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
@endpush

  <!-- Basic multiple Column Form section start -->
                <section id="multiple-column-form">
                    <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('user.home')}}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('users.index')}}">User</a>
                                    </li>
                                    <li class="breadcrumb-item active">Edit User
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
       
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Edit User</h4>
                                </div>
                                <div class="card-body">
                                   <form method="POST" action="{{ route('users.update', $userObj->id) }}">
                                    @csrf
                                    @method('put')
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="full_name">Full Name <span class="text-danger asteric-sign">&#42;</span></label>
                                                      <input id="full_name" type="text" class="form-control {{ $errors->has('full_name') ? ' is-invalid' : '' }}" name="full_name" value="{{ (old('full_name')) ? (old('full_name')) : ($userObj->full_name) }}" placeholder="Full Name">
                                                        @if ($errors->has('full_name'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('full_name') }}</strong>
                                                            </span>
                                                        @endif
                                                   
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="role">Role <span class="text-danger asteric-sign">&#42;</span></label>
                                                    <select class="form-control {{ $errors->has('role') ? ' is-invalid' : '' }}" id="role" name="role">
                                                     @foreach($roles as $key=>$value)
                                                   <option value="{{$value->id}}" {{($value->id == $userObj->role)?"selected":""}}>{{$value->title}}</option>
                                                @endforeach
                                                   </select>
                                                    @if ($errors->has('role'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('role') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="email">Email <span class="text-danger asteric-sign">&#42;</span></label>
                                                     <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ (old('email')) ? (old('email')) : ($userObj->email) }}" placeholder="Enter Email">
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="phone_number">Phone Number <span class="text-danger asteric-sign">&#42;</span></label><br>
                                                    <input type="hidden" name="phone_code" id="phone_code" value="{{ (old('phone_code')) ? (old('phone_code')) : ($userObj->phone_code) }}"/>
                                                    <input type="hidden" name="iso_code" id="iso_code" value="{{ (old('iso_code')) ? (old('iso_code')) : ($userObj->iso_code) }}"/>

                                                    <input id="phone_number" type="text" class="form-control {{ $errors->has('phone_number') || $errors->has('phone_code') || $errors->has('iso_code') ? ' is-invalid' : '' }}" name="phone_number" value="{{ (old('phone_number')) ? (old('phone_number')) : ($userObj->phone_number) }}">
                                                    @if ($errors->has('phone_number'))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                                        </span>
                                                    @elseif($errors->has('phone_code'))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ $errors->first('phone_code') }}</strong>
                                                        </span>
                                                    @elseif($errors->has('iso_code'))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ $errors->first('iso_code') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        
                                            <div class="col-12">
                                                <button type="Submit" class="btn btn-primary me-1">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Basic Floating Label Form section end -->



@push('page_script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    
   <script>

        var isoCode = ($("#iso_code").val()) ? ($("#iso_code").val()) : ('US');
        var isoCode2 = ($("#iso_code_2").val()) ? ($("#iso_code_2").val()) : ('US');
        //  phone 1 input
        var phoneInput = document.querySelector("#phone_number");
        var phoneInstance = window.intlTelInput(phoneInput, {
            autoPlaceholder: "off",
            separateDialCode: true,
            initialCountry: isoCode
            // utilsScript: '{{URL::asset("frontend/build/js/utils.js")}}',
        });


        $("#phone_code").val(phoneInstance.getSelectedCountryData().dialCode);
        $("#iso_code").val(phoneInstance.getSelectedCountryData().iso2);
        phoneInput.addEventListener("countrychange",function() {
            $("#phone_code").val(phoneInstance.getSelectedCountryData().dialCode);
            $("#iso_code").val(phoneInstance.getSelectedCountryData().iso2);
        });
        
    </script>
@endpush

@endsection