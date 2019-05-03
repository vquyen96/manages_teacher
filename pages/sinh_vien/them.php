<?php
include_once('../widgets/header.php');
$dir = basename(__DIR__) ;
//// Lấy danh sách chức danh
//$chuc_danh_query = "SELECT * FROM chuc_danh ORDER BY id DESC";
//$chuc_danh_stmt = $con->prepare($chuc_danh_query);
//$chuc_danh_stmt->execute();
//
//// Lấy danh sách đơn vị công tác
//$don_vi_query = "SELECT * FROM don_vi_cong_tac ORDER BY id DESC";
//$don_vi_stmt = $con->prepare($don_vi_query);
//$don_vi_stmt->execute();
//
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới
            <small>sinh viên</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="../dashboard/index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="danhsach.php">Sinh viên</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Thêm mới Sinh viên</h3>
                    </div>
                    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
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
                                                <input type="text" name="ten" class="form-control" placeholder="Tên">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

                                            <div class="col-sm-10">
                                                <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Mã SV</label>

                                            <div class="col-sm-10">
                                                <input type="text" name="ma_sv" class="form-control" id="inputEmail3" placeholder="Mã sinh viên">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label" style="white-space: nowrap">Giới tính</label>

                                            <div class="col-sm-10">
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
        $query = "INSERT INTO ".$dir." SET 
            ten=:ten, 
            email=:email, 
            ma_sv=:ma_sv, 
            gioi_tinh=:gioi_tinh, 
            tong_thoi_gian=:tong_thoi_gian, 
            trang_thai=:trang_thai, 
            ngay_tao=:ngay_tao
        ";

        // Chuẩn bị cho thực thi truy vấn
        $stmt = $con->prepare($query);

        // Các giá trị được lấy từ các trường nhập trên form
        $ten = htmlspecialchars(strip_tags($_POST['ten']));
        $email = htmlspecialchars(strip_tags($_POST['email']));
        $ma_sv = htmlspecialchars(strip_tags($_POST['ma_sv']));
        $gioi_tinh = htmlspecialchars(strip_tags($_POST['gioi_tinh']));
        $tong_thoi_gian = htmlspecialchars(strip_tags($_POST['tong_thoi_gian']));
        $trang_thai = 1;
        $ngay_tao = time();

        // truyền các tham số cho câu truy vấn
        $stmt->bindParam(':ten', $ten);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':ma_sv', $ma_sv);
        $stmt->bindParam(':gioi_tinh', $gioi_tinh);
        $stmt->bindParam(':tong_thoi_gian', $tong_thoi_gian);
        $stmt->bindParam(':trang_thai', $trang_thai);
        $stmt->bindParam(':ngay_tao', $ngay_tao);

        // Thực thi truy vấn
        if($stmt->execute()){
            //Dùng JS để chuyển trang
            echo '<script type="text/javascript">location.href = "danhsach.php";</script>';

            //PHP chuyển trang bị lỗi
            if (headers_sent()) {
                die("Chuyển trang bị lỗi. Hãy ấn vào <a href='danhsach.php'>Here</a>");
            }
            else{
                header("Refresh:0");
            }
        }else{
            header('Location: danhsach.php?create=error');
        }
    }// hiển thị lỗi
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>

