<?php
include 'database.php';
include 'libs/helper.php';

$data = [
    'ten_dang_nhap' => 'admin',
    'ho_ten' => 'Admin',
    'phan_quyen' => 1,
    'trang_thai' => 1,
    'ngay_tao' => time(),
    'ngay_cap_nhat' => time(),
];

try{
    // truy vấn INSERT
    $query = "INSERT INTO tai_khoan SET 
      ten_dang_nhap=:ten_dang_nhap, 
      ho_ten=:ho_ten,  
      mat_khau=:mat_khau, 
      muoi=:muoi, 
      phan_quyen=:phan_quyen,
      trang_thai=:trang_thai,
      ngay_tao=:ngay_tao,
      ngay_cap_nhat=:ngay_cap_nhat
      ";

    // Chuẩn bị cho thực thi truy vấn
    $stmt = $con->prepare($query);

    // truyền các tham số cho câu truy vấn
    $stmt->bindParam(':ten_dang_nhap', $data['ten_dang_nhap']);
    $stmt->bindParam(':ho_ten', $data['ho_ten']);
    $stmt->bindParam(':phan_quyen', $data['phan_quyen']);
    $stmt->bindParam(':trang_thai', $data['trang_thai']);
    $stmt->bindParam(':ngay_tao', $data['ngay_tao']);
    $stmt->bindParam(':ngay_cap_nhat', $data['ngay_cap_nhat']);
    // tạo muối
    $muoi = generateRandomString(5);
    $stmt->bindParam(':muoi', $muoi);

    // tạo mật khẩu
    $mat_khau = md5('admin'.$muoi);
    $stmt->bindParam(':mat_khau', $mat_khau);

    // Thực thi truy vấn
    if($stmt->execute()){
        echo "<div class='alert alert-success'>Tạo sản phẩm mới thành công.</div>";
    }else{
        echo "<div class='alert alert-danger'>Tạo sản phẩm mới thất bại.</div>";
    }

}// hiển thị lỗi
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
