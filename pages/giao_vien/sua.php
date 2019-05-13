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
    $tai_khoan = null;
    if ($giao_vien['tai_khoan_id'] != null) {
        $tai_khoan_query = "SELECT * FROM tai_khoan WHERE id = ? LIMIT 0,1";
        $tai_khoan_stmt = $con->prepare( $tai_khoan_query );
        $tai_khoan_stmt->bindParam(1, $giao_vien['tai_khoan_id']);
        $tai_khoan_stmt->execute();
        $tai_khoan = $tai_khoan_stmt->fetch(PDO::FETCH_ASSOC);
    }
}
// hiển thị lỗi
catch(PDOException $exception){
    session_set('error', $exception->getMessage());
    echo '<script type="text/javascript">location.href = "danhsach.php";</script>';
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
                    <form class="form-horizontal"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post" enctype="multipart/form-data" id="form-giao-vien">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="btn-tai-khoan btn btn-primary text-center mb-3" style="width: 100%">
                                        <i class="fas fa-user"></i>
                                        Tài khoản
                                    </div>
                                    <div class="form-tai-khoan <?php if (!isset($tai_khoan) || $tai_khoan == null) echo 'slide-up';?>" >
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label ws-nowrap">Tên đăng nhập</label>

                                            <div class="col-sm-8">
                                                <input type="text" name="ten_dang_nhap" class="form-control" placeholder="Tên đăng nhập" value="<?php echo $tai_khoan['ten_dang_nhap']?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label ws-nowrap">Mật khẩu</label>
                                            <div class="col-sm-8">
                                                <input type="password" name="mat_khau" class="form-control" placeholder="Mật khẩu">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label ws-nowrap">Nhập lại mật khẩu</label>
                                            <div class="col-sm-8">
                                                <input type="password" name="re_mat_khau" class="form-control" placeholder="Nhập lại mật khẩu">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label ws-nowrap">Hình ảnh</label>
                                            <div class="col-sm-8">
                                                <div>
                                                    <input id="img" type="file" name="hinh_anh" class="hidden" onchange="changeImg(this)">
                                                    <img style="cursor: pointer; width: 100%;" class="img-file thumbnail" src="<?php if ($tai_khoan['hinh_anh'] != null && $tai_khoan['hinh_anh'] != "") echo '../../uploads/hinh-anh/'.$tai_khoan['hinh_anh']; else echo '../../dist/img/user2.jpg';  ?>">
                                                </div>

                                            </div>
                                        </div>
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
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label" style="white-space: nowrap">Cấp bậc</label>

                                            <div class="col-sm-10">
                                                <select name="cap_bac" class="form-control">
                                                    <option value="" selected disabled>Chọn cấp bậc</option>
                                                    <?php
                                                    foreach ($ranks as $index => $rank) {
                                                        if ($giao_vien['cap_bac'] == $index) {
                                                            echo '<option value="'.$index.'" selected >'.$rank.'</option>';
                                                        } else {
                                                            echo '<option value="'.$index.'" >'.$rank.'</option>';
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
        $con->beginTransaction();

        // Các giá trị được lấy từ các trường nhập trên form
        $ten_dang_nhap = htmlspecialchars(strip_tags($_POST['ten_dang_nhap']));
        $mat_khau = htmlspecialchars(strip_tags($_POST['mat_khau']));


        $ten = htmlspecialchars(strip_tags($_POST['ten']));
        $email = htmlspecialchars(strip_tags($_POST['email']));
        $don_vi_id = htmlspecialchars(strip_tags($_POST['don_vi_id']));
        $chuc_vu_id = htmlspecialchars(strip_tags($_POST['chuc_vu_id']));
        $gioi_tinh = htmlspecialchars(strip_tags($_POST['gioi_tinh']));
        $cap_bac = htmlspecialchars(strip_tags($_POST['cap_bac']));
        $ngay_cap_nhat = time();

        if ($ten_dang_nhap != null) {

            // Chưa có tài khoản => tạo tài khoản
            if ($tai_khoan == null) {
                if (isValidUsername($ten_dang_nhap, null, $con)) {
                    throw new PDOException("Tên đăng nhập đã tòn tại");
                }
                $query_tai_khoan = "INSERT INTO tai_khoan SET 
                    id=:id, 
                    ten_dang_nhap=:ten_dang_nhap, 
                    ho_ten=:ho_ten, 
                    hinh_anh=:hinh_anh, 
                    mat_khau=:mat_khau, 
                    muoi=:muoi, 
                    phan_quyen=:phan_quyen, 
                    trang_thai=:trang_thai, 
                    ngay_tao=:ngay_tao
                ";
                $stmt_tai_khoan = $con->prepare($query_tai_khoan);

                if ($mat_khau == null) {
                    throw new PDOException("Mật khẩu không được rỗng");
                }
                $id_tai_khoan = generateId(8, 'tai_khoan', $con);
                $muoi = generateRandomString(5);
                $mat_khau = md5($mat_khau.$muoi);

                //  Lấy trường “file” hình ảnh mới và lưu
                $hinh_anh = saveImage($_FILES["hinh_anh"], '../../uploads/hinh-anh/');
                if ($hinh_anh == false && $hinh_anh != null){
                    echo '<script type="text/javascript">location.href = "them.php"</script>';
                }

                $stmt_tai_khoan->bindParam(':id', $id_tai_khoan);
                $stmt_tai_khoan->bindParam(':ten_dang_nhap', $ten_dang_nhap);
                $stmt_tai_khoan->bindParam(':ho_ten', $ten);
                $stmt_tai_khoan->bindParam(':hinh_anh', $hinh_anh);
                $stmt_tai_khoan->bindParam(':mat_khau', $mat_khau);
                $stmt_tai_khoan->bindParam(':muoi', $muoi);
                $stmt_tai_khoan->bindParam(':phan_quyen', $phan_quyen);
                $stmt_tai_khoan->bindParam(':trang_thai', $trang_thai);
                $stmt_tai_khoan->bindParam(':ngay_tao', $ngay_tao);
                $tai_khoan['id'] = $id_tai_khoan;

                if (!$stmt_tai_khoan->execute()) throw new PDOException("Thêm tài khoản bị lỗi");
            }
            // Đã có tài khoản => cập nhật tài khoản
            else {
                if (isValidUsername($ten_dang_nhap,  $tai_khoan['id'], $con)) {
                    throw new PDOException("Tên đăng nhập đã tòn tại");
                }
                $query_tai_khoan = "UPDATE tai_khoan SET 
                    ten_dang_nhap=:ten_dang_nhap, 
                    ho_ten=:ho_ten, 
                    hinh_anh=:hinh_anh, 
                    mat_khau=:mat_khau, 
                    muoi=:muoi, 
                    ngay_cap_nhat=:ngay_cap_nhat
                    WHERE id=:id
                ";
                $stmt_tai_khoan = $con->prepare($query_tai_khoan);

//                $id_tai_khoan = generateId(8, 'tai_khoan', $con);

                if ($mat_khau != null) {
                    $muoi = generateRandomString(5);
                    $mat_khau = md5($mat_khau.$muoi);
                }

                //  Lấy trường “file” hình ảnh mới và lưu
                $hinh_anh = saveImage($_FILES["hinh_anh"], '../../uploads/hinh-anh/');
                if ($hinh_anh == false && $hinh_anh != null){
                    echo '<script type="text/javascript">location.href = "them.php"</script>';
                }
                $stmt_tai_khoan->bindParam(':id', $tai_khoan['id']);
                $stmt_tai_khoan->bindParam(':ten_dang_nhap', $ten_dang_nhap);
                $stmt_tai_khoan->bindParam(':ho_ten', $ten);
                if ($hinh_anh) {
                    $stmt_tai_khoan->bindParam(':hinh_anh', $hinh_anh);
                }
                else {
                    $stmt_tai_khoan->bindParam(':hinh_anh', $tai_khoan['hinh_anh']);
                }

                if ($mat_khau != null) {
                    $stmt_tai_khoan->bindParam(':mat_khau', $mat_khau);
                    $stmt_tai_khoan->bindParam(':muoi', $muoi);
                } else {
                    $stmt_tai_khoan->bindParam(':mat_khau', $tai_khoan['mat_khau']);
                    $stmt_tai_khoan->bindParam(':muoi', $tai_khoan['muoi']);
                }
                $stmt_tai_khoan->bindParam(':ngay_cap_nhat', $ngay_cap_nhat);


                if (!$stmt_tai_khoan->execute()) throw new PDOException("Cập nhật tài khoản bị lỗi");
            }
        }


        // truy vấn INSERT
        $query = "UPDATE giao_vien SET 
            ten=:ten, 
            email=:email, 
            don_vi_id=:don_vi_id, 
            chuc_vu_id=:chuc_vu_id, 
            gioi_tinh=:gioi_tinh,
            cap_bac=:cap_bac,
            tai_khoan_id=:tai_khoan_id,
            ngay_cap_nhat=:ngay_cap_nhat
            WHERE id=:id 
        ";

        // Chuẩn bị cho thực thi truy vấn
        $stmt = $con->prepare($query);



        // truyền các tham số cho câu truy vấn
        $stmt->bindParam(':ten', $ten);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':don_vi_id', $don_vi_id);
        $stmt->bindParam(':chuc_vu_id', $chuc_vu_id);
        $stmt->bindParam(':gioi_tinh', $gioi_tinh);
        $stmt->bindParam(':cap_bac', $cap_bac);
        $stmt->bindParam(':tai_khoan_id', $tai_khoan['id']);
        $stmt->bindParam(':ngay_cap_nhat', $ngay_cap_nhat);
        $stmt->bindParam(':id', $id);

        // Thực thi truy vấn
        if(!$stmt->execute()){
            throw new PDOException("Cập nhật giáo viên bị lỗi");
        }

        $con->commit();
        echo '<script type="text/javascript">location.href = "xem.php?id='.$id.'";</script>';
    }// hiển thị lỗi
    catch(PDOException $exception){
        $con->rollBack();
        session_set('error', $exception->getMessage());
        echo '<script type="text/javascript">location.href = "sua.php?id='.$id.'"</script>';
    }
}
?>

