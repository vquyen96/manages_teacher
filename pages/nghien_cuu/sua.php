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

// KIểm tra không tồn tại bản ghi nào thì chuyển trang
if ($nghien_cuu == null) {
    echo '<script type="text/javascript">location.href = "danhsach.php";</script>';
}

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
$danh_muc_query = "SELECT * FROM danh_muc_nghien_cuu ORDER BY id DESC";
$danh_muc_stmt = $con->prepare($danh_muc_query);
$danh_muc_stmt->execute();

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
            Chỉnh sửa
            <small>Nghiên cứu</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="../dashboard/index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="danhsach.php">Nghiên cứu</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Chỉnh sửa Nghiên cứu</h3>
                    </div>
                    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post"  enctype="multipart/form-data">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Minh Chứng</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="minh_chung" class="form-control">
                                        </div>
                                    </div>
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
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tên</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="ten" class="form-control" placeholder="Tên" value="<?php echo $nghien_cuu['ten']?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Chi tiết</label>

                                            <div class="col-sm-10">
                                                <textarea name="chi_tiet" class="form-control" cols="30" rows="10"><?php echo $nghien_cuu['chi_tiet']?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Bắt đầu</label>

                                            <div class="col-sm-10">
                                                <input type="text" name="thoi_gian_bat_dau" autocomplete="off" class="form-control datepicker" placeholder="Thời gian bắt đầu" value="<?php echo date('d-m-Y', $nghien_cuu['thoi_gian_bat_dau'])?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Kêt thúc</label>

                                            <div class="col-sm-10">
                                                <input type="text" name="thoi_gian_ket_thuc" autocomplete="off" class="form-control datepicker" placeholder="Thời gian kết thúc" value="<?php echo date('d-m-Y', $nghien_cuu['thoi_gian_ket_thuc'])?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Nghiệm thu</label>

                                            <div class="col-sm-10">
                                                <input type="text" name="thoi_gian_nghiem_thu" autocomplete="off" class="form-control datepicker" placeholder="Thời gian Nghiệm thu" value="<?php echo date('d-m-Y', $nghien_cuu['thoi_gian_nghiem_thu'])?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" style="white-space: nowrap">Danh mục</label>

                                            <div class="col-sm-10">
                                                <select name="danh_muc_id" class="form-control" required>
                                                    <option value="" selected disabled>Chọn danh mục</option>
                                                    <?php
                                                    while ($danh_muc = $danh_muc_stmt->fetch(PDO::FETCH_ASSOC)) {
                                                        if ($nghien_cuu['danh_muc_id'] == $danh_muc['id'])
                                                            echo '<option value="'.$danh_muc['id'].'" selected>'.$danh_muc['ten'].'</option>';
                                                        else
                                                            echo '<option value="'.$danh_muc['id'].'">'.$danh_muc['ten'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <hr>
                                        <h3>Giáo viên</h3>

                                        <?php foreach ($giao_vien_nghien_cuu as $gvnc) { ?>
                                        <div class="mb-3 d-flex">
                                            <div class="form-control d-flex" style="align-items: center">
                                                <select class="form-control select2" name="giao_vien_id[]">
                                                    <option selected disabled>Chọn giáo viên</option>
                                                    <?php
                                                    foreach ($giao_vien_all as $item) {
                                                        if ($gvnc['giao_vien_id'] == $item['id'])
                                                            echo '<option value="'.$item['id'].'" selected>'.$item['ten'].'</option>';
                                                        else
                                                            echo '<option value="'.$item['id'].'">'.$item['ten'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <input type="text" name="giao_vien_thoi_gian[]" class=" form-control" placeholder="Thời gian nghiên cứu" value="<?php echo $gvnc['thoi_gian'] ?>">
                                            <input type="text" name="giao_vien_vai_tro[]" class=" form-control" placeholder="Vai trò" value="<?php echo $gvnc['vai_tro'] ?>">
                                            <input type="text" name="gvnc_id[]" class=" form-control d-none" value="<?php echo $gvnc['id'] ?>">
                                            <a href="xoagiaovien.php?id=<?php echo $gvnc['id'] ?>" class="btn btn-danger"  onclick="return confirm('Bạn chắc chắn muốn xóa giáo viên này')">Xoá</a>
                                        </div>
                                        <?php }?>
                                        <div class="mb-3 d-flex">
                                            <div class="form-control d-flex" style="align-items: center">
                                                <select class="form-control select2" name="giao_vien_id[]">
                                                    <option selected disabled>Chọn giáo viên</option>
                                                    <?php
                                                    foreach ($giao_vien_all as $item) {
                                                        echo '<option value="'.$item['id'].'">'.$item['ten'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <input type="text" name="giao_vien_thoi_gian[]" class=" form-control" placeholder="Thời gian nghiên cứu">
                                            <input type="text" name="giao_vien_vai_tro[]" class=" form-control" placeholder="Vai trò">
                                        </div>
                                        <button type="button" class="btn btn-sm btn-primary pull-right" id="btn-add-gvnc">
                                            <i class="fas fa-plus"></i>
                                            Thêm giáo viên
                                        </button>

                                        <hr>
                                        <h3>Sinh viên</h3>
                                        <?php foreach ($sinh_vien_nghien_cuu as $svnc) {?>
                                        <div class="mb-3 d-flex" >
                                            <div class="form-control d-flex" style="align-items: center">
                                                <select class="form-control select2" name="sinh_vien_id[]">
                                                    <option selected disabled>Chọn sinh viên</option>
                                                    <?php
                                                    foreach ($sinh_vien_all as $item) {
                                                        if ($svnc['sinh_vien_id'] == $item['id'])
                                                            echo '<option value="'.$item['id'].'" selected>'.$item['ten'].'</option>';
                                                        else
                                                            echo '<option value="'.$item['id'].'">'.$item['ten'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
<!--                                            <input type="text" name="sinh_vien_thoi_gian[]" class=" form-control" placeholder="Thời gian nghiên cứu"  value="--><?php //echo $svnc['thoi_gian'] ?><!--">-->
                                            <input type="text" name="sinh_vien_vai_tro[]" class=" form-control" placeholder="Vai trò" value="<?php echo $svnc['vai_tro'] ?>">
                                            <input type="text" name="svnc_id[]" class=" form-control d-none" value="<?php echo $svnc['id'] ?>">
                                            <a href="xoasinhvien.php?id=<?php echo $svnc['id'] ?>" class="btn btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa sinh viên này')">Xoá</a>
                                        </div>
                                        <?php }?>
                                        <div class="mb-3 d-flex" >
                                            <div class="form-control d-flex" style="align-items: center">
                                                <select class="form-control select2" name="sinh_vien_id[]">
                                                    <option selected disabled>Chọn sinh viên</option>
                                                    <?php
                                                    foreach ($sinh_vien_all as $item) {
                                                        echo '<option value="'.$item['id'].'">'.$item['ten'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
<!--                                            <input type="text" name="sinh_vien_thoi_gian[]" class=" form-control" placeholder="Thời gian nghiên cứu">-->
                                            <input type="text" name="sinh_vien_vai_tro[]" class=" form-control" placeholder="Vai trò">

                                        </div>
                                        <button type="button" class="btn btn-sm btn-primary pull-right" id="btn-add-svnc" >
                                            <i class="fas fa-plus"></i>
                                            Thêm sinh viên
                                        </button>
                                        <div class="">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="danhsach.php" class="btn btn-default">Quay lại</a>
                            <button type="submit" class="btn btn-info pull-right">Lưu</button>
                        </div>
                    </form>
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
if($_POST){
    try{
        // Transaction (dùng khi thêm dữ liệu vào nhiều bảng, khi thêm dữ liệu vào 1 bảng bị lỗi thì toàn bộ dữ kiệu sẽ không được thêm nữa)
        $con->beginTransaction();
        // truy vấn INSERT
        $query = "UPDATE ".$dir." SET 
            ten=:ten, 
            chi_tiet=:chi_tiet,
            thoi_gian_bat_dau=:thoi_gian_bat_dau,
            thoi_gian_ket_thuc=:thoi_gian_ket_thuc,
            thoi_gian_nghiem_thu=:thoi_gian_nghiem_thu,
            danh_muc_id=:danh_muc_id,
            trang_thai=:trang_thai,
            tong_thoi_gian=:tong_thoi_gian,
            minh_chung=:minh_chung,
            ngay_cap_nhat=:ngay_cap_nhat
            WHERE id=:id    
        " ;

        // Chuẩn bị cho thực thi truy vấn
        $stmt = $con->prepare($query);

        // Các giá trị được lấy từ các trường nhập trên form
        $ten = htmlspecialchars(strip_tags($_POST['ten']));
        $chi_tiet = htmlspecialchars(strip_tags($_POST['chi_tiet']));
        $thoi_gian_bat_dau = htmlspecialchars(strip_tags($_POST['thoi_gian_bat_dau']));
        $thoi_gian_bat_dau = strtotime($thoi_gian_bat_dau);
        $thoi_gian_ket_thuc = htmlspecialchars(strip_tags($_POST['thoi_gian_ket_thuc']));
        $thoi_gian_ket_thuc = strtotime($thoi_gian_ket_thuc);
        $thoi_gian_nghiem_thu = htmlspecialchars(strip_tags($_POST['thoi_gian_nghiem_thu']));
        $thoi_gian_nghiem_thu = strtotime($thoi_gian_nghiem_thu);

        $danh_muc_id = htmlspecialchars(strip_tags($_POST['danh_muc_id']));
        $trang_thai = 1;
        $ngay_cap_nhat = time();

        // Lưu file minh chung
        $minh_chung = saveImage($_FILES["minh_chung"], '../../uploads/minh-chung/');
        if ($minh_chung == false && $minh_chung != null){
            echo '<script type="text/javascript">location.href = "sua.php"</script>';
        }

        // truyền các tham số cho câu truy vấn
        $stmt->bindParam(':ten', $ten);
        $stmt->bindParam(':chi_tiet', $chi_tiet);
        $stmt->bindParam(':thoi_gian_bat_dau', $thoi_gian_bat_dau);
        $stmt->bindParam(':thoi_gian_ket_thuc', $thoi_gian_ket_thuc);
        $stmt->bindParam(':thoi_gian_nghiem_thu', $thoi_gian_nghiem_thu);
        $stmt->bindParam(':danh_muc_id', $danh_muc_id);
        $stmt->bindParam(':trang_thai', $trang_thai);
        $stmt->bindParam(':ngay_cap_nhat', $ngay_cap_nhat);
        if ($minh_chung) {
            $stmt->bindParam(':minh_chung', $minh_chung);
        }
        else{
            $stmt->bindParam(':minh_chung', $nghien_cuu['minh_chung']);
        }

        $stmt->bindParam(':id', $id);


        // Kiểm tra nếu có giáo viên thì thêm hoặc cập nhật
        if (isset($_POST['giao_vien_id'])) {
            $giao_vien_id = $_POST['giao_vien_id'];
            $giao_vien_thoi_gian = $_POST['giao_vien_thoi_gian'];
            $giao_vien_vai_tro = $_POST['giao_vien_vai_tro'];
            $gvnc_id = $_POST['gvnc_id'];
            // Cập nhật hoặc thêm mới tất cả giáo viên nghiên cứu
            for ($i = 0; $i < count($giao_vien_id); $i++) {
                cap_nhat_thoi_gian_gvnc($giao_vien_id[$i], $con);
                // Kiểm tra giáo viên nghiên cứu tồn tại chưa
                // tồn tại rồi thì cập nhật
                if (isset($gvnc_id[$i]) && $gvnc_id[$i] != null) {
                    $query_giao_vien_nghien_cuu = "UPDATE giao_vien_nghien_cuu SET
                        giao_vien_id=:giao_vien_id,
                        thoi_gian=:thoi_gian,
                        vai_tro=:vai_tro
                        WHERE id=:id
                    ";

                    $stmt_gvnc = $con->prepare($query_giao_vien_nghien_cuu);
                    $stmt_gvnc->bindParam(':giao_vien_id', $giao_vien_id[$i]);
                    $stmt_gvnc->bindParam(':thoi_gian', $giao_vien_thoi_gian[$i]);
                    $stmt_gvnc->bindParam(':vai_tro', $giao_vien_vai_tro[$i]);
                    $stmt_gvnc->bindParam(':id', $gvnc_id[$i]);
                    $stmt_gvnc->execute();
                } else { //sinh viên chưa tồn tại => thêm mới
//                    kiem_tra_gvnc_ton_tai($giao_vien_id[$i], $id, $con);
                    if (kiem_tra_gvnc_ton_tai($giao_vien_id[$i], $id, $con)) {
                        $query_giao_vien_nghien_cuu = "INSERT INTO giao_vien_nghien_cuu SET
                            giao_vien_id=:giao_vien_id,
                            nghien_cuu_id=:nghien_cuu_id,
                            thoi_gian=:thoi_gian,
                            vai_tro=:vai_tro
                        ";

                        $stmt_gvnc = $con->prepare($query_giao_vien_nghien_cuu);
                        $stmt_gvnc->bindParam(':giao_vien_id', $giao_vien_id[$i]);
                        $stmt_gvnc->bindParam(':nghien_cuu_id', $id);
                        $stmt_gvnc->bindParam(':thoi_gian', $giao_vien_thoi_gian[$i]);
                        $stmt_gvnc->bindParam(':vai_tro', $giao_vien_vai_tro[$i]);
                        $stmt_gvnc->execute();

                    } else {
                        echo '<script type="text/javascript">alert("Giáo viên thư '.($i+1).' bị trùng")</script>';
                    }

                }

            }
        }
        // Kiểm tra nếu có sinh viên thì thêm hoặc cập nhật
        if (isset($_POST['sinh_vien_id'])) {
            $sinh_vien_id = $_POST['sinh_vien_id'];
            $sinh_vien_thoi_gian = $_POST['sinh_vien_thoi_gian'];
            $sinh_vien_vai_tro = $_POST['sinh_vien_vai_tro'];
            $svnc_id = $_POST['svnc_id'];

            // Cập nhật hoặc thêm mới tất cả sinh viên nghiên cứu
            for ($i = 0; $i < count($sinh_vien_id); $i++) {
                cap_nhat_thoi_gian_svnc($sinh_vien_id[$i], $con);
                // Kiểm tra sinh viên nghiên cứu tồn tại chưa
                // tồn tại rồi thì cập nhật
                if (isset($svnc_id[$i]) && $svnc_id[$i] != null) {
                    $query_sinh_vien_nghien_cuu = "UPDATE sinh_vien_nghien_cuu SET
                        sinh_vien_id=:sinh_vien_id,
                        thoi_gian=:thoi_gian,
                        vai_tro=:vai_tro
                        WHERE id=:id
                    ";

                    $stmt_svnc = $con->prepare($query_sinh_vien_nghien_cuu);
                    $stmt_svnc->bindParam(':sinh_vien_id', $sinh_vien_id[$i]);
                    $stmt_svnc->bindParam(':thoi_gian', $sinh_vien_thoi_gian[$i]);
                    $stmt_svnc->bindParam(':vai_tro', $sinh_vien_vai_tro[$i]);
                    $stmt_svnc->bindParam(':id', $svnc_id[$i]);
                    $stmt_svnc->execute();
                } else { //sinh viên chưa tồn tại => thêm mới
                    if (kiem_tra_svnc_ton_tai($giao_vien_id[$i], $id, $con)) {
                        $query_sinh_vien_nghien_cuu = "INSERT INTO sinh_vien_nghien_cuu SET
                            sinh_vien_id=:sinh_vien_id,
                            nghien_cuu_id=:nghien_cuu_id,
                            thoi_gian=:thoi_gian,
                            vai_tro=:vai_tro
                        ";

                        $stmt_svnc = $con->prepare($query_sinh_vien_nghien_cuu);
                        $stmt_svnc->bindParam(':sinh_vien_id', $sinh_vien_id[$i]);
                        $stmt_svnc->bindParam(':nghien_cuu_id', $id);
                        $stmt_svnc->bindParam(':thoi_gian', $sinh_vien_thoi_gian[$i]);
                        $stmt_svnc->bindParam(':vai_tro', $sinh_vien_vai_tro[$i]);
                        $stmt_svnc->execute();
                    }
                    else{
                        echo '<script type="text/javascript">alert("Sinh viên thứ '.($i+1).' bị trùng")</script>';
                    }
                }
            }
        }


        //tính tổng thời gian nghiên cứu
        $thoi_gian_gvnc = ((int)tong_thoi_gian_gvnc($id, $con)['SUM(thoi_gian)']) ;
        $thoi_gian_svnc = ((int)tong_thoi_gian_svnc($id, $con)['SUM(thoi_gian)']) ;
        $tong_thoi_gian = $thoi_gian_gvnc + $thoi_gian_svnc;
        $stmt->bindParam(':tong_thoi_gian', $tong_thoi_gian);
        $stmt->execute();

        // Không có lỗi sảy ra trong quá trình thêm vào bảng thì tất cả sẽ được lưu lại
        $con->commit();
        echo '<script type="text/javascript">location.href = "xem.php?id='.$id.'";</script>';
    }// hiển thị lỗi
    catch(PDOException $exception){
        // Khi có lỗi sảy ra , tất cả dữ liệu sẽ không được thêm vào bảng
        $con->rollBack();
        session_set('error', $exception->getMessage());
        echo '<script type="text/javascript">location.href = "sua.php?id='.$id.'";</script>';
    }
}


?>

