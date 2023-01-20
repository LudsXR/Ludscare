<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Consultant | Dashboard</title>
  <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/gif" sizes="16x16">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('new_admin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('new_admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('new_admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('new_admin/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('new_admin/dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('new_admin/dist/css/adminlte.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('new_admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('new_admin/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('new_admin/plugins/summernote/summernote-bs4.min.css')}}">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('new_admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('new_admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('new_admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <link
    rel="stylesheet"
    type="text/css"
    href="{{asset('/assets/libs/select2/dist/css/select2.min.css')}}"
    />
    <link rel="stylesheet" href="{{asset('/new_admin/plugins/bs-stepper/css/bs-stepper.min.css')}}">


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="" src="{{asset('assets/images/loader.gif')}}"  alt="AdminLTELogo" height="100" width="100">
  </div>

  <!-- Navbar -->
  @include('new_admin.sections.nav')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->

  @include('new_admin.sections.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper h-auto">

    @yield('content')

  </div>
  <!-- /.content-wrapper -->
  @include('new_admin.sections.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('new_admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('new_admin/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('new_admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('new_admin/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('new_admin/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
{{-- <script src="{{asset('new_admin/plugins/jqvmap/jquery.vmap.min.js')}}"></script> --}}
{{-- <script src="{{asset('new_admin/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script> --}}
<!-- jQuery Knob Chart -->
<script src="{{asset('new_admin/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('new_admin/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('new_admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('new_admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('new_admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('new_admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('new_admin/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{asset('new_admin/dist/js/demo.js')}}"></script> --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{asset('new_admin/dist/js/pages/dashboard.js')}}"></script> --}}


<!-- DataTables  & Plugins -->
<script src="{{asset('new_admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('new_admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('new_admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('new_admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('new_admin/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('new_admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('new_admin/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('new_admin/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('new_admin/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('new_admin/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('new_admin/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('new_admin/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('new_admin/plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>

<script src="{{asset('/assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{asset('/assets/libs/select2/dist/js/select2.min.js')}}"></script>
    <script src="//cdn.ckeditor.com/4.19.1/basic/ckeditor.js"></script>
<script>

/*** add active class and stay opened when selected ***/
var url = window.location;

// for sidebar menu entirely but not cover treeview
$('ul.nav-sidebar a').filter(function() {
    if (this.href) {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }
}).addClass('active');

// for the treeview
$('ul.nav-treeview a').filter(function() {
    if (this.href) {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }
}).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');


</script>
@include('new_admin.sections.notify')



@yield('footer_script')

</body>
</html>
