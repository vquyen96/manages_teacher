<?php
include_once('../widgets/header.php');
$dir = basename(__DIR__) ;
// Lấy danh sách danh mục
$danh_muc_query = "SELECT * FROM danh_muc_nghien_cuu ORDER BY id DESC";
$danh_muc_stmt = $con->prepare($danh_muc_query);
$danh_muc_stmt->execute();
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
                                            <label class="col-sm-2 control-label">Tên</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="ten" class="form-control" placeholder="Tên">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Chi tiết</label>

                                            <div class="col-sm-10">
                                                <textarea name="chi_tiet" class="form-control" cols="30" rows="10"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Bắt đầu</label>

                                            <div class="col-sm-10">
                                                <input type="text" name="thoi_gian_bat_dau" class="form-control" placeholder="Thời gian bắt đầu">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Kêt thúc</label>

                                            <div class="col-sm-10">
                                                <input type="text" name="thoi_gian_ket_thuc" class="form-control" placeholder="Thời gian kết thúc">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" style="white-space: nowrap">Danh mục</label>

                                            <div class="col-sm-10">
                                                <select name="danh_muc_id" class="form-control" required>
                                                    <option value="" selected disabled>Chọn danh mục</option>
                                                    <?php
                                                    while ($danh_muc = $danh_muc_stmt->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<option value="'.$danh_muc['id'].'">'.$danh_muc['ten'].'</option>';
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
            chi_tiet=:chi_tiet, 
            thoi_gian_bat_dau=:thoi_gian_bat_dau, 
            thoi_gian_ket_thuc=:thoi_gian_ket_thuc, 
            danh_muc_id=:danh_muc_id, 
            trang_thai=:trang_thai, 
            ngay_tao=:ngay_tao
        ";

        // Chuẩn bị cho thực thi truy vấn
        $stmt = $con->prepare($query);

        // Các giá trị được lấy từ các trường nhập trên form
        $ten = htmlspecialchars(strip_tags($_POST['ten']));
        $chi_tiet = htmlspecialchars(strip_tags($_POST['chi_tiet']));
        $thoi_gian_bat_dau = htmlspecialchars(strip_tags($_POST['thoi_gian_bat_dau']));
        $thoi_gian_ket_thuc = htmlspecialchars(strip_tags($_POST['thoi_gian_ket_thuc']));
        $danh_muc_id = htmlspecialchars(strip_tags($_POST['danh_muc_id']));
        $trang_thai = 1;
        $ngay_tao = time();

        // truyền các tham số cho câu truy vấn
        $stmt->bindParam(':ten', $ten);
        $stmt->bindParam(':chi_tiet', $chi_tiet);
        $stmt->bindParam(':thoi_gian_bat_dau', $thoi_gian_bat_dau);
        $stmt->bindParam(':thoi_gian_ket_thuc', $thoi_gian_ket_thuc);
        $stmt->bindParam(':danh_muc_id', $danh_muc_id);
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

