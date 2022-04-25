@extends('layouts.admin')

@section('title') Change Password @endsection

@section('content')
  <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('user.home')}}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">Change Password
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
                <h5><b>Change Password</b></h5>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    @csrf
                     <div class="form-group">
                    <div class="row">
                    <div class="col-md-3">
                    <label for="old_password" class="float-right">Old Password</label>
                    </div>
                    <div class="col-md-6">
                    <input name="old_password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="old_password" placeholder="Old Password">
                      @if ($errors->has('old_password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('old_password') }}</strong>
                                </span>
                            @endif
                  </div>
                  </div>
                </div>
                <br>
                    <div class="form-group">
                    <div class="row">
                    <div class="col-md-3">
                    <label for="exampleInputPassword1" class="float-right">Password</label>
                    </div>
                    <div class="col-md-6">
                    <input name="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="exampleInputPassword1" placeholder="Password">
                      @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                  </div>
                  </div>
                </div>
                                <br>

                  <div class="form-group">
                    <div class="row">
                    <div class="col-md-3">
                    <label for="exampleInputPassword2" class="float-right">Confirm Password</label>
                  </div>
                    <div class="col-md-6">
                    <input name="confirm_password" type="password" class="form-control {{ $errors->has('confirm_password') ? ' is-invalid' : '' }}" id="exampleInputPassword2" placeholder="Confirm Password">
                      @if ($errors->has('confirm_password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('confirm_password') }}</strong>
                                </span>
                            @endif
                  </div>
                    </div>
                  </div>
                                  <br>

                                       <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-primary my-4">Submit</button>
                        </div>
                    </div>
                   

                   
                  

                    
                </form>
            </div>
        </div>
    </div>
</div>


@endsection