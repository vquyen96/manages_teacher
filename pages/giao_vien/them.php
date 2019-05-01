<?php
    include_once('../widgets/header.php');
    // Lấy danh sách chức danh
    $chuc_danh_query = "SELECT * FROM chuc_danh ORDER BY id DESC";
    $chuc_danh_stmt = $con->prepare($chuc_danh_query);
    $chuc_danh_stmt->execute();

    // Lấy danh sách đơn vị công tác
    $don_vi_query = "SELECT * FROM don_vi_cong_tac ORDER BY id DESC";
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
                                                <label for="inputEmail3" class="col-sm-2 control-label" style="white-space: nowrap">Chức danh</label>

                                                <div class="col-sm-10">
                                                    <select name="chuc_vu_id"  class="form-control">
                                                        <?php
                                                            while ($chuc_danh = $chuc_danh_stmt->fetch(PDO::FETCH_ASSOC)) {
//                                                                extract($row);
                                                                echo '<option value="'.$chuc_danh['id'].'">'.$chuc_danh['ten'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label" style="white-space: nowrap">Đơn vị</label>
                                                <div class="col-sm-10">
                                                    <select name="don_vi_id" id="" class="form-control">
                                                        <?php
                                                        while ($don_vi = $don_vi_stmt->fetch(PDO::FETCH_ASSOC)) {
//                                                                extract($row);
                                                            echo '<option value="'.$don_vi['id'].'">'.$don_vi['ten'].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label" style="white-space: nowrap">Giới tính</label>

                                                <div class="col-sm-10">
                                                    <select name="gioi_tinh" class="form-control">
                                                        <option value="0">Nữ</option>
                                                        <option value="1">Nam</option>
                                                        <option value="2">Khác</option>
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
        $query = "INSERT INTO giao_vien SET 
            ten=:ten, 
            email=:email, 
            don_vi_id=:don_vi_id, 
            chuc_vu_id=:chuc_vu_id, 
            gioi_tinh=:gioi_tinh, 
            trang_thai=:trang_thai, 
            ngay_tao=:ngay_tao
        ";

        // Chuẩn bị cho thực thi truy vấn
        $stmt = $con->prepare($query);

        // Các giá trị được lấy từ các trường nhập trên form
        $ten = htmlspecialchars(strip_tags($_POST['ten']));
        $email = htmlspecialchars(strip_tags($_POST['email']));
        $don_vi_id = htmlspecialchars(strip_tags($_POST['don_vi_id']));
        $chuc_vu_id = htmlspecialchars(strip_tags($_POST['chuc_vu_id']));
        $gioi_tinh = htmlspecialchars(strip_tags($_POST['gioi_tinh']));
        $trang_thai = 1;
        $ngay_tao = time();

        // truyền các tham số cho câu truy vấn
        $stmt->bindParam(':ten', $ten);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':don_vi_id', $don_vi_id);
        $stmt->bindParam(':chuc_vu_id', $chuc_vu_id);
        $stmt->bindParam(':gioi_tinh', $gioi_tinh);
        $stmt->bindParam(':trang_thai', $trang_thai);
        $stmt->bindParam(':ngay_tao', $ngay_tao);

        // Thực thi truy vấn
        if($stmt->execute()){
            if (headers_sent()) {
                die("Chuyển trang bị lỗi. Hãy ấn vào <a href='don_vi.php'>Here</a>");
            }
            else{
                header("Refresh:0");
            }
        }else{
            header('Location: chuc_danh.php?create=error');
        }
    }// hiển thị lỗi
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>

