<?php
// include kết nối CSDL
include '../../database.php';

try {
    $dir = basename(__DIR__) ;
    // lấy ID từ URL
    $id=isset($_GET['id']) ? $_GET['id'] : die('LỖI: Không tìm thấy ID.');

    // truy vấn xóa dữ liệu
    $query = "UPDATE {$dir} SET trang_thai=0  WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);

    if($stmt->execute()){
        header('Location: danhsach.php?action=deleted');
    }else{
        die('Không thể xóa bản ghi.');
    }
}

// Hiển thị lỗi
catch(PDOException $exception){
    die('LỖI: ' . $exception->getMessage());
}
?>