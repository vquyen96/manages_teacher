<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.4.0
    </div>
    <strong>Được làm bởi <a href="https://www.facebook.com/sieunhanxannnnn">Phương Thảo</a>.</strong>
</footer>

<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../../bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->

<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../../dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>

<?php
$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$folder =  $uriSegments[3];
$file = $uriSegments[4];
    switch ($folder) {
        case 'dashboard':
//          Morris.js charts
            echo '<script src="../../bower_components/raphael/raphael.min.js"></script>';
            echo '<script src="../../bower_components/morris.js/morris.min.js"></script>';
//          Sparkline
            echo '<script src="../../bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>';
//          jvectormap
            echo '<script src="../../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>';
            echo '<script src="../../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>';
//          jQuery Knob Chart
            echo '<script src="../../bower_components/jquery-knob/dist/jquery.knob.min.js"></script>';
//          daterangepicker
            echo '<script src="../../bower_components/moment/min/moment.min.js"></script>';
            echo '<script src="../../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>';
//          datepicker
            echo '<script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>';
//          Bootstrap WYSIHTML5
            echo '<script src="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>';
//          Slimscroll
            echo '<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>';
//          FastClick
            echo '<script src="../../bower_components/fastclick/lib/fastclick.js"></script>';

            echo '<script src="../../dist/js/pages/dashboard.js"></script>';
            break;
        case 'giao_vien':
            switch ($file) {
                case 'danhsach.php':
                    echo '<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>';
                    echo '<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>';
                    echo '<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>';
                    echo '<script src="../../bower_components/fastclick/lib/fastclick.js"></script>';
                    echo '<script src="../../dist/js/pages/giao_vien/index.js"></script>';
                    break;
            }
            break;
    }
?>
</body>
</html>