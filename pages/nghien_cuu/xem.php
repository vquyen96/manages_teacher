<?php
include_once('../widgets/header.php');
$dir = basename(__DIR__) ;
//Lấy Id từ thanh địa chỉ
$id=isset($_GET['id']) ? $_GET['id'] : die('LỖI: Không tìm thấy ID.');

// Lấy nghiên cứu đang sửa
$query_nghien_cuu = "SELECT * FROM ".$dir." WHERE id = ? LIMIT 0,1";
$stmt_nghien_cuu = $con->prepare( $query_nghien_cuu );
$stmt_nghien_cuu->bindParam(1, $id);
$stmt_nghien_cuu->execute();
$nghien_cuu = $stmt_nghien_cuu->fetch(PDO::FETCH_ASSOC);

// Lấy danh sách giáo nghiên cứu
$query_giao_vien_nghien_cuu = "SELECT * FROM giao_vien_nghien_cuu WHERE nghien_cuu_id = ?";
$stmt_giao_vien_nghien_cuu = $con->prepare( $query_giao_vien_nghien_cuu );
$stmt_giao_vien_nghien_cuu->bindParam(1, $id);
$stmt_giao_vien_nghien_cuu->execute();
$giao_vien_nghien_cuu = $stmt_giao_vien_nghien_cuu->fetchAll(PDO::FETCH_ASSOC);

// Lấy danh sách sinh viên nghiên cứu
$query_sinh_vien_nghien_cuu = "SELECT * FROM sinh_vien_nghien_cuu WHERE nghien_cuu_id = ?";
$stmt_sinh_vien_nghien_cuu = $con->prepare( $query_sinh_vien_nghien_cuu );
$stmt_sinh_vien_nghien_cuu->bindParam(1, $id);
$stmt_sinh_vien_nghien_cuu->execute();
$sinh_vien_nghien_cuu = $stmt_sinh_vien_nghien_cuu->fetchAll(PDO::FETCH_ASSOC);

// Lấy danh sách danh mục
$danh_muc_query = "SELECT * FROM danh_muc_nghien_cuu WHERE id = ? LIMIT 0,1";
$danh_muc_stmt = $con->prepare($danh_muc_query);
$danh_muc_stmt->bindParam(1, $nghien_cuu['danh_muc_id']);
$danh_muc_stmt->execute();
$danh_muc = $danh_muc_stmt->fetch(PDO::FETCH_ASSOC);

// Lấy danh sách giáo viên
$query_giao_vien = "SELECT * FROM giao_vien ";
$stmt_giao_vien = $con->prepare($query_giao_vien);
$stmt_giao_vien->execute();
$giao_vien_all = $stmt_giao_vien->fetchAll(PDO::FETCH_ASSOC);


// Lấy danh sách sinh viên
$query_sinh_vien = "SELECT * FROM sinh_vien ";
$stmt_sinh_vien = $con->prepare($query_sinh_vien);
$stmt_sinh_vien->execute();
$sinh_vien_all = $stmt_sinh_vien->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chi tiết
            <small>Nghiên cứu</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="../dashboard/index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="danhsach.php">Nghiên cứu</a></li>
            <li class="active">Chi tiét</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Chi tiết Nghiên cứu</h3>
                    </div>
                        <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <?php
                                if ($nghien_cuu['minh_chung'] != null) {
                                    echo '<div class="thumbnail">';
                                    echo '<iframe src="../../uploads/minh-chung/'.$nghien_cuu['minh_chung'].'" class="" style="width: 100%; min-height: 500px;"></iframe>';
                                    echo '</div>';
                                }
                                else {
                                    echo '<div class="alert alert-warning">Không có file minh chứng</div>';
                                }
                                ?>
                            </div>
                            <div class="col-xs-6">
                                <div class="">
                                    <div class="mb-3 row">
                                        <label class="col-sm-2 control-label">Tên</label>
                                        <div class="col-sm-10">
                                            <?php echo $nghien_cuu['ten']?>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-2 control-label">Chi tiết</label>

                                        <div class="col-sm-10">
                                            <?php echo $nghien_cuu['chi_tiet']?>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-2 control-label">Bắt đầu</label>

                                        <div class="col-sm-10">
                                            <?php echo date('d/m/Y', $nghien_cuu['thoi_gian_bat_dau'])?>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-2 control-label">Kêt thúc</label>

                                        <div class="col-sm-10">
                                            <?php echo date('d/m/Y', $nghien_cuu['thoi_gian_ket_thuc']);?>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-2 control-label">Nghiệm thu</label>

                                        <div class="col-sm-10">
                                            <?php echo date('d/m/Y', $nghien_cuu['thoi_gian_nghiem_thu']);?>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-2 control-label">Tổng giờ</label>

                                        <div class="col-sm-10">
                                            <span class="label label-success"><?php echo $nghien_cuu['tong_thoi_gian'] .'/'.$danh_muc['thoi_gian_dinh_muc'];?></span>
                                             "Thực tế / định mức (giờ)"
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-2 control-label" style="white-space: nowrap">Danh mục</label>

                                        <div class="col-sm-10">
                                            <span class="label bg-green"><?php echo $danh_muc['ten']?></span>
                                        </div>
                                    </div>
                                    <hr>


                                    <table class="table table-hover table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Giáo viên</th>
                                                <th scope="col">Thời gian</th>
                                                <th scope="col">Vai trò</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($giao_vien_nghien_cuu as $gvnc) {
                                                echo '<tr>';
                                                foreach ($giao_vien_all as $item) {
                                                    if ($gvnc['giao_vien_id'] == $item['id']) {
                                                        echo '<td>'.$item['ten'].'</td>';
                                                        echo '<td>'.$gvnc['thoi_gian'].' (giờ)</td>';
                                                        echo '<td>'.$gvnc['vai_tro'].'</td>';
                                                    }
                                                }
                                                echo '</tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <hr>

                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Sinh viên</th>
<!--                                                <th scope="col">Thời gian</th>-->
                                                <th scope="col">Vai trò</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($sinh_vien_nghien_cuu as $svnc) {
                                                echo '<tr>';
                                                foreach ($sinh_vien_all as $item) {
                                                    if ($svnc['sinh_vien_id'] == $item['id']) {
                                                        echo '<td>'.$item['ten'].'</td>';
//                                                        echo '<td>'.$svnc['thoi_gian'].' (giờ)</td>';
                                                        echo '<td>'.$svnc['vai_tro'].'</td>';
                                                    }
                                                }
                                                echo '</tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="danhsach.php" class="btn btn-default">Quay lại</a>
                        <?php if ($auth['phan_quyen'] == 1) { ?>
                            <a href="sua.php?id=<?php echo $id ?>" class="btn btn-info pull-right">Chỉnh sửa</a>
                        <?php }?>

                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<?php
include_once('../widgets/footer.php');
?>

