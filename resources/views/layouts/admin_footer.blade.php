<!-- ============================================================== -->
<!-- End PAge Content -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- footer -->
<!-- ============================================================== -->
<footer class="footer">
    © 2017 Admin Pro by wrappixel.com
</footer>
<!-- ============================================================== -->
<!-- End footer -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
<script type="text/javascript"
        src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('/assets/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{ asset('js/perfect-scrollbar.jquery.min.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('/js/waves.js') }}"></script>
<!--Menu sidebar -->
<script src="{{ asset('/js/sidebarmenu.js') }}"></script>
<!--stickey kit -->
<script src="{{ asset('/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<!--Custom JavaScript -->
<script src="{{ asset('/js/custom.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/toastr/toastr.js') }}"></script>
<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script src="{{ asset('/assets/plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>
<script src="{{ asset('/js/jasny-bootstrap.js') }}"></script>

<!-- Sweet-Alert  -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@yield('script')
@include('sweetalert::alert')
</body>

</html>
