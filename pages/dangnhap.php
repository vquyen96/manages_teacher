<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Đăng nhập</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <?php
    include '../database.php';
    include '../libs/role.php';
    include '../libs/session.php';
    include '../libs/helper.php';
    include '../libs/checkLogout.php';
    $error = isset($_GET['error']) ? $_GET['error'] : "";
    ?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../index2.html"><b>Quản lý</b> nckh</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Đăng nhập</p>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Tên đăng nhập" name="ten_dang_nhap">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          <?php

          if($error == 'ten_dang_nhap'){
              echo "<span class='text-danger' style='font-size: 11px;'>Tên đăng nhập không tồn tại</span>";
          }
          ?>
      </div>

        <span class="text-danger"></span>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Mật khẩu" name="mat_khau">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          <?php

          if($error == 'mat_khau'){
              echo "<span class='text-danger' style='font-size: 11px;'>Mật khẩu của bạn không đúng</span>";
          }
          ?>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Nhớ đăng nhập
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <!-- /.social-auth-links -->

<!--    <a href="#">I forgot my password</a><br>-->
<!--    <a href="register.html" class="text-center">Register a new membership</a>-->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
<?php
    if ($_POST) {
        $ten_dang_nhap = htmlspecialchars(strip_tags($_POST['ten_dang_nhap']));
        $mat_khau = htmlspecialchars(strip_tags($_POST['mat_khau']));

        $query = "SELECT * FROM tai_khoan WHERE ten_dang_nhap = ? LIMIT 0,1";

        // Chuẩn bị cho thực thi truy vấn
        $stmt = $con->prepare( $query );

        // truyền giá trị cho tham số ‘?’ trong câu truy vấn bên trên
        $stmt->bindParam(1, $ten_dang_nhap);

        // thực thi truy vấn
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            header('Location: dangnhap.php?error=ten_dang_nhap');
        }
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $muoi = $row['muoi'];
        if (md5($mat_khau.$muoi) != $row['mat_khau']) {
            header('Location: dangnhap.php?error=mat_khau');
        } else {
            $ma_dang_nhap = generateRandomString(64);

            // truy vấn UPDATE
            $query = "UPDATE tai_khoan SET ma_dang_nhap=:ma_dang_nhap, ngay_het_han=:ngay_het_han WHERE id=:id";

            // Chuẩn bị cho thực thi truy vấn
            $stmt = $con->prepare($query);

            $ngay_het_han = time()+86400;
            $stmt->bindParam(':ma_dang_nhap', $ma_dang_nhap);
            $stmt->bindParam(':ngay_het_han', $ngay_het_han);
            $stmt->bindParam(':id', $row['id']);

            // Thực thi truy vấn
            if($stmt->execute()){

                session_set('token', $ma_dang_nhap);

                header('Location: dashboard/index.php');
            }else{
                header('Location: dangnhap.php?error=unknown');
            }
        }
    }
?>
