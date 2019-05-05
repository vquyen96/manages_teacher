<?php
include_once('../widgets/header.php');
$dir = basename(__DIR__) ;
$id=isset($_GET['id']) ? $_GET['id'] : die('LỖI: Không tìm thấy ID.');

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

    // Lấy map chức danh
    $queryChucDanh = "SELECT * FROM chuc_danh ";
    $stmtChucDanh = $con->prepare($queryChucDanh);
    $stmtChucDanh->execute();
    $chucdanh = [];
    while ($rowChucDanh = $stmtChucDanh->fetch(PDO::FETCH_ASSOC)){
        $chucdanh[$rowChucDanh['id']] = $rowChucDanh['ten'];
    }

    // Lấy map đơn vị
    $queryDonVi = "SELECT * FROM don_vi_cong_tac ";
    $stmtDonVi = $con->prepare($queryDonVi);
    $stmtDonVi->execute();
    $donvi = [];
    while ($rowDonVi = $stmtDonVi->fetch(PDO::FETCH_ASSOC)){
        $donvi[$rowDonVi['id']] = $rowDonVi['ten'];
    }


    $gvnc_query = "SELECT 
                    nc.id, 
                    nc.ten, 
                    gvnc.thoi_gian, 
                    gvnc.vai_tro 
                    FROM giao_vien_nghien_cuu gvnc
                    JOIN nghien_cuu nc
                    ON gvnc.nghien_cuu_id = nc.id
                    WHERE gvnc.giao_vien_id = :giao_vien_id";

    $gvnc_stmt = $con->prepare( $gvnc_query );
    $gvnc_stmt->bindParam(':giao_vien_id', $giao_vien['id']);
    $gvnc_stmt->execute();

    $nghien_cuus = $gvnc_stmt->fetchAll(PDO::FETCH_ASSOC);
    $tong_nghien_cuu = count($nghien_cuus);
}
// hiển thị lỗi
catch(PDOException $exception){
    session_set('error', $exception->getMessage());
    echo '<script type="text/javascript">location.href = "danhsach.php";</script>';
}


?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chi tiết giáo viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="../dashboard/index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="dánhach.php">Giáo viên</a></li>
            <li class="active">Chi tiết</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-danger">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="<?php if ($tai_khoan['hinh_anh'] != null && $tai_khoan['hinh_anh'] != "") echo '../../uploads/hinh-anh/'.$tai_khoan['hinh_anh']; else echo '../../dist/img/user2.jpg';  ?>" alt="<?php echo $auth['ten']?>">

                        <h3 class="profile-username text-center"><?php echo $giao_vien['ten']?></h3>

                        <p class="text-muted text-center"><?php echo $chucdanh[$giao_vien['chuc_vu_id']]?></p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Tổng thời gian</b> <a class="pull-right"><?php echo $giao_vien['tong_thoi_gian']?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Số nghiên cứu</b> <a class="pull-right"><?php echo $tong_nghien_cuu?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Đơn vị</b> <a class="pull-right"><?php echo $donvi[$giao_vien['don_vi_id']]?></a>
                            </li>

                        </ul>

                        <a href="sua.php?id=<?php echo $id?>" class="btn btn-primary btn-block"><b>Chỉnh sửa</b></a>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="box box-danger">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tên</th>
                                            <th>Thời gian</th>
                                            <th>Vai trò</th>
                                            <th>Tùy chọn</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($nghien_cuus as $nghien_cuu){

                                        ?>
                                        <tr>
                                            <td><?php echo $nghien_cuu['ten']?></td>
                                            <td><?php echo $nghien_cuu['thoi_gian']?></td>
                                            <td><?php echo $nghien_cuu['vai_tro']?></td>
                                            <td>
                                                <a href="../nghien_cuu/xem.php<?php echo '?id='.$nghien_cuu['id'] ?>" class="btn btn-success">Xem</a>
                                            </td>
                                        </tr>
                                    <?php }?>
                                </table>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="danhsach.php" class="btn btn-default">Cancel</a>
                            <a href="sua.php?id=<?php echo $id?>" class="btn btn-primary pull-right">Chỉnh sửa</a>
                        </div>

                    <!-- /.box-body -->
                </div>
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
        $query = "UPDATE ".$dir." SET 
            ten_dang_nhap=:ten_dang_nhap, 
            ho_ten=:ho_ten, 
            hinh_anh=:hinh_anh, 
            mat_khau=:mat_khau, 
            muoi=:muoi, 
            ngay_cap_nhat=:ngay_cap_nhat 
            WHERE id=:id
        ";

        // Chuẩn bị cho thực thi truy vấn
        $stmt = $con->prepare($query);

        // Các giá trị được lấy từ các trường nhập trên form
        $ten_dang_nhap = htmlspecialchars(strip_tags($_POST['ten_dang_nhap']));
        $ho_ten = htmlspecialchars(strip_tags($_POST['ho_ten']));
        $mat_khau = htmlspecialchars(strip_tags($_POST['mat_khau']));

        $ngay_cap_nhat = time();

        if ($mat_khau != null) {
            $muoi = generateRandomString(5);
            $mat_khau = md5($mat_khau.$muoi);
        }
        $hinh_anh = saveImage($_FILES["hinh_anh"], '../../uploads/hinh-anh/');
        if ($hinh_anh == false && $hinh_anh != null){
            echo '<script type="text/javascript">location.href = "ca_nhan.php"</script>';
        }

        // truyền các tham số cho câu truy vấn
        $stmt->bindParam(':ten_dang_nhap', $ten_dang_nhap);
        $stmt->bindParam(':ho_ten', $ho_ten);
        if ($hinh_anh) {
            $stmt->bindParam(':hinh_anh', $hinh_anh);
        }
        else {
            $stmt->bindParam(':hinh_anh', $auth['hinh_anh']);
        }

        if ($mat_khau != null) {
            $stmt->bindParam(':mat_khau', $mat_khau);
            $stmt->bindParam(':muoi', $muoi);
        } else {
            $stmt->bindParam(':mat_khau', $auth['mat_khau']);
            $stmt->bindParam(':muoi', $auth['muoi']);
        }
        $stmt->bindParam(':ngay_cap_nhat', $ngay_cap_nhat);
        $stmt->bindParam(':id', $auth['id']);

        // Thực thi truy vấn
        if($stmt->execute()){
            //Dùng JS để chuyển trang
            echo '<script type="text/javascript">location.href = "ca_nhan.php";</script>';
        }else{
            session_set('error', 'Cập nhật lỗi');
            echo '<script type="text/javascript">location.href = "ca_nhan.php";</script>';
        }
    }// hiển thị lỗi
    catch(PDOException $exception){
        session_set('error', $exception->getMessage());
        echo '<script type="text/javascript">location.href = "ca_nhan.php";</script>';
    }
}
?>

