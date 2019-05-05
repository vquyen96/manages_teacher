<?php
include_once('../widgets/header.php');
$dir = basename(__DIR__) ;
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
                    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"  enctype="multipart/form-data">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Minh Chứng</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="minh_chung" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
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
                                                <input type="text" name="thoi_gian_bat_dau" class="form-control datepicker" autocomplete="off" placeholder="Thời gian bắt đầu">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Kêt thúc</label>

                                            <div class="col-sm-10">
                                                <input type="text" name="thoi_gian_ket_thuc" class="form-control datepicker" autocomplete="off" placeholder="Thời gian kết thúc">
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
                                        <hr>
                                        <h3>Giáo viên</h3>
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
                                        <div class="mb-3 d-flex" >
                                            <div class="form-control d-flex" style="align-items: center">
                                                <select class="form-control select2" name="sinh_vien_id[]">
                                                    <option selected disabled>Chọn giao viên</option>
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
                                        <button type="button" class="btn btn-sm btn-primary pull-right" id="btn-add-svnc">
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
        $query = "INSERT INTO ".$dir." SET 
            id=:id,
            ten=:ten, 
            chi_tiet=:chi_tiet,
            thoi_gian_bat_dau=:thoi_gian_bat_dau,
            thoi_gian_ket_thuc=:thoi_gian_ket_thuc,
            danh_muc_id=:danh_muc_id,
            minh_chung=:minh_chung,
            trang_thai=:trang_thai,
            ngay_tao=:ngay_tao
            " ;

        // Chuẩn bị cho thực thi truy vấn
        $stmt = $con->prepare($query);

        // Hàm tạo chuỗi id unique(duy nhất)
        $id_nghien_cuu = generateId(8, 'nghien_cuu', $con);

        // Các giá trị được lấy từ các trường nhập trên form
        $ten = htmlspecialchars(strip_tags($_POST['ten']));
        $chi_tiet = htmlspecialchars(strip_tags($_POST['chi_tiet']));
        $thoi_gian_bat_dau = htmlspecialchars(strip_tags($_POST['thoi_gian_bat_dau']));
        $thoi_gian_bat_dau = strtotime($thoi_gian_bat_dau);
        $thoi_gian_ket_thuc = htmlspecialchars(strip_tags($_POST['thoi_gian_ket_thuc']));
        $thoi_gian_ket_thuc = strtotime($thoi_gian_ket_thuc);
        $danh_muc_id = htmlspecialchars(strip_tags($_POST['danh_muc_id']));
        $trang_thai = 1;
        $ngay_tao = time();

        //  Lấy trường “file” minh chứng mới
        $minh_chung=!empty($_FILES["minh_chung"]["name"])? sha1_file($_FILES['minh_chung']['tmp_name']) . "-" . basename($_FILES["minh_chung"]["name"]): "";
        $minh_chung=htmlspecialchars(strip_tags($minh_chung));

//        var_dump($_POST);
//        die();

        // truyền các tham số cho câu truy vấn
        $stmt->bindParam(':id', $id_nghien_cuu);
        $stmt->bindParam(':ten', $ten);
        $stmt->bindParam(':chi_tiet', $chi_tiet);
        $stmt->bindParam(':thoi_gian_bat_dau', $thoi_gian_bat_dau);
        $stmt->bindParam(':thoi_gian_ket_thuc', $thoi_gian_ket_thuc);
        $stmt->bindParam(':danh_muc_id', $danh_muc_id);
        $stmt->bindParam(':trang_thai', $trang_thai);
        $stmt->bindParam(':ngay_tao', $ngay_tao);
        $stmt->bindParam(':minh_chung', $minh_chung);

        // nếu ảnh không rỗng thì tiến hành upload
        if($minh_chung){

            // sha1_file() là hàm dùng tạo tên file ảnh là duy nhất
            $target_directory = "../../uploads/minh-chung/";
            $target_file = $target_directory . $minh_chung;
            $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

            // Thông báo lỗi nếu upload lỗi
            $file_upload_error_messages="";

            // các định dạng file ảnh được phép upload
            $allowed_file_types=array("jpg", "jpeg", "png", "gif", "doc", "docx", "pdf", 'pptx');
            if(!in_array($file_type, $allowed_file_types)){
                $file_upload_error_messages.="Chỉ cho phép upload các định dạng JPG, JPEG, PNG, GIF, DOC, PDF, PPTX";
            }

            // đảm bảo file ảnh khi sumit không quá 1 MB
            if($_FILES['minh_chung']['size'] > (1024000)){
                $file_upload_error_messages.="Kích thước file nên dưới 1 MB.";
            }

            // đảm bảo thư mục “upload” được tồn tại
            // nếu chưa tồn tại, tiến hành tạo mới
            if(!is_dir($target_directory)){
                mkdir($target_directory, 0777, true);
            }

            // nếu $file_upload_error_messages là rỗng (không có lỗi)
            if(empty($file_upload_error_messages)){
                if(move_uploaded_file($_FILES["minh_chung"]["tmp_name"], $target_file)){
                    // file ảnh đã được upload
                }else{
//                    $file_upload_error_messages = "Không upload được ảnh.";
//                    session_set('error', $file_upload_error_messages);
                    throw new PDOException($file_upload_error_messages);
                }
            }
            // nếu $file_upload_error_messages là không rỗng (có vấn đề xảy ra)
            else{
                // hiển thị cụ thể loại lỗi
//                session_set('error', $file_upload_error_messages);
                throw new PDOException($file_upload_error_messages);
            }
        }

        $stmt->execute();

        if (isset($_POST['giao_vien_id'])) {
            $giao_vien_id = $_POST['giao_vien_id'];
            $giao_vien_thoi_gian = $_POST['giao_vien_thoi_gian'];
            $giao_vien_vai_tro = $_POST['giao_vien_vai_tro'];

            for ($i = 0; $i < count($giao_vien_id); $i++) {
                $query_giao_vien_nghien_cuu = "INSERT INTO giao_vien_nghien_cuu SET
                    giao_vien_id=:giao_vien_id,
                    nghien_cuu_id=:nghien_cuu_id,
                    thoi_gian=:thoi_gian,
                    vai_tro=:vai_tro
                ";

                $stmt_gvnc = $con->prepare($query_giao_vien_nghien_cuu);
                $stmt_gvnc->bindParam(':giao_vien_id', $giao_vien_id[$i]);
                $stmt_gvnc->bindParam(':nghien_cuu_id', $id_nghien_cuu);
                $stmt_gvnc->bindParam(':thoi_gian', $giao_vien_thoi_gian[$i]);
                $stmt_gvnc->bindParam(':vai_tro', $giao_vien_vai_tro[$i]);
                $stmt_gvnc->execute();
            }
        }

        if (isset($_POST['sinh_vien_id'])) {
            $sinh_vien_id = $_POST['sinh_vien_id'];
            $sinh_vien_thoi_gian = $_POST['sinh_vien_thoi_gian'];
            $sinh_vien_vai_tro = $_POST['sinh_vien_vai_tro'];

            for ($i = 0; $i < count($sinh_vien_id); $i++) {
                $query_sinh_vien_nghien_cuu = "INSERT INTO sinh_vien_nghien_cuu SET
                    sinh_vien_id=:sinh_vien_id,
                    nghien_cuu_id=:nghien_cuu_id,
                    thoi_gian=:thoi_gian,
                    vai_tro=:vai_tro
                ";

                $stmt_gvnc = $con->prepare($query_sinh_vien_nghien_cuu);
                $stmt_gvnc->bindParam(':sinh_vien_id', $sinh_vien_id[$i]);
                $stmt_gvnc->bindParam(':nghien_cuu_id', $id_nghien_cuu);
                $stmt_gvnc->bindParam(':thoi_gian', $sinh_vien_thoi_gian[$i]);
                $stmt_gvnc->bindParam(':vai_tro', $sinh_vien_vai_tro[$i]);
                $stmt_gvnc->execute();
            }
        }

        // Không có lỗi sảy ra trong quá trình thêm vào bảng thì tất cả sẽ được lưu lại
        $con->commit();
        echo '<script type="text/javascript">location.href = "danhsach.php";</script>';
    }// hiển thị lỗi
    catch(PDOException $exception){
        // Khi có lỗi sảy ra , tất cả dữ liệu sẽ không được thêm vào bảng
        $con->rollBack();
//        die('ERROR: ' . $exception->getMessage());
        session_set('error', $exception->getMessage());
        echo '<script type="text/javascript">location.href = "them.php"</script>';
    }
}
?>

