<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN: Head-->
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
        <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="Devendra Rajput">
        <title> @yield('title') </title>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="apple-touch-icon" href="{{ asset('images/theme/ico/apple-icon-120.png') }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/theme/ico/favicon.ico') }}">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('fontawesome/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('fontawesome/css/fontawesome.css') }}">
        <link rel="stylesheet" href="{{ asset('fontawesome/css/regular.css') }}">
        <link rel="stylesheet" href="{{ asset('fontawesome/css/solid.css') }}">
        <script href="{{ asset('fontawesome/js/all.min.js') }}"></script>
        <!-- <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css"> -->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->

        <!-- BEGIN: Vendor CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/vendors.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/charts/apexcharts.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/extensions/toastr.min.css') }}">
        <!-- END: Vendor CSS-->

        <!-- BEGIN: Theme CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/bootstrap-extended.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/colors.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/components.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/themes/dark-layout.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/themes/bordered-layout.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/themes/semi-dark-layout.css') }}">
        <!-- END: Theme CSS-->

        <!-- BEGIN: Page CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/core/menu/menu-types/vertical-menu.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/plugins/charts/chart-apex.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/plugins/extensions/ext-component-toastr.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/pages/app-invoice-list.css') }}">
        @stack('page_style')
        <!-- END: Page CSS-->

        <!-- BEGIN: Custom CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert2.min.css') }}">
        <!-- END: Custom CSS-->

    </head>
    <!-- END: Head-->

    <body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

        @include('layouts.partials.navbar')

        @include('layouts.partials.sidebar')

        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <!-- @include("include.flashMessage") -->
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- END: Content-->

        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>

        @include('layouts.partials.footer')

        <!-- BEGIN: Vendor JS-->
        <script src="{{ asset('js/theme//vendors.min.js') }}"></script>
        <!-- BEGIN Vendor JS-->

        <!-- BEGIN: Page Vendor JS-->
        <script src="{{ asset('js/theme/charts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('js/theme/extensions/toastr.min.js') }}"></script>
        <!-- END: Page Vendor JS-->

        <!-- BEGIN: Theme JS-->
        <script src="{{ asset('js/theme/core/app-menu.js') }}"></script>
        <script src="{{ asset('js/theme/core/app.js') }}"></script>
        <!-- END: Theme JS-->

        <script src="{{ asset('js/custom.js') }}"></script>
        <script>
            let toastCofig = {
                closeButton: true,
                tapToDismiss: false
            }

            @if(session('success'))
                toastr.success("{{ session('success') }}", 'Success!', toastCofig);
            @endif
            @if(session('error'))
                toastr.error("{{ session('error') }}", 'Error!',  toastCofig);
            @endif
            @if(session('warning'))
                toastr.warning("{{ session('warning') }}", 'Warning!', toastCofig);
            @endif
            @if(session('info'))
                toastr.info("{{ session('info') }}", 'Informaton!', toastCofig);
            @endif
            @if($errors->any())
                toastr.error("Please check the form below for errors", 'Error!', toastCofig);
            @endif
        </script>
        
        <script src="{{ asset('js/sweetalert.min.js') }}"></script>


        <!-- BEGIN: Page JS-->
        @stack('page_script')
        <!-- END: Page JS-->

    </body>
</html>
