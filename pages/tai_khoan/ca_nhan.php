<?php
include_once('../widgets/header.php');
$dir = basename(__DIR__) ;

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Trang cá nhân
        </h1>
        <ol class="breadcrumb">
            <li><a href="../dashboard/index.php"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li class="active">Cá nhân</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-danger">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="<?php if ($auth['hinh_anh'] != null && $auth['hinh_anh'] != "") echo '../../uploads/hinh-anh/'.$auth['hinh_anh']; else echo '../../dist/img/user2.jpg';  ?>" alt="<?php echo $auth['ten']?>">

                        <h3 class="profile-username text-center"><?php echo $auth['ho_ten']?></h3>

                        <p class="text-muted text-center"><?php echo $roles[$auth['phan_quyen']]?></p>

                        <ul class="list-group list-group-unbordered">
                            <?php if ($auth['phan_quyen'] == 2) {?>
                                <li class="list-group-item">
                                    <b>Followers</b> <a class="pull-right">1,322</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Following</b> <a class="pull-right">543</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Friends</b> <a class="pull-right">13,287</a>
                                </li>
                            <?php } ?>
                        </ul>

                        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="box box-danger">
                    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data" id="form-tai-khoan">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div>
                                        <input id="img" type="file" name="hinh_anh" class="hidden" onchange="changeImg(this)">
                                        <img style="cursor: pointer; width: 100%;" class="img-file thumbnail" src="<?php if ($auth['hinh_anh'] != null && $auth['hinh_anh'] != "") echo '../../uploads/hinh-anh/'.$auth['hinh_anh']; else echo '../../dist/img/user2.jpg';  ?>">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Tên đăng nhập</label>

                                            <div class="col-sm-8">
                                                <input type="text" name="ten_dang_nhap" class="form-control" placeholder="Tên đăng nhập" value="<?php echo $auth['ten_dang_nhap']?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Họ tên</label>

                                            <div class="col-sm-8">
                                                <input type="text" name="ho_ten" class="form-control" placeholder="Họ tên" value="<?php echo $auth['ho_ten']?>">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-warning pull-right btn-change-pass">Đổi mật khẩu</button>
                                        <div class="form-change-pass d-none">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Mật khẩu mới</label>

                                                <div class="col-sm-8">
                                                    <input type="password" name="mat_khau" class="form-control" placeholder="Mật khẩu mới">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Nhập lại mật khẩu</label>

                                                <div class="col-sm-8">
                                                    <input type="password" name="re_mat_khau" class="form-control" placeholder="Nhập lại mật khẩu">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="../dashboard/index.php" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right">Save</button>
                        </div>
                    </form>

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

