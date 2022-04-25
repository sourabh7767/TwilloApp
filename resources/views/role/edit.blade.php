@extends('layouts.admin')

@section('title') Edit Role @endsection

@section('content')

  <!-- Basic Horizontal form layout section start -->
                <section id="basic-horizontal-layouts">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('user.home')}}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('role.index')}}">Role</a>
                                    </li>
                                    <li class="breadcrumb-item active">Edit Role
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Edit Role</h4>
                                </div>
                                <div class="card-body">
                                  <form method="POST" action="{{ route('role.update', $model->id) }}">
                                    @csrf
                                    @method('put')
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-2">
                                                        <label class="col-form-label" for="title">Title <span class="text-danger asteric-sign">&#42;</span></label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                    <input id="title" type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title')?old('title'):$model->title }}">
                                                    @if ($errors->has('title'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('title') }}</strong>
                                                        </span>
                                                    @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-2">
                                                        <label class="col-form-label" for="title">Permissions <span class="text-danger asteric-sign">&#42;</span></label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                         @foreach($permissions as $key =>$value)
                                                         <input type="checkbox" name="permission[]" class="form-check-input {{ $errors->has('permission') ? ' is-invalid' : '' }}" value="{{$value->id}}" {{in_array($value->id,$rolePermissions)?"checked":""}}>&nbsp;&nbsp;&nbsp;{{$value->title}}</br>
                                                        @endforeach
                                                        @if ($errors->has('permission'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('permission') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                          
                                           
                                        
                                            <div class="col-sm-9 offset-sm-3">
                                                <button type="submit" class="btn btn-primary me-1">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Basic Horizontal form layout section end -->




@endsection