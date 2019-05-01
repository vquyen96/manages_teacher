<!DOCTYPE html>
<?php
    // include kết nối CSDL
    include '../../database.php';
    include '../../libs/role.php';
    include '../../libs/session.php';
    include '../../libs/checkLogin.php';
?>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Location" content="http://localhost/manages_teacher/">
    <title>
        <?php
        $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        $folder =  $uriSegments[3];
        $file = $uriSegments[4];
        switch ($folder) {
            case 'dashboard':
                echo 'Thống kê';
                break;
            case 'giao_vien':
                switch ($file) {
                    case 'danhsach.php':
                        echo 'Danh sách giáo viên';
                        break;
                    case 'them.php':
                        echo 'Thêm mới giáo viên';
                        break;
                    case 'chuc_danh.php':
                        echo 'Chức danh giáo viên';
                        break;
                }
                break;
        }
        ?>
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <!--<link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">-->
    <!-- Ionicons -->
    <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="../../bower_components/morris.js/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="../../bower_components/jvectormap/jquery-jvectormap.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../../bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <link rel="stylesheet" href="../../dist/css/style.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<?php
    if (isset($folder) && isset($file)) {
        switch ($folder) {
            case 'dashboard':
                echo '<link rel="stylesheet" href="../../bower_components/morris.js/morris.css">';
                echo '<link rel="stylesheet" href="../../bower_components/jvectormap/jquery-jvectormap.css">';
                echo '<link rel="stylesheet" href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">';
                echo '<link rel="stylesheet" href="../../bower_components/bootstrap-daterangepicker/daterangepicker.css">';
                echo '<link rel="stylesheet" href="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">';
                break;
            case 'giao_vien':
                switch ($file) {
                    case 'danhsach.php':
                        echo '<link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">';
                        break;
                    case 'chuc_danh.php':
                        echo '<link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">';
                        break;
                    default:
                        break;
                }
                break;
            default :
                break;
        };
    }

?>
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="../../index.php" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b>dm</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Admin</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="../../#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <i class="fas fa-bars"></i>
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="../../#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs">Phương Thảo</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                <p>
                                    Phương Thảo - Web Developer
                                    <small>Member since Mar. 2019</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="" class="btn btn-default btn-flat">Cá nhân</a>
                                </div>
                                <div class="pull-right">
                                    <a href="../../pages/examples/login.php" class="btn btn-default btn-flat">Đăng
                                        xuất</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>Phương Thảo</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Quản lý</a>
                </div>
            </div>

            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header"></li>
                <li class="<?php if ($folder == 'dashboard') echo 'active';?>">
                    <a href="../../index.php">
                        <i class="fas fa-tachometer-alt"></i> <span>Thống kê</span>
                    </a>
                </li>
                <li class="<?php if ($folder == 'giao_vien') echo 'active';?> treeview">
                    <a href="#">
                        <i class="fas fa-id-card-alt"></i>
                        <span>Giáo viên</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?php if ($file == 'danhsach.php') echo 'active';?>"><a href="../giao_vien/danhsach.php"><i class="far fa-circle"></i>Danh sách</a></li>
                        <li class="<?php if ($file == 'them.php') echo 'active';?>"><a href="../giao_vien/them.php"><i class="far fa-circle"></i>Thêm mới</a></li>
                        <li class="<?php if ($file == 'chuc_danh.php') echo 'active';?>"><a href="../giao_vien/chuc_danh.php"><i class="far fa-circle"></i>Chức danh</a></li>
                        <li class="<?php if ($file == 'don_vi.php') echo 'active';?>"><a href="../giao_vien/don_vi.php"><i class="far fa-circle"></i>Đơn vị</a></li>
                    </ul>
                </li>
                <li class="<?php if ($folder == 'student') echo 'active';?> treeview">
                    <a href="../../#">
                        <i class="fas fa-users"></i>
                        <span>Học sinh</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class=""><a href="../../pages/student/index.php"><i class="far fa-circle"></i>Danh sách</a>
                        </li>
                        <li><a href="../../create.php"><i class="far fa-circle"></i>Thêm mới</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="../../#">
                        <i class="fas fa-microscope"></i>
                        <span>Nghiên cứu</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="../../pages/research/index.php"><i class="far fa-circle"></i>Danh sách</a></li>
                        <li><a href="../../pages/research/create.php"><i class="far fa-circle"></i>Thêm mới</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="../../#">
                        <i class="fas fa-file-alt"></i>
                        <span>Giáo trình</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="../../pages/document/index.php"><i class="far fa-circle"></i>Danh sách</a></li>
                        <li><a href="../../pages/document/create.php"><i class="far fa-circle"></i>Thêm mới</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="../../#">
                        <i class="far fa-address-card"></i>
                        <span>Bài báo</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="../../pages/post/index.php"><i class="far fa-circle"></i>Danh sách</a></li>
                        <li><a href="../../pages/post/create.php"><i class="far fa-circle"></i>Thêm mới</a></li>
                    </ul>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>