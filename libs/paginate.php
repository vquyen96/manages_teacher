<?php
//Phân Trang
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Thiết lập số bản ghi hoặc số dòng dữ liệu xuất hiện trong mỗi trang
$records_per_page = 5;

// Tính toán phục vụ truy vấn trong mệnh đề LIMIT
$from_record_num = ($records_per_page * $page) - $records_per_page;


//Hiển thị thông báo
$action = isset($_GET['action']) ? $_GET['action'] : "";

// nếu nó được điều hướng từ “xoa.php”
//if($action == 'deleted'){
//    echo "<div class='alert alert-success'>Sản phẩm đã được xoá.</div>";
//}
?>