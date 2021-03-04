<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Currency App - @yield('title')</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ url("assets/backend/plugins/fontawesome-free/css/all.min.css") }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url("assets/backend/dist/css/adminlte.min.css") }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ url('assets/backend/plugins/toastr/toastr.min.css') }}">
</head>

<body>
    <div class="container">
        <br>
    @yield('content')
    </div>
    
    <!-- /.content-wrapper -->
    <!-- Footer -->
    <footer class="page-footer font-small blue pt-4">
        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2020 Copyright:
            <a href="{{ route('backend.main') }}">Admin</a>
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer -->
            

    <!-- jQuery -->
    <script src="{{ url("assets/backend/plugins/jquery/jquery.min.js") }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url("assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url("assets/backend/dist/js/adminlte.js") }}"></script>
    
    <script src="{{ url('assets/backend/js/script.js?=' . uniqid()) }}"></script>
    <!-- Toastr -->
    <script src="{{ url('assets/backend/plugins/toastr/toastr.min.js') }}"></script>

    @if(session()->get('op') == 'fallback')
    <script type="text/javascript">
        Command: toastr["info"]("You have been redirected to the main page", "Error 404 - Route not found")
    </script>
    @endif
    
</body>

</html>