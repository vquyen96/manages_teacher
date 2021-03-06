<?php
    include_once('../widgets/header.php') ;
    // lấy dữ liệu cho trang hiện tại



    $query = "SELECT 
                gv.id, 
                gv.ten, 
                gv.don_vi_id, 
                gv.chuc_vu_id, 
                gv.tong_thoi_gian, 
                cd.thoi_gian_dinh_muc
            FROM 
                giao_vien gv
            JOIN 
                chuc_danh cd 
            ON gv.chuc_vu_id = cd.id 
            WHERE gv.trang_thai=1 ";
    if (isset($_GET['donvi']) && $_GET['donvi'] != 'all') {
        $para_donvi = $_GET['donvi'];
        $query .= "&& don_vi_id=".$para_donvi;
    }
    if (isset($_GET['thoigiannc']) && $_GET['thoigiannc'] != 'all') {
        $para_thoigiannc = $_GET['thoigiannc'];
        switch ($para_thoigiannc) {
            case 'du':
                $query .= "&& gv.tong_thoi_gian == cd.thoi_gian_dinh_muc";
                break;
            case 'thua':
                $query .= "&& gv.tong_thoi_gian > cd.thoi_gian_dinh_muc";
                break;
            case 'thieu':
                $query .= "&& gv.tong_thoi_gian < cd.thoi_gian_dinh_muc";
                break;
            default:
                break;
        }
    }

    $query .= " ORDER BY gv.ngay_tao DESC ";
    $stmt = $con->prepare($query);
    $stmt->execute();

    // Lấy map chức danh
    $queryChucDanh = "SELECT * FROM chuc_danh ";
    $stmtChucDanh = $con->prepare($queryChucDanh);
    $stmtChucDanh->execute();
    $chucdanh = [];
    $chucdanh_thoigian = [];
    while ($rowChucDanh = $stmtChucDanh->fetch(PDO::FETCH_ASSOC)){
        $chucdanh[$rowChucDanh['id']] = $rowChucDanh['ten'];
        $chucdanh_thoigian[$rowChucDanh['id']] = $rowChucDanh['thoi_gian_dinh_muc'];
    }

    // Lấy map đơn vị
    $queryDonVi = "SELECT * FROM don_vi_cong_tac ";
    $stmtDonVi = $con->prepare($queryDonVi);
    $stmtDonVi->execute();
    $donvi = [];
    while ($rowDonVi = $stmtDonVi->fetch(PDO::FETCH_ASSOC)){
        $donvi[$rowDonVi['id']] = $rowDonVi['ten'];
    }

    $list_thoigiannc = [
        "du" => "Đủ",
        "thua" => "Thừa",
        "thieu" => "Thiếu"
    ];
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
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Giời gian giáo viên nghiên cứu</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="GET">
                            <div class="d-flex">
                                <div class="form-group d-flex margin-r-5 align-items-center">
                                    <label class="ws-nowrap margin-r-5">Thời gian nghiên cứu</label>
                                    <select name="thoigiannc" class="form-control margin-r-5">
                                        <option value="all">Tất cả</option>
                                        <?php
                                        foreach ($list_thoigiannc as $index => $item) {
                                            if ($para_thoigiannc == $index) {
                                                echo '<option value="'.$index.'" selected>'.$item.'</option>';
                                            }
                                            else{
                                                echo '<option value="'.$index.'">'.$item.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group d-flex margin-r-5 align-items-center">
                                    <label class="ws-nowrap margin-r-5">Đơn vị</label>
                                    <select name="donvi" class="form-control">
                                        <option value="all">Tất cả</option>
                                        <?php
                                        foreach ($donvi as $index => $item) {
                                            if ($para_donvi == $index) {
                                                echo '<option value="'.$index.'" selected>'.$item.'</option>';
                                            }
                                            else{
                                                echo '<option value="'.$index.'">'.$item.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class=" form-control btn btn-primary">Thống kê</button>
                                </div>
                            </div>
                        </form>

                        <?php if ($num > 0) { ?>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Tên</th>
                                    <th>Chức danh</th>
                                    <th>Đơn vị</th>
                                    <th>Thời gian NC</th>
                                    <th>Tùy chọn</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                    // thay cho việc truy xuất dữ liệu bằng cách $row[‘name’], thì chỉ cần gọi $name
                                    // bằng cách sử dụng hàm extract($row)
                                    extract($row);
                                    ?>
                                    <tr>
                                        <td class=""><?php echo $ten?></td>
                                        <td><?php echo $chucdanh[$chuc_vu_id] ?></td>
                                        <td><?php echo $donvi[$don_vi_id] ?></td>
                                        <td>
                                            <?php
                                                $percent = $tong_thoi_gian/$chucdanh_thoigian[$chuc_vu_id];

                                                if ($percent>=1) {
                                                    echo '<span class="btn-sm bg-green">'.$tong_thoi_gian.'/'.$chucdanh_thoigian[$chuc_vu_id].'</span>';
                                                } else {
                                                    echo '<span class="btn-sm bg-orange">'.$tong_thoi_gian.'/'.$chucdanh_thoigian[$chuc_vu_id].'</span>';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="../giao_vien/xem.php<?php echo '?id='.$id ?>" class="btn btn-success">Xem</a>
                                        </td>
                                    </tr>
                                <?php }?>
                            </table>
                            <?php
                        } else {
                            echo "<div class='alert alert-danger'>Không tìm thấy giáo viên nào.</div>";
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
