@extends('layouts.admin')

@section('title') Edit Profile @endsection

@section('content')

@push('page_style')

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">

@endpush


   <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('user.home')}}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">Update Profile
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
              </div>


<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><b>Update Profile</b></h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/user/update-profile" enctype="multipart/form-data">
                    @csrf
                   
                <div class="card-body">
                  <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input name="full_name" type="text" value="{{old('full_name') ?? $model->full_name}}" class="form-control" id="full_name" placeholder="Enter Name">
                  </div>
                  
                  
                   <div class="col-md-6">
                            <label for="phone" class="col-form-label">Phone Number <span class="text-danger asteric-sign">&#42;</span></label><br>
                            <input type="hidden" name="phone_code" id="phone_code" value="{{ (old('phone_code')) ? (old('phone_code')) : ($model->phone_code) }}"/>
                            <input type="hidden" name="iso_code" id="iso_code" value="{{ (old('iso_code')) ? (old('iso_code')) : ($model->iso_code) }}"/>

                            <input id="phone_number" type="text" class="form-control {{ $errors->has('phone_number') || $errors->has('phone_code') || $errors->has('iso_code') ? ' is-invalid' : '' }}" name="phone_number" value="{{ (old('phone_number')) ? (old('phone_number')) : ($model->phone_number) }}">
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

                  <div class="col-md-6">
                   <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email" value="{{old('email') ?? $model->email}}" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter email">
                     @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                  </div>

                  <div class="form-group">
                    <label for="file">Profile</label>
                    <input type="file" name="file" class="form-control">
                  </div>
                  <br>

                  <div>
                  <button type="submit" class="btn btn-primary float-right">Submit</button>
                </div>
                    
                  </div>
                </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>


@push('page_script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    
   <script>

        var isoCode = ($("#iso_code").val()) ? ($("#iso_code").val()) : ('US');
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