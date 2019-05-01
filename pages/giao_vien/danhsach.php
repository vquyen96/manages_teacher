<?php
    include_once('../widgets/header.php') ;
    include_once('../../libs/paginate.php') ;
    $dir = basename(__DIR__) ;
    // lấy dữ liệu cho trang hiện tại
    $query = "SELECT * FROM {$dir} ORDER BY id DESC
            LIMIT :from_record_num, :records_per_page";
    $stmt = $con->prepare($query);
    $stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
    $stmt->execute();

    // số lượng bản ghi trả về
    $num = $stmt->rowCount();
    // liên kết gọi đến trang Tạo sản phẩm mới
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách
            <small>giáo viên</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="../../index.html"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="#">Giáo viên</a></li>
            <li class="active">Danh sách</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Tất cả giáo viên</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php if ($num > 0) { ?>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Chức danh</th>
                                <th>Đơn vị</th>
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
                                <td><?php echo $email?></td>
                                <td><?php echo $chuc_vu_id ?></td>
                                <td><?php echo $don_vi_id?></td>
                                <td>
                                    <a href="sua.php" class="btn btn-primary">Sửa</a>
                                    <a href="xoa.php<?php echo '?id='.$id ?>" class="btn btn-danger" onclick="return confirm('Bạn chắc chắn muốn XÓA')">Xóa</a>
                                </td>
                            </tr>
                            <?php }?>
                        </table>
                        <?php

                            // PHÂN TRANG
                            // đếm tổng số bản ghi
                            $query = "SELECT COUNT(*) as total_rows FROM products";
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
                            echo "<div class='alert alert-danger'>Không tìm thấy giáo viên nào.</div>";
                        }
                        ?>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<?php include_once('../widgets/footer.php') ?>
