<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Fuel Management System">
        <meta name="author" content="Bdtask">
        <title>Fuel Management System</title>
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/dist/img/favicon.png">
        <!--Global Styles(used by all pages)-->
        <link href="{{asset('master/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('master/plugins/metisMenu/metisMenu.min.css')}}" rel="stylesheet">
        <link href="{{asset('master/plugins/fontawesome/css/all.min.css')}}" rel="stylesheet">
        <link href="{{asset('master/plugins/typicons/src/typicons.min.css')}}" rel="stylesheet">
        <link href="{{asset('master/plugins/themify-icons/themify-icons.min.css')}}" rel="stylesheet">
        <!--Third party Styles(used by this page)--> 
        <link href="{{asset('master/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
        <!--Start Your Custom Style Now-->
        <link href="{{asset('master/dist/css/style.css')}}" rel="stylesheet">
    </head>
    <body class="fixed">
        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Please wait...</p>
            </div>
        </div>
        <!-- #END# Page Loader -->
        <div class="wrapper">            
            @include('layouts.aside')
            <div class="content-wrapper">
                <div class="main-content">
                    @include('layouts.header')
                    @yield('content')
                <div class="overlay"></div>
            </div>
        </div>
        <script src="{{asset('master/plugins/jQuery/jquery-3.4.1.min.js')}}"></script>
        <script src="{{asset('master/dist/js/popper.min.js')}}"></script>
        <script src="{{asset('master/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('master/plugins/metisMenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('master/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>

        <!--Page Scripts(used by all page)-->
        <script src="{{asset('master/dist/js/sidebar.js')}}"></script>

        @yield('script')

        <script>
            $('[data-toggle="tooltip"]').tooltip();
        </script>


    </body>
</html>