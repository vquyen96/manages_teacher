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
            Thêm mới
            <small>Nghiên cứu</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="../dashboard/index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="danhsach.php">Nghiên cứu</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Thêm mới Nghiên cứu</h3>
                    </div>
                    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="thumbnail">
                                        <img src="../../dist/img/photo3.jpg" alt="">
                                    </div>
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
                                                <input type="text" name="thoi_gian_bat_dau" class="form-control" placeholder="Thời gian bắt đầu" value="<?php echo $nghien_cuu['thoi_gian_bat_dau']?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Kêt thúc</label>

                                            <div class="col-sm-10">
                                                <input type="text" name="thoi_gian_ket_thuc" class="form-control" placeholder="Thời gian kết thúc" value="<?php echo $nghien_cuu['thoi_gian_ket_thuc']?>">
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
                                            <input type="text" name="sinh_vien_thoi_gian[]" class=" form-control" placeholder="Thời gian nghiên cứu"  value="<?php echo $svnc['thoi_gian'] ?>">
                                            <input type="text" name="sinh_vien_vai_tro[]" class=" form-control" placeholder="Vai trò" value="<?php echo $svnc['vai_tro'] ?>">
                                            <input type="text" name="svnc_id[]" class=" form-control d-none" value="<?php echo $svnc['id'] ?>">
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
                                            <input type="text" name="sinh_vien_thoi_gian[]" class=" form-control" placeholder="Thời gian nghiên cứu">
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
            danh_muc_id=:danh_muc_id,
            trang_thai=:trang_thai,
            ngay_cap_nhat=:ngay_cap_nhat
            WHERE id=:id    
        " ;

        // Chuẩn bị cho thực thi truy vấn
        $stmt = $con->prepare($query);

        // Các giá trị được lấy từ các trường nhập trên form
        $ten = htmlspecialchars(strip_tags($_POST['ten']));
        $chi_tiet = htmlspecialchars(strip_tags($_POST['chi_tiet']));
        $thoi_gian_bat_dau = (int)htmlspecialchars(strip_tags($_POST['thoi_gian_bat_dau']));
        $thoi_gian_ket_thuc = (int)htmlspecialchars(strip_tags($_POST['thoi_gian_ket_thuc']));
        $danh_muc_id = htmlspecialchars(strip_tags($_POST['danh_muc_id']));
        $trang_thai = 1;
        $ngay_cap_nhat = time();

        // truyền các tham số cho câu truy vấn
        $stmt->bindParam(':ten', $ten);
        $stmt->bindParam(':chi_tiet', $chi_tiet);
        $stmt->bindParam(':thoi_gian_bat_dau', $thoi_gian_bat_dau);
        $stmt->bindParam(':thoi_gian_ket_thuc', $thoi_gian_ket_thuc);
        $stmt->bindParam(':danh_muc_id', $danh_muc_id);
        $stmt->bindParam(':trang_thai', $trang_thai);
        $stmt->bindParam(':ngay_cap_nhat', $ngay_cap_nhat);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        if (isset($_POST['giao_vien_id'])) {
            $giao_vien_id = $_POST['giao_vien_id'];
            $giao_vien_thoi_gian = $_POST['giao_vien_thoi_gian'];
            $giao_vien_vai_tro = $_POST['giao_vien_vai_tro'];
            $gvnc_id = $_POST['gvnc_id'];
            // Cập nhật hoặc thêm mới tất cả giáo viên nghiên cứu
            for ($i = 0; $i < count($giao_vien_id); $i++) {
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

        if (isset($_POST['sinh_vien_id'])) {
            $sinh_vien_id = $_POST['sinh_vien_id'];
            $sinh_vien_thoi_gian = $_POST['sinh_vien_thoi_gian'];
            $sinh_vien_vai_tro = $_POST['sinh_vien_vai_tro'];
            $svnc_id = $_POST['svnc_id'];

            // Cập nhật hoặc thêm mới tất cả sinh viên nghiên cứu
            for ($i = 0; $i < count($sinh_vien_id); $i++) {
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
                        echo '<script type="text/javascript">alert("Sinh viên thư '.($i+1).' bị trùng")</script>';
                    }

                }

            }
        }

        // Không có lỗi sảy ra trong quá trình thêm vào bảng thì tất cả sẽ được lưu lại
        $con->commit();
        echo '<script type="text/javascript">location.href = "sua.php?id='.$id.'";</script>';
    }// hiển thị lỗi
    catch(PDOException $exception){
        // Khi có lỗi sảy ra , tất cả dữ liệu sẽ không được thêm vào bảng
        $con->rollBack();
        die('ERROR: ' . $exception->getMessage());
    }
}

function kiem_tra_gvnc_ton_tai($giao_vien_id, $nghien_cuu_id, $con){
    $query_gvnc = "SELECT * FROM giao_vien_nghien_cuu WHERE giao_vien_id=:giao_vien_id, nghien_cuu_id=:nghien_cuu_id";

    $stmt_gvnc = $con->prepare($query_gvnc);
    $stmt_gvnc->bindParam(':giao_vien_id', $giao_vien_id);
    $stmt_gvnc->bindParam(':nghien_cuu_id', $nghien_cuu_id);
    $stmt_gvnc->execute();
    $exist = $stmt_gvnc->fetchAll(PDO::FETCH_ASSOC);
    return count($exist) != 0;
}

function kiem_tra_svnc_ton_tai($sinh_vien_id, $nghien_cuu_id, $con){
    $query_svnc = "SELECT * FROM sinh_vien_nghien_cuu WHERE sinh_vien_id=:sinh_vien_id, nghien_cuu_id=:nghien_cuu_id";

    $stmt_svnc = $con->prepare($query_svnc);
    $stmt_svnc->bindParam(':sinh_vien_id', $sinh_vien_id);
    $stmt_svnc->bindParam(':nghien_cuu_id', $nghien_cuu_id);
    $stmt_svnc->execute();
    $exist = $stmt_svnc->fetchAll(PDO::FETCH_ASSOC);
    return count($exist) != 0;
}
?>

