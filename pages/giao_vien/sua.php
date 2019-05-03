<?php
include_once('../widgets/header.php');

// lấy giá trị của tham số ‘id’ trên URL
// isset() là hàm trong PHP cho phép kiểm tra giá trị là có hoặc không
$id=isset($_GET['id']) ? $_GET['id'] : die('LỖI: Không tìm thấy ID.');

// đọc dữ liệu của bản ghi hiện tại
try {
    // chuẩn bị câu truy vấn
    $query = "SELECT * FROM giao_vien WHERE id = ? LIMIT 0,1";
    $stmt = $con->prepare( $query );
    // truyền giá trị cho tham số ‘?’ trong câu truy vấn bên trên
    $stmt->bindParam(1, $id);
    // thực thi truy vấn
    $stmt->execute();
    // lưu dòng dữ liệu lấy được vào một biến $row
    $giao_vien = $stmt->fetch(PDO::FETCH_ASSOC);
    // điền lần lượt giá trị vào form thông qua các biến
}
// hiển thị lỗi
catch(PDOException $exception){
    die('LỖI: ' . $exception->getMessage());
}


// Lấy danh sách chức danh
$chuc_danh_query = "SELECT * FROM chuc_danh ORDER BY id DESC";
$chuc_danh_stmt = $con->prepare($chuc_danh_query);
$chuc_danh_stmt->execute();

// Lấy danh sách đơn vị công tác
$don_vi_query = "SELECT * FROM don_vi_cong_tac ORDER BY id DESC";
$don_vi_stmt = $con->prepare($don_vi_query);
$don_vi_stmt->execute();


?>
<?php

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chỉnh sửa
            <small>giáo viên</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="../dashboard/index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="danhsach.php">Giáo viên</a></li>
            <li class="active"><?php echo $giao_vien['ten']?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Chỉnh sửa giáo viên</h3>
                    </div>
                    <form class="form-horizontal"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
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
                                            <label for="inputEmail3" class="col-sm-2 control-label">Tên</label>

                                            <div class="col-sm-10">
                                                <input type="text" name="ten" class="form-control" placeholder="Tên" value="<?php echo $giao_vien['ten']?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

                                            <div class="col-sm-10">
                                                <input type="email" name="email" class="form-control" placeholder="Email"  value="<?php echo $giao_vien['email']?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label" style="white-space: nowrap">Chức danh</label>

                                            <div class="col-sm-10">
                                                <select name="chuc_vu_id"  class="form-control">
                                                    <option value="" selected disabled>Chọn chức danh</option>
                                                    <?php
                                                    while ($chuc_danh = $chuc_danh_stmt->fetch(PDO::FETCH_ASSOC)) {
                                                        if ($giao_vien['chuc_vu_id'] == $chuc_danh['id']) {
                                                            echo '<option value="'.$chuc_danh['id'].'" selected>'.$chuc_danh['ten'].'</option>';
                                                        }
                                                        else {
                                                            echo '<option value="'.$chuc_danh['id'].'">'.$chuc_danh['ten'].'</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label" style="white-space: nowrap">Đơn vị</label>
                                            <div class="col-sm-10">
                                                <select name="don_vi_id" id="" class="form-control">
                                                    <option value="" selected disabled>Chọn đơn vị công tác</option>
                                                    <?php
                                                    while ($don_vi = $don_vi_stmt->fetch(PDO::FETCH_ASSOC)) {
                                                        if ($giao_vien['don_vi_id'] == $don_vi['id']) {
                                                            echo '<option value="'.$don_vi['id'].'" selected>'.$don_vi['ten'].'</option>';
                                                        }
                                                        else {
                                                            echo '<option value="'.$don_vi['id'].'">'.$don_vi['ten'].'</option>';
                                                        }

                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label" style="white-space: nowrap">Giới tính</label>

                                            <div class="col-sm-10">
                                                <select name="gioi_tinh" class="form-control">
                                                    <option value="" selected disabled>Chọn giới tính</option>
                                                    <?php
                                                        foreach ($genders as $index => $gender) {
                                                            if ($giao_vien['gioi_tinh'] == $index) {
                                                                echo '<option value="'.$index.'" selected >'.$gender.'</option>';
                                                            } else {
                                                                echo '<option value="'.$index.'" >'.$gender.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="danhsach.php" class="btn btn-default">Cancel</a>
                            <!--                        <button type="submit" class="btn btn-default">Cancel</button>-->
                            <button type="submit" class="btn btn-info pull-right">Save</button>
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
        // truy vấn INSERT
        $query = "UPDATE giao_vien SET 
            ten=:ten, 
            email=:email, 
            don_vi_id=:don_vi_id, 
            chuc_vu_id=:chuc_vu_id, 
            gioi_tinh=:gioi_tinh,
            ngay_cap_nhat=:ngay_cap_nhat
            WHERE id=:id 
        ";

        // Chuẩn bị cho thực thi truy vấn
        $stmt = $con->prepare($query);

        // Các giá trị được lấy từ các trường nhập trên form
        $ten = htmlspecialchars(strip_tags($_POST['ten']));
        $email = htmlspecialchars(strip_tags($_POST['email']));
        $don_vi_id = htmlspecialchars(strip_tags($_POST['don_vi_id']));
        $chuc_vu_id = htmlspecialchars(strip_tags($_POST['chuc_vu_id']));
        $gioi_tinh = htmlspecialchars(strip_tags($_POST['gioi_tinh']));
        $ngay_cap_nhat = time();

        // truyền các tham số cho câu truy vấn
        $stmt->bindParam(':ten', $ten);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':don_vi_id', $don_vi_id);
        $stmt->bindParam(':chuc_vu_id', $chuc_vu_id);
        $stmt->bindParam(':gioi_tinh', $gioi_tinh);
        $stmt->bindParam(':ngay_cap_nhat', $ngay_cap_nhat);
        $stmt->bindParam(':id', $id);

        // Thực thi truy vấn
        if($stmt->execute()){
            echo '<script type="text/javascript">location.href = "danhsach.php";</script>';
            if (headers_sent()) {
                die("Chuyển trang bị lỗi. Hãy ấn vào <a href='don_vi.php'>Here</a>");
            }
            else{
                header('Location: danh_sach.php?create=success');
            }
        }else{
            header('Location: danh_sach.php?create=error');
        }
    }// hiển thị lỗi
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>

