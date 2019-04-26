<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Tạo một bản ghi - PHP CRUD Beginner</title>
    <!--Thư viện Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

</head>
<body>

<!-- container -->
<div class="container">

    <div class="page-header">
        <h1>Tạo sản phẩm mới</h1>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Tên sản phẩm</td>
                <td><input type='text' name='name' class='form-control' /></td>
            </tr>
            <tr>
                <td>Mô tả</td>
                <td><textarea name='description' class='form-control'></textarea></td>
            </tr>
            <tr>
                <td>Giá</td>
                <td><input type='text' name='price' class='form-control' /></td>
            </tr>
            <tr>
                <td>Hình ảnh</td>
                <td><input type="file" name="image" /></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type='submit' value='Lưu' class='btn btn-primary' />
                    <a href='index.php' class='btn btn-danger'>Quay lại danh sách sản phẩm</a>
                </td>
            </tr>
        </table>
    </form>

</div> <!-- end .container -->

<!-- jQuery (Thư viện Jquery, sự cần thiết cho Bootstrap's JavaScript) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<!--Thư viện Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>
<?php
if($_POST){

    // include file kết nối CSDL
    include 'database.php';

    try{

        // truy vấn INSERT
        $query = "INSERT INTO products SET name=:name, description=:description, price=:price, created=:created";

        // Chuẩn bị cho thực thi truy vấn
        $stmt = $con->prepare($query);

        // Các giá trị được lấy từ các trường nhập trên form
        $name=htmlspecialchars(strip_tags($_POST['name']));
        $description=htmlspecialchars(strip_tags($_POST['description']));
        $price=htmlspecialchars(strip_tags($_POST['price']));

        // truyền các tham số cho câu truy vấn
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);

        // Định dạng kiểu thời gian cho dữ liệu của trường “created”
        $created=date('Y-m-d H:i:s');
        $stmt->bindParam(':created', $created);

        // Thực thi truy vấn
        if($stmt->execute()){
            echo "<div class='alert alert-success'>Tạo sản phẩm mới thành công.</div>";
        }else{
            echo "<div class='alert alert-danger'>Tạo sản phẩm mới thất bại.</div>";
        }

    }



        // hiển thị lỗi
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }

    // nếu ảnh không rỗng thì tiến hành upload
    if($image){

        // sha1_file() là hàm dùng tạo tên file ảnh là duy nhất
        $target_directory = "uploads/";
        $target_file = $target_directory . $image;
        $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

        // Thông báo lỗi nếu upload lỗi
        $file_upload_error_messages="";

    }

    // đảm bảo đây là file ảnh
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check!==false){
        // file được submit là một file ảnh
    }else{
        $file_upload_error_messages.="<div>File upload không phải là file ảnh.</div>";
    }

    // các định dạng file ảnh được phép upload
    $allowed_file_types=array("jpg", "jpeg", "png", "gif");
    if(!in_array($file_type, $allowed_file_types)){
        $file_upload_error_messages.="<div>Chỉ cho phép upload các định dạng JPG, JPEG, PNG, GIF.</div>";
    }

    // Đảm bảo file này chưa tồn tại
    if(file_exists($target_file)){
        $file_upload_error_messages.="<div>Ảnh này đã tồn tại. Bạn nên thay đổi tên file ảnh.</div>";
    }

    // truy vấn INSERT
    $query = "INSERT INTO products SET name=:name, description=:description,  price=:price, image=:image, created=:created";

// Chuẩn bị cho thực thi truy vấn
    $stmt = $con->prepare($query);

// Các giá trị được lấy từ các trường nhập trên form
    $name=htmlspecialchars(strip_tags($_POST['name']));
    $description=htmlspecialchars(strip_tags($_POST['description']));
    $price=htmlspecialchars(strip_tags($_POST['price']));

// trường “image” mới
    $image=!empty($_FILES["image"]["name"])? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"]): "";
    $image=htmlspecialchars(strip_tags($image));

// truyền các tham số cho câu truy vấn
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':image', $image);

// Định dạng kiểu thời gian cho dữ liệu của trường “created”
    $created=date('Y-m-d H:i:s');
    $stmt->bindParam(':created', $created);
}
?>