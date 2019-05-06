<?php
include_once('../widgets/header.php') ;
include_once('../../libs/paginate.php') ;
$dir = basename(__DIR__) ;

// lấy dữ liệu cho trang hiện tại
$query = "SELECT * FROM ".$dir." WHERE trang_thai=1 ORDER BY id DESC
            LIMIT :from_record_num, :records_per_page";
$stmt = $con->prepare($query);
$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
$stmt->execute();

// số lượng bản ghi trả về
$num = $stmt->rowCount();
// liên kết gọi đến trang Tạo sản phẩm mới

if (isset($_GET['action']) && $_GET['action'] == 'sua') {
    $formId=isset($_GET['id']) ? $_GET['id'] : die('LỖI: Không tìm thấy ID.');
    try {
        // chuẩn bị câu truy vấn
        $queryEdit = "SELECT * FROM ".$dir." WHERE id = ? LIMIT 0,1";
        $stmtEdit = $con->prepare( $queryEdit );

        // truyền giá trị cho tham số ‘?’ trong câu truy vấn bên trên
        $stmtEdit->bindParam(1, $formId);

        // thực thi truy vấn
        $stmtEdit->execute();

        // lưu dòng dữ liệu lấy được vào một biến $row
        $rowEdit = $stmtEdit->fetch(PDO::FETCH_ASSOC);

        // điền lần lượt giá trị vào form thông qua các biến
        $formTen = $rowEdit['ten'];
        $formChiTiet = $rowEdit['chi_tiet'];
        $formThoiGianDinhMuc = $rowEdit['thoi_gian_dinh_muc'];
        $formMa = $rowEdit['ma'];
    }
        // hiển thị lỗi
    catch(PDOException $exception){
        die('LỖI: ' . $exception->getMessage());
    }
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh mục
            <small>nghiên cứu</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="../dashboard/index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="danhsach.php">Nghiên cứu</a></li>
            <li class="active">Danh mục </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

                        <div class="box-header">
                            <h3 class="box-title">Danh mục nghiên cứu</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <?php if ($num > 0) { ?>
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Tên</th>
                                                <th>Mã danh mục</th>
                                                <th>Giờ định mức</th>
                                                <th>Tùy chọn</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                // thay cho việc truy xuất dữ liệu bằng cách $row[‘name’], thì chỉ cần gọi $name
                                                // bằng cách sử dụng hàm extract($row)
                                                extract($row);
                                                ?>
                                                <tr>
                                                    <td><?php echo $ten?></td>
                                                    <td><?php echo $ma?></td>
                                                    <td><?php echo $thoi_gian_dinh_muc ?></td>
                                                    <td class="d-flex">
                                                        <a href="danhsach.php<?php echo '?id='.$id.'&action=sua'?>" class="btn btn-sm btn-primary margin-r-2">Sửa</a>
                                                        <a href="xoa.php<?php echo '?id='.$id?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn muốn XÓA')">Xóa</a>
                                                    </td>
                                                </tr>
                                            <?php }?>
                                        </table>
                                        <?php

                                        // PHÂN TRANG
                                        // đếm tổng số bản ghi
                                        $query = "SELECT COUNT(*) as total_rows FROM danh_muc_nghien_cuu";
                                        $stmt = $con->prepare($query);

                                        // thực thi truy vấn
                                        $stmt->execute();

                                        // lấy tổng số dòng dữ liệu
                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $total_rows = $row['total_rows'];

                                        // điều hướng phân trang
                                        $page_url="danhsach.php?";
                                        include_once "../../paging.php";

                                    } else {
                                        echo "<div class='alert alert-danger'>Không tìm chức danh nào.</div>";
                                    }
                                    ?>
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tên</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="ten" placeholder="Tên" value="<?php if (isset($formTen)) echo $formTen;?>">
                                                <input type="text" class="form-control d-none" name="id" value="<?php if (isset($formId)) echo $formId;?>">
                                                <input type="text" class="form-control d-none" name="_method" value="<?php if (isset($formId)) echo "put"; else echo "post";?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Chi tiết</label>
                                            <div class="col-sm-10">
                                                <textarea name="chi_tiet" id="" cols="30" rows="10" class="form-control"><?php if (isset($formChiTiet)) echo $formChiTiet;?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label ws-nowrap">Mã danh mục</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="ma" placeholder="Mã danh mục" value="<?php if (isset($formMa)) echo $formMa;?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label ws-nowrap">Tổng giờ</label>

                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="thoi_gian_dinh_muc" placeholder="Thời gian định mức" value="<?php if (isset($formThoiGianDinhMuc)) echo $formThoiGianDinhMuc;?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="danhsach.php" class="btn btn-default">Danh sách giáo viên</a>
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
    $method = htmlspecialchars(strip_tags($_POST['_method']));
    if ($method == 'post') {
        try{
            // truy vấn INSERT
            $query = "INSERT INTO ".$dir." SET ten=:ten, chi_tiet=:chi_tiet,  thoi_gian_dinh_muc=:thoi_gian_dinh_muc, trang_thai=:trang_thai, ngay_tao=:ngay_tao, ma=:ma";
            echo $query;
            // Chuẩn bị cho thực thi truy vấn
            $stmt = $con->prepare($query);

            // Các giá trị được lấy từ các trường nhập trên form
            $ten = htmlspecialchars(strip_tags($_POST['ten']));
            $chi_tiet = htmlspecialchars(strip_tags($_POST['chi_tiet']));
            $ma = htmlspecialchars(strip_tags($_POST['ma']));
            $thoi_gian_dinh_muc = htmlspecialchars(strip_tags($_POST['thoi_gian_dinh_muc']));
            $trang_thai = 1;
            $ngay_tao = time();

            // truyền các tham số cho câu truy vấn
            $stmt->bindParam(':ten', $ten);
            $stmt->bindParam(':chi_tiet', $chi_tiet);
            $stmt->bindParam(':ma', $ma);
            $stmt->bindParam(':thoi_gian_dinh_muc', $thoi_gian_dinh_muc);
            $stmt->bindParam(':trang_thai', $trang_thai);
            $stmt->bindParam(':ngay_tao', $ngay_tao);

            echo $ten;
            // Thực thi truy vấn
            if($stmt->execute()){
                echo '<script type="text/javascript">location.href = "danhsach.php";</script>';
                if (headers_sent()) {
                    die("Chuyển trang bị lỗi. Hãy ấn vào <a href='chuc_danh.php'>Here</a>");
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
    if ($method == 'put') {
        try{
            // truy vấn INSERT
            $query = "UPDATE ".$dir." SET ten=:ten, chi_tiet=:chi_tiet,  thoi_gian_dinh_muc=:thoi_gian_dinh_muc, trang_thai=:trang_thai, ngay_cap_nhat=:ngay_cap_nhat, ma=:ma  WHERE id=:id";

            // Chuẩn bị cho thực thi truy vấn
            $stmt = $con->prepare($query);

            // Các giá trị được lấy từ các trường nhập trên form
            $id = htmlspecialchars(strip_tags($_POST['id']));

            $ten = htmlspecialchars(strip_tags($_POST['ten']));
            $chi_tiet = htmlspecialchars(strip_tags($_POST['chi_tiet']));
            $thoi_gian_dinh_muc = htmlspecialchars(strip_tags($_POST['thoi_gian_dinh_muc']));
            $ma = htmlspecialchars(strip_tags($_POST['ma']));
            $trang_thai = 1;
            $ngay_cap_nhat = time();

            // truyền các tham số cho câu truy vấn
            $stmt->bindParam(':ten', $ten);
            $stmt->bindParam(':chi_tiet', $chi_tiet);
            $stmt->bindParam(':thoi_gian_dinh_muc', $thoi_gian_dinh_muc);
            $stmt->bindParam(':trang_thai', $trang_thai);
            $stmt->bindParam(':ngay_cap_nhat', $ngay_cap_nhat);
            $stmt->bindParam(':ma', $ma);
            $stmt->bindParam(':id', $id);

            // Thực thi truy vấn
            if($stmt->execute()){
                echo '<script type="text/javascript">location.href = "danhsach.php";</script>';
//                if (headers_sent()) {
//                    die("Chuyển trang bị lỗi. Hãy ấn vào <a href='chuc_danh.php'>Here</a>");
//                }
//                else{
//                    header("Refresh:0");
//                }
            }else{
                echo 'error';
                header('Location: chuc_danh.php');
            }
        }// hiển thị lỗi
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
    }
}


?>
