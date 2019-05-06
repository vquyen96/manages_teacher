<?php
    include_once('../widgets/header.php') ;
    // lấy dữ liệu cho trang hiện tại



    $query = "SELECT * FROM giao_vien WHERE trang_thai=1";
    if (isset($_GET['donvi'])) {
        $para_donvi = $_GET['donvi'];
        $query .= "&& don_vi_id=".$para_donvi;
    }
    $query .= " ORDER BY ngay_tao DESC";
    $stmt = $con->prepare($query);
    $stmt->execute();

    // số lượng bản ghi trả về
    $num = $stmt->rowCount();
    // liên kết gọi đến trang Tạo sản phẩm mới

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
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách
            <small>giáo viên</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="../../index.html"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="#">Giáo viên</a></li>
            <li class="active">Danh sách</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Tất cả giáo viên</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="GET">
                            <div class="d-flex">
                                <div class="form-group">
                                    <label>Thời gian bắt đầu</label>
                                    <input type="text" class="form-control datepicker" placeholder="Thời gian bắt đầu">
                                </div>
                                <div class="form-group">
                                    <label>Thời gian kết thúc</label>
                                    <input type="text" class="form-control datepicker" placeholder="Thời gian kết thúc">
                                </div>
                                <div class="form-group">
                                    <label>Đơn vị</label>
                                    <select name="donvi" class="form-control">
                                        <?php
                                            foreach ($donvi as $index => $item) {
                                                echo '<option value="'.$index.'">'.$item.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>_</label>
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
