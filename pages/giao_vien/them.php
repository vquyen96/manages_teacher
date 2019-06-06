<?php
    include_once('../widgets/header.php');
    // Lấy danh sách chức danh
    $chuc_danh_query = "SELECT * FROM chuc_danh WHERE trang_thai = 1 ORDER BY id DESC";
    $chuc_danh_stmt = $con->prepare($chuc_danh_query);
    $chuc_danh_stmt->execute();

    // Lấy danh sách đơn vị công tác
    $don_vi_query = "SELECT * FROM don_vi_cong_tac WHERE trang_thai = 1 ORDER BY id DESC";
    $don_vi_stmt = $con->prepare($don_vi_query);
    $don_vi_stmt->execute();


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới
            <small>giáo viên</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="../dashboard/index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="danhsach.php">Giáo viên</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Thêm mới giáo viên</h3>
                    </div>
                    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data" id="form-giao-vien">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="btn-tai-khoan btn btn-primary text-center mb-3" style="width: 100%">
                                    <i class="fas fa-user"></i>
                                    Tài khoản
                                </div>
                                <div class="form-tai-khoan slide-up" >
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label ws-nowrap">Tên đăng nhập</label>

                                        <div class="col-sm-8">
                                            <input type="text" name="ten_dang_nhap" class="form-control" placeholder="Tên đăng nhập">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label ws-nowrap">Mật khẩu</label>
                                        <div class="col-sm-8">
                                            <input type="password" name="mat_khau" class="form-control" placeholder="Mật khẩu" id="mat_khau">
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
                                                <input type="file" name="hinh_anh" class="hidden" onchange="changeImg(this)">
                                                <img style="cursor: pointer; width: 100%;" class="img-file thumbnail" src="../../dist/img/avatar.png">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Tên</label>

                                        <div class="col-sm-8">
                                            <input type="text" name="ten" class="form-control" placeholder="Tên">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Email</label>

                                        <div class="col-sm-8">
                                            <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" style="white-space: nowrap">Chức danh</label>

                                        <div class="col-sm-8">
                                            <select name="chuc_vu_id"  class="form-control" required>
                                                <option value="" selected disabled>Chọn chức danh</option>
                                                <?php
                                                    while ($chuc_danh = $chuc_danh_stmt->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<option value="'.$chuc_danh['id'].'">'.$chuc_danh['ten'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" style="white-space: nowrap">Đơn vị</label>
                                        <div class="col-sm-8">
                                            <select name="don_vi_id" id="" class="form-control" required>
                                                <option value="" selected disabled>Chọn đơn vị công tác</option>
                                                <?php
                                                while ($don_vi = $don_vi_stmt->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<option value="'.$don_vi['id'].'">'.$don_vi['ten'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" style="white-space: nowrap">Giới tính</label>

                                        <div class="col-sm-8">
                                            <select name="gioi_tinh" class="form-control" required>
                                                <option value="" selected disabled>Chọn giới tính</option>
                                                <?php
                                                foreach ($genders as $index => $gender) {
                                                    echo '<option value="'.$index.'" >'.$gender.'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" style="white-space: nowrap">Cấp bậc</label>

                                        <div class="col-sm-8">
                                            <select name="cap_bac" class="form-control" required>
                                                <option value="" selected disabled>Chọn cấp bậc</option>
                                                <?php
                                                foreach ($ranks as $index => $rank) {
                                                    echo '<option value="'.$index.'" >'.$rank.'</option>';
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
    $id_tai_khoan = null;
    try{
        // bắt đầu transaction
        $con->beginTransaction();

        $ten_dang_nhap = htmlspecialchars(strip_tags($_POST['ten_dang_nhap']));
        $mat_khau = htmlspecialchars(strip_tags($_POST['mat_khau']));
        $phan_quyen = 2;

        $ten = htmlspecialchars(strip_tags($_POST['ten']));
        $email = htmlspecialchars(strip_tags($_POST['email']));
        $don_vi_id = htmlspecialchars(strip_tags($_POST['don_vi_id']));
        $chuc_vu_id = htmlspecialchars(strip_tags($_POST['chuc_vu_id']));
        $gioi_tinh = htmlspecialchars(strip_tags($_POST['gioi_tinh']));
        $cap_bac = htmlspecialchars(strip_tags($_POST['cap_bac']));
        $trang_thai = 1;
        $ngay_tao = time();

        if ($ten_dang_nhap != null) {
            if (isValidUsername($ten_dang_nhap, null, $con)) {
                throw new PDOException("Tên đăng nhập đá tòn tại");
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


            if (!$stmt_tai_khoan->execute()) throw new PDOException("Thêm tài khoản bị lỗi");
        }


        // truy vấn INSERT
        $query = "INSERT INTO giao_vien SET 
            ten=:ten, 
            email=:email, 
            don_vi_id=:don_vi_id, 
            chuc_vu_id=:chuc_vu_id, 
            gioi_tinh=:gioi_tinh, 
            cap_bac=:cap_bac, 
            tai_khoan_id=:tai_khoan_id, 
            trang_thai=:trang_thai, 
            ngay_tao=:ngay_tao
        ";

        // Chuẩn bị cho thực thi truy vấn
        $stmt = $con->prepare($query);

        // Các giá trị được lấy từ các trường nhập trên form


        // truyền các tham số cho câu truy vấn
        $stmt->bindParam(':ten', $ten);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':don_vi_id', $don_vi_id);
        $stmt->bindParam(':chuc_vu_id', $chuc_vu_id);
        $stmt->bindParam(':gioi_tinh', $gioi_tinh);
        $stmt->bindParam(':cap_bac', $cap_bac);
        $stmt->bindParam(':tai_khoan_id', $id_tai_khoan);
        $stmt->bindParam(':trang_thai', $trang_thai);
        $stmt->bindParam(':ngay_tao', $ngay_tao);

        // Thực thi truy vấn
        $stmt->execute();

        $con->commit();
        echo '<script type="text/javascript">location.href = "danhsach.php";</script>';
    }// hiển thị lỗi
    catch(PDOException $exception){
//        die('ERROR: ' . $exception->getMessage());
        $con->rollBack();
        session_set('error', $exception->getMessage());
        echo '<script type="text/javascript">location.href = "them.php"</script>';
    }
}
?>

