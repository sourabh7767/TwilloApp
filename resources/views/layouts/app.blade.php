<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') </title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!--     <link rel="icon" type="img/png" sizes="32x32" href="{{asset('images/favicon-32x32.png')}}">
 -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
         <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">

    @yield('third_party_stylesheets')

    @stack('page_css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Main Header -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav toggle-button">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

         <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <?php if(Auth::user()->profile_image){ ?>
                        <img src="{{Auth::user()->profile_image}}" class="user-image img-circle elevation-2" alt="User Image">
                    <?php } ?>
                        
                    <span class="d-none d-md-inline">{{ Auth::user()->full_name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- Menu Footer-->
                    <li class="user-footer bg-white">
                        <a href="/user/profile" class="btn btn-default btn-flat">Profile <i class="fas fa-user"></i></a>
                        <a href="/user/update-profile" class="btn btn-default btn-flat">Update Profile <i class="fas fa-pen"></i></a>
                    <a href="/user/change-password" class="btn btn-default btn-flat">Change Password <i class="fas fa-key"></i></a>
                  

                        <a href="#" class="btn btn-default btn-flat "
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Sign out <i class="fas fa-sign-out-alt"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Left side column. contains the logo and sidebar -->
@include('layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            @include('include.flash_message')   
            @yield('content')
        </section>
    </div>

    <!-- Main Footer -->
   <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            {{date("Y")}}&copy; Safe Exam
        </div>
<!--         <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
        reserved. -->
    </footer>
</div>

 <script src="{{ mix('js/app.js') }}" ></script>
 <script src="{{ asset('js/jquery.js') }}" ></script>
  <script src="{{ asset('js/sweetalert.min.js') }}" ></script>
    <script src="{{ asset('js/toastr.min.js') }}" ></script>
        <script src="{{ asset('js/select2.min.js') }}" ></script>
         <script src="{{ asset('js/custom.js?v=1.0') }}" ></script>

         <script type="text/javascript">
            $(".toggle-button").click(function(e){

                if($("body").hasClass("sidebar-collapse")){

               var logo = '<?=asset('images/logo.png') ?>';

                $(".custom-img img").attr("src",logo);

                $(".custom-img img").css('width', 'auto');


                }else{
                var logo = '<?=asset('images/logo.png') ?>';
                $(".custom-img img").attr("src",logo);
                  $(".custom-img img").css('width', '30px');

                }


});





             
         </script>









@yield('third_party_scripts')

@stack('page_script')
</body>
</html>
