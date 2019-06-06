<?php
include_once('../widgets/header.php') ;
// lấy dữ liệu cho trang hiện tại


//
//$query = "SELECT * FROM giao_vien WHERE trang_thai=1";
//if (isset($_GET['donvi']) && $_GET['donvi'] != 'all') {
//    $para_donvi = $_GET['donvi'];
//    $query .= "&& don_vi_id=".$para_donvi;
//}
//$query .= " ORDER BY ngay_tao DESC";
//$stmt = $con->prepare($query);
//$stmt->execute();


// Lấy năm kết thúc
if (isset($_GET['yearend'])) {
    $yearend = (int)$_GET['yearend'];
}
else{
    $yearend = (int)date('Y', time());
}

// Lấy năm bắt đầu
if (isset($_GET['yearstart'])) {
    $yearstart = (int)$_GET['yearstart'];
}
else {
    $yearstart = (int)$yearend - 5;
}

$nghien_cuu_dung_han = getNghienCuuDungHan(strtotime('00:00 01-01-'.$yearstart), strtotime('23:59 31-12-'.$yearend), $con);

$allGiaoVien = [];
$giaoVienDonVi = [];

$allNghienCuu = [];
$nghienCuuDungHan = [];

for ($i = $yearstart; $i <= $yearend; $i++) {
    $timeStart = strtotime('00:00 01-01-'.$i);
    $timeEnd = strtotime('23:59 31-12-'.$i);
    $allNghienCuu[(string)$i." "] = countNghienCuuByTime($timeStart, $timeEnd, $con);
    $nghienCuuDungHan[(string)$i." "] = countNghienCuuDungHanByTime($timeStart, $timeEnd, $con);
    $nghien_cuu_ids = getListNghienCuuIdByTime($timeStart, $timeEnd, $con);
    $giao_vien_ids = getGiaoVienIdByNghienCuu($nghien_cuu_ids, $con);
    $giaoVienDonVi[$i] = countGiaoVienByGiaoVienId($giao_vien_ids, $con);

    $count_giao_vien = countGiaoVienByNghienCuu($nghien_cuu_ids, $con);
    $allGiaoVien[(string)$i." "] = $count_giao_vien;
}

function getListNghienCuuIdByTime($timeStart, $timeEnd, $con) {

    $queryNghienCuu = "SELECT id FROM nghien_cuu WHERE trang_thai = 1";
    $queryNghienCuu .= "&& thoi_gian_nghiem_thu >= ".$timeStart;
    $queryNghienCuu .= "&& thoi_gian_nghiem_thu <= ".$timeEnd;
    $queryNghienCuu .= " ORDER BY ngay_tao DESC";
    $stmtNghienCuu = $con->prepare($queryNghienCuu);
    $stmtNghienCuu->execute();
    $nghien_cuu_ids = $stmtNghienCuu->fetchAll(PDO::FETCH_ASSOC);
    $nghien_cuu_ids = array_column($nghien_cuu_ids, 'id');

    return $nghien_cuu_ids;
}

function getGiaoVienIdByNghienCuu($nghien_cuu_ids, $con){
    $nghien_cuu_ids = implode('", "',$nghien_cuu_ids) ;
    $queryNghienCuuGiaoVien = "SELECT giao_vien_id FROM giao_vien_nghien_cuu WHERE nghien_cuu_id IN (\"";
    $queryNghienCuuGiaoVien .= $nghien_cuu_ids."\")";
    $stmtNghienCuuGiaoVien = $con->prepare($queryNghienCuuGiaoVien);
    $stmtNghienCuuGiaoVien->execute();
    $giao_vien_ids = $stmtNghienCuuGiaoVien->fetchAll(PDO::FETCH_ASSOC);
    return array_column($giao_vien_ids, 'giao_vien_id');
}

function countGiaoVienByNghienCuu($nghien_cuu_ids, $con){
    $nghien_cuu_ids = implode('", "',$nghien_cuu_ids) ;
    $queryNghienCuuGiaoVien = "SELECT * FROM giao_vien_nghien_cuu WHERE nghien_cuu_id IN (\"";
    $queryNghienCuuGiaoVien .= $nghien_cuu_ids."\")";
    $stmtNghienCuuGiaoVien = $con->prepare($queryNghienCuuGiaoVien);
    $stmtNghienCuuGiaoVien->execute();
    $giao_vien_ids = [];
    while ($rowGiaoVien = $stmtNghienCuuGiaoVien->fetch(PDO::FETCH_ASSOC)){
        $giao_vien_ids[$rowGiaoVien['id']] = $rowGiaoVien['giao_vien_id'];
    }
    return count($giao_vien_ids);
}

function countGiaoVienByGiaoVienId($giao_vien_ids, $con) {
    $giao_vien_ids = implode('", "',$giao_vien_ids) ;
    $queryGiaoVien = "SELECT * FROM giao_vien WHERE trang_thai=1";
    $queryGiaoVien .= " && id IN (\"";
    $queryGiaoVien .= $giao_vien_ids."\")";
    if (isset($_GET['donvi']) && $_GET['donvi'] != 'all') {
        $para_donvi = $_GET['donvi'];
        $queryGiaoVien .= " && don_vi_id=".$para_donvi;
    }
    $queryGiaoVien .= " ORDER BY ngay_tao DESC";
    $stmtGiaoVien = $con->prepare($queryGiaoVien);
    $stmtGiaoVien->execute();

    $giao_viens= $stmtGiaoVien->fetchAll(PDO::FETCH_ASSOC);
    return count($giao_viens);
}

function countNghienCuuDungHanByTime($timeStart, $timeEnd, $con) {

    $queryNghienCuu = "SELECT id FROM nghien_cuu WHERE trang_thai = 1";
    $queryNghienCuu .= "&& thoi_gian_nghiem_thu >= ".$timeStart;
    $queryNghienCuu .= "&& thoi_gian_nghiem_thu <= ".$timeEnd;
    $queryNghienCuu .= "&& thoi_gian_nghiem_thu >= thoi_gian_ket_thuc";
    $stmtNghienCuu = $con->prepare($queryNghienCuu);
    $stmtNghienCuu->execute();
    $nghien_cuu_ids = $stmtNghienCuu->fetchAll(PDO::FETCH_ASSOC);
    return count($nghien_cuu_ids);
}

function countNghienCuuByTime($timeStart, $timeEnd, $con) {

    $queryNghienCuu = "SELECT id FROM nghien_cuu WHERE trang_thai = 1";
    $queryNghienCuu .= "&& thoi_gian_nghiem_thu >= ".$timeStart;
    $queryNghienCuu .= "&& thoi_gian_nghiem_thu <= ".$timeEnd;
    $stmtNghienCuu = $con->prepare($queryNghienCuu);
    $stmtNghienCuu->execute();
    $nghien_cuu_ids = $stmtNghienCuu->fetchAll(PDO::FETCH_ASSOC);
    return count($nghien_cuu_ids);
}


function getNghienCuuDungHan($timeStart, $timeEnd, $con){
    $queryNghienCuu = "SELECT * FROM nghien_cuu WHERE trang_thai = 1";
    $queryNghienCuu .= "&& thoi_gian_nghiem_thu >= ".$timeStart;
    $queryNghienCuu .= "&& thoi_gian_nghiem_thu <= ".$timeEnd;
    $queryNghienCuu .= "&& thoi_gian_nghiem_thu >= thoi_gian_ket_thuc";
    $stmtNghienCuu = $con->prepare($queryNghienCuu);
    $stmtNghienCuu->execute();
    $nghien_cuu_dung_han = $stmtNghienCuu->fetchAll(PDO::FETCH_ASSOC);
    return $nghien_cuu_dung_han;
}


//    $queryNghienCuu = "SELECT id FROM nghien_cuu WHERE trang_thai = 1";
//    if (isset($_GET['year'])) {
//        $year = $_GET['year'];
//        $startYear = strtotime('00:00 01-01-'.$year);
//        $endYear = strtotime('23:59 31-12-'.$year);
//        $queryNghienCuu .= "&& thoi_gian_nghiem_thu >= ".$startYear;
//        $queryNghienCuu .= "&& thoi_gian_nghiem_thu <= ".$endYear;
//    }
//    $queryNghienCuu .= " ORDER BY ngay_tao DESC";
//    $stmtNghienCuu = $con->prepare($queryNghienCuu);
//    $stmtNghienCuu->execute();
//    $nghien_cuu_ids = [];
//    $nghien_cuu_ids = $stmtNghienCuu->fetchAll(PDO::FETCH_ASSOC);
//
//    $nghien_cuu_ids = array_column($nghien_cuu_ids, 'id');
//    $nghien_cuu_ids = implode('", "',$nghien_cuu_ids) ;


//    $queryNghienCuuGiaoVien = "SELECT giao_vien_id FROM giao_vien_nghien_cuu WHERE nghien_cuu_id IN (\"";
//    $queryNghienCuuGiaoVien .= $nghien_cuu_ids."\")";
//    $stmtNghienCuuGiaoVien = $con->prepare($queryNghienCuuGiaoVien);
//    $stmtNghienCuuGiaoVien->execute();
//    $giao_vien_ids = $stmtNghienCuuGiaoVien->fetchAll(PDO::FETCH_ASSOC);
//
//    $giao_vien_ids = array_column($giao_vien_ids, 'giao_vien_id');
//    $giao_vien_ids = implode('", "',$giao_vien_ids) ;
//
//    $queryGiaoVien = "SELECT * FROM giao_vien WHERE trang_thai=1";
//    $queryGiaoVien .= " && id IN (\"";
//    $queryGiaoVien .= $giao_vien_ids."\")";
//    if (isset($_GET['donvi'])) {
//        $para_donvi = $_GET['donvi'];
//        $queryGiaoVien .= " && don_vi_id=".$para_donvi;
//    }
//    $queryGiaoVien .= " ORDER BY ngay_tao DESC";
//    $stmtGiaoVien = $con->prepare($queryGiaoVien);
//    $stmtGiaoVien->execute();
//
//    $giao_viens= $stmtGiaoVien->fetchAll(PDO::FETCH_ASSOC);
//    dd($giao_viens);

// Lấy map chức danh
//$queryChucDanh = "SELECT * FROM chuc_danh ";
//$stmtChucDanh = $con->prepare($queryChucDanh);
//$stmtChucDanh->execute();
//$chucdanh = [];
//$chucdanh_thoigian = [];
//while ($rowChucDanh = $stmtChucDanh->fetch(PDO::FETCH_ASSOC)){
//    $chucdanh[$rowChucDanh['id']] = $rowChucDanh['ten'];
//    $chucdanh_thoigian[$rowChucDanh['id']] = $rowChucDanh['thoi_gian_dinh_muc'];
//}

// Lấy map đơn vị
$queryDonVi = "SELECT * FROM don_vi_cong_tac ";
$stmtDonVi = $con->prepare($queryDonVi);
$stmtDonVi->execute();
$donvi = [];
while ($rowDonVi = $stmtDonVi->fetch(PDO::FETCH_ASSOC)){
    $donvi[$rowDonVi['id']] = $rowDonVi['ten'];
}


// Lấy map danh mục
$queryDanhMuc = "SELECT * FROM danh_muc_nghien_cuu ";
$stmtDanhMuc = $con->prepare($queryDanhMuc);
$stmtDanhMuc->execute();
$chucdanh = [];
while ($rowDanhMuc = $stmtDanhMuc->fetch(PDO::FETCH_ASSOC)){
    $danhMuc[$rowDanhMuc['id']] = $rowDanhMuc['ten'];
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thống kê
            <small>giáo viên</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="../../index.html"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="#">Thống kê</a></li>
            <li class="active">Danh sách</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!-- AREA CHART -->
                <div class="box box-danger">
                    <div class="box-header">
                        <div class=" with-border d-flex justify-content-between align-items-center">
                            <h3 class="box-title align-items-center">Số giáo viên nghiên cứu theo năm</h3>

                            <form action="" class="d-flex">
                                <div class="input-group date margin-r-5">
                                    <div class="input-group-addon">
                                        <i class="fas fa-list"></i>
                                        Đơn vị
                                    </div>
                                    <select name="donvi" class="form-control">
                                        <option value="all">Tất cả</option>
                                        <?php

                                        foreach ($donvi as $index => $item) {
                                            $selected = isset($_GET['donvi']) && $_GET['donvi'] == $index ? "selected" : "";
                                            echo '<option value="'.$index.'" '.$selected.'>'.$item.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="margin-r-5 d-flex">
                                    <div class="input-group-addon d-flex align-items-center flex-1 ">
                                        <i class="fas fa-calendar"></i>
                                        Năm
                                    </div>
                                    <input type="text" name="yearstart" class=" yearpicker" autocomplete="off" value="<?php echo $yearstart?>">
                                    <input type="text" name="yearend" class=" yearpicker" autocomplete="off" value="<?php echo $yearend?>">
                                </div>
                                <div class="">
                                    <button class="btn btn-primary">Thống kê</button>
                                </div>

                            </form>
                        </div>
                        <div class="box-body">
                        </div>

                        <div class="chart">
                            <canvas id="areaChart" style="height:250px"></canvas>
                            <div class="d-flex" style="justify-content: flex-end">
                                <div style="background-color: rgba(210, 214, 222, 1); width: 20px; height: 20px;" class="margin-r-5"></div>
                                <div class="margin-r-5">Tổng giáo viên</div>
                                <div style="background-color: rgba(60,141,188,0.9); width: 20px; height: 20px;" class="margin-r-5"></div>
                                <div >Giáo viên của đơn vị</div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Nghiên cứu nghiệm thu đúng hạn</h3>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="lineChart" style="height:250px"></canvas>
                            <div class="d-flex" style="justify-content: flex-end">
                                <div style="background-color: rgba(210, 214, 222, 1); width: 20px; height: 20px;" class="margin-r-5"></div>
                                <div class="margin-r-5">Tất cả nghiên cứu</div>
                                <div style="background-color: rgba(60,141,188,0.9); width: 20px; height: 20px;" class="margin-r-5"></div>
                                <div >Nghiên cứu nghiệm thu đúng hạn</div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách nghiên cứu đúng hạn</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php if ($num > 0) { ?>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Tên</th>
                                    <th>Bắt đầu</th>
                                    <th>Kết thúc</th>
                                    <th>Danh mục</th>
                                    <th>Tùy chọn</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($nghien_cuu_dung_han as $item) {
                                    ?>
                                    <tr>
                                        <td><?php echo $item['ten']?></td>
                                        <td><?php echo date('d/m/Y', $item['thoi_gian_bat_dau'])?></td>
                                        <td><?php echo date('d/m/Y', $item['thoi_gian_ket_thuc'])?></td>
                                        <td><?php echo $danhMuc[$item["danh_muc_id"]] ?></td>
                                        <td>
                                            <a href="../nghien_cuu/xem.php<?php echo '?id='.$item['id'] ?>" class="btn btn-success">Xem</a>
<!--                                            <a href="sua.php--><?php //echo '?id='.$item['id'] ?><!--" class="btn btn-primary">Sửa</a>-->
<!--                                            <a href="xoa.php--><?php //echo '?id='.$item['id'] ?><!--" class="btn btn-danger" onclick="return confirm('Bạn chắc chắn muốn XÓA')">Xóa</a>-->
                                        </td>
                                    </tr>
                                    <?php }?>
                            </table>
                            <?php
                        } else {
                            echo "<div class='alert alert-danger'>Không tìm thấy nghiên cứu nào.</div>";
                        }
                        ?>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>


<?php include_once('../widgets/footer.php') ?>
<script>
    $(function () {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        //--------------
        //- AREA CHART -
        //--------------

        // Get context with jQuery - using jQuery's .get() method.
        var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
        // This will get the first returned node in the jQuery collection.
        var areaChart       = new Chart(areaChartCanvas)
        var year = <?php echo json_encode(array_keys($allGiaoVien))?>;
        var areaChartData = {
            labels  : year,
            datasets: [
                {
                    fillColor           : 'rgba(210, 214, 222, 1)',
                    strokeColor         : 'rgba(210, 214, 222, 1)',
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : <?php echo json_encode(($allGiaoVien))?>
                },
                {
                    fillColor           : 'rgba(60,141,188,0.9)',
                    strokeColor         : 'rgba(60,141,188,0.8)',
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : <?php echo json_encode($giaoVienDonVi)?>
                }
            ]
        }

        var areaChartOptions = {
            //Boolean - If we should show the scale at all
            showScale               : true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines      : false,
            //String - Colour of the grid lines
            scaleGridLineColor      : 'rgba(0,0,0,.05)',
            //Number - Width of the grid lines
            scaleGridLineWidth      : 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines  : true,
            //Boolean - Whether the line is curved between points
            bezierCurve             : true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension      : 0.3,
            //Boolean - Whether to show a dot for each point
            pointDot                : false,
            //Number - Radius of each point dot in pixels
            pointDotRadius          : 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth     : 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius : 20,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke           : true,
            //Number - Pixel width of dataset stroke
            datasetStrokeWidth      : 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill             : true,
            //String - A legend template
            legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio     : true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive              : true
        }


        var lineChartData = {
            labels  : year,
            datasets: [
                {
                    fillColor           : 'rgba(210, 214, 222, 1)',
                    strokeColor         : 'rgba(210, 214, 222, 1)',
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : <?php echo json_encode($allNghienCuu)?>
                },
                {
                    fillColor           : 'rgba(60,141,188,0.9)',
                    strokeColor         : 'rgba(60,141,188,0.8)',
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : <?php echo json_encode($nghienCuuDungHan)?>
                }
            ]
        }

        //Create the line chart
        areaChart.Line(areaChartData, areaChartOptions)

        //-------------
        //- LINE CHART -
        //--------------
        var lineChartCanvas          = $('#lineChart').get(0).getContext('2d')
        var lineChart                = new Chart(lineChartCanvas)
        var lineChartOptions         = areaChartOptions
        lineChartOptions.datasetFill = false
        lineChart.Line(lineChartData, lineChartOptions)
    })
</script>
