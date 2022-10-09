<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{setting('site_title')}}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('backend/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('backend/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/plugins/toastr/toastr.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
    @stack('styles')

    <style>
        .custom-error .select2-selection {
            border: none;
        }
    </style>
    <livewire:styles/>
</head>
<body class="hold-transition sidebar-mini {{setting('sidebar_collapse') ? 'sidebar-collapse' : ''}}">
<div class="wrapper">

    <!-- Navbar -->
    @include('layouts.partials.navbar')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('layouts.partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{ $slot }}
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    @include('layouts.partials.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('backend/dist/js/adminlte.min.js')}}"></script>
@stack('alpine-plugins')
<!-- Để dùng các thẻ x-data, x-show, .... -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    window.addEventListener('show-form', event => {
        $('#form').modal('show');
    })

    window.addEventListener('show-delete-modal', event => {
        $('#confirmationModal').modal('show');
    })

    window.addEventListener('hide-delete-modal', event => {
        $('#confirmationModal').modal('show');
        toastr.success(event.detail.message, 'Success!');
    })

    window.addEventListener('alert', event => {
        $('#confirmationModal').modal('show');
        toastr.success(event.detail.message, 'Success!')
    })

    window.addEventListener('updated', event => {
        toastr.success(event.detail.message, 'Success!')
    })
</script>

<script>
    $('[x-ref="profileLink"]').on('click', function(){
        localStorage.setItem('_x_currentTab', '"profile"')
    })

    $('[x-ref="changePasswordLink"]').on('click', function(){
        localStorage.setItem('_x_currentTab', '"changePassword"')
    })
</script>

<script>
    $(document).ready(function () {
        toastr.options = {
            "positionClass": "toast-bottom-right",
            "progressBar": true,
        }

        window.addEventListener('hide-form', event => {
            $('#form').modal('hide');
            toastr.success(event.detail.message, 'Success!')
        })
    })
</script>
<script src="{{asset('backend/plugins/moment/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('backend/plugins/toastr/toastr.min.js')}}"></script>

<script type="text/javascript"
        src="{{asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="{{asset('backend/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
@stack('js')
<livewire:scripts/>
<script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
</body>
</html>
