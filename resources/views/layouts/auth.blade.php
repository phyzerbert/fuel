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
        <link rel="shortcut icon" href="{{asset('master/dist/img/favicon.png')}}">
        <!--Global Styles(used by all pages)-->
        <link href="{{asset('master/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('master/plugins/metisMenu/metisMenu.min.css')}}" rel="stylesheet">
        <link href="{{asset('master/plugins/fontawesome/css/all.min.css')}}" rel="stylesheet">
        <link href="{{asset('master/plugins/typicons/src/typicons.min.css')}}" rel="stylesheet">
        <link href="{{asset('master/plugins/themify-icons/themify-icons.min.css')}}" rel="stylesheet">
        <!--Third party Styles(used by this page)--> 

        <!--Start Your Custom Style Now-->
        <link href="{{asset('master/dist/css/style.css')}}" rel="stylesheet">
        <style>
            .main-background {
                background-image: url('{{asset("images/main-bg.jpg")}}');
                background-size: cover;
            }
            .panel {
                box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22) !important;
            }
        </style>
    </head>
    <body class="main-background">
        <div class="d-flex align-items-center justify-content-center text-center h-100vh">
            <div class="form-wrapper m-auto">
                <div class="form-container my-4">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- /.End of form wrapper -->
        <!--Global script(used by all pages)-->
        <script src="{{asset('master/plugins/jQuery/jquery-3.4.1.min.js')}}"></script>
        <script src="{{asset('master/dist/js/popper.min.js')}}"></script>
        <script src="{{asset('master/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('master/plugins/metisMenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('master/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
        <!-- Third Party Scripts(used by this page)-->

        <!--Page Active Scripts(used by this page)-->

        <!--Page Scripts(used by all page)-->
        <script src="{{asset('master/dist/js/sidebar.js')}}"></script>
    </body>
</html>