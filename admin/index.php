<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'burger-shop') or die('Couldn\'t connect to Database');

    session_start();
    date_default_timezone_set('Asia/Ho_Chi_Minh'); 

    if(!isset($_SESSION['admin_logged'])) {
        header('location: ../account.php');
    }

    function tong_don($conn, $thoi_gian) {
        $data = 0;
        
        $thang_hien_tai = date("m");
        $thang_truoc = date("m") - 1;
        $ngay_hien_tai = date("d");
        $ngay_truoc = date("d") - 1;

        switch($thoi_gian) {
            case $ngay_hien_tai: $where = 'DAY(don_hang.created_at) = DAY(NOW())'; break;
            case $ngay_truoc: $where = 'DAY(don_hang.created_at) = DAY(NOW()) - 1'; break;
            case $thang_hien_tai: $where = 'MONTH(don_hang.created_at) = MONTH(NOW())'; break;
            case $thang_truoc: $where = 'MONTH(don_hang.created_at) = MONTH(NOW()) - 1'; break;
        }

        $sql = "SELECT COUNT(don_hang.ma_don_hang) AS TONG_DON
                FROM don_hang
                WHERE " . $where;

        $query = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query)['TONG_DON'];
        }

        return $data;
    }

    function doanh_thu($conn, $thoi_gian) {
        $data = 0;
        
        $thang_hien_tai = date("m");
        $thang_truoc = date("m") - 1;
        $ngay_hien_tai = date("d");
        $ngay_truoc = date("d") - 1;

        switch($thoi_gian) {
            case $ngay_hien_tai: $where = 'DAY(don_hang.created_at) = DAY(NOW())'; break;
            case $ngay_truoc: $where = 'DAY(don_hang.created_at) = DAY(NOW()) - 1'; break;
            case $thang_hien_tai: $where = 'MONTH(don_hang.created_at) = MONTH(NOW())'; break;
            case $thang_truoc: $where = 'MONTH(don_hang.created_at) = MONTH(NOW()) - 1'; break;
        }

        $sql = "SELECT SUM(chi_tiet_don_hang.tri_gia) AS TONG_DOANH_THU
                FROM chi_tiet_don_hang, don_hang
                WHERE don_hang.ma_don_hang = chi_tiet_don_hang.ma_don_hang AND " .$where;

        $query = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query)['TONG_DOANH_THU'];
        }

        return $data;
    }

    $tong_don_thang = tong_don($conn, date('m'));
    $tong_don_thang_truoc = tong_don($conn, date('m') - 1);
    $tong_don_ngay = tong_don($conn, date('d'));
    $tong_don_ngay_truoc = tong_don($conn, date('d') - 1);

    $doanh_thu_thang = doanh_thu($conn, date('m'));
    $doanh_thu_thang_truoc = doanh_thu($conn, date('m') - 1);
    $doanh_thu_ngay = doanh_thu($conn, date('d'));
    $doanh_thu_ngay_truoc = doanh_thu($conn, date('d') - 1);

    $tang_truong_doanh_thu_thang = ($doanh_thu_thang - $doanh_thu_thang_truoc) / 100;
    $tang_truong_doanh_thu_ngay = ($doanh_thu_ngay - $doanh_thu_ngay_truoc) / 100;
    $tang_truong_tong_don_thang = ($tong_don_thang - $tong_don_thang_truoc) / 100;
    $tang_truong_tong_don_ngay = ($tong_don_ngay - $tong_don_ngay_truoc) / 100;
    

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">


    <!-- Base CSS -->
    <link rel="stylesheet" href="./assets/css/base.css">

    <!-- Style CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">

    <!-- Responsive CSS -->
    <link rel="stylesheet" href="./assets/css/responsive.css">

    <title>ADMIN</title>
</head>
<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper">

        <!-- Layout menu -->
        <div class="layout-menu layout-menu-fixed offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">

            <!-- Logo brand -->
            <div class="app-brand">
                <a href="" class="">
                    <h5>APP BRAND</h5>
                </a>
            </div>

            <button type="button" class="btn-close-nav-mobile" data-bs-dismiss="offcanvas"><i class="fa-solid fa-angle-left"></i></button>

            <!-- Menu inner -->
            
            <ul class="menu-inner">
                <li class="menu-item active">
                    <a href="./index.php" class="menu-link active">
                        <i class="fa-solid fa-house menu-icon"></i>                        
                        <span>Trang chủ</span>              
                    </a>
                </li>

                <!-- Menu users -->

                <li class="menu-header">
                    <span>Users</span>
                </li>

                <li class="menu-item">
                    <a href="" class="menu-link menu-toggle">
                        <i class="fa-solid fa-user menu-icon"></i>                       
                        <span>Khách hàng</span>              
                    </a>

                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="./users/list.php" class="menu-link">
                                <span>Danh sách</span>              
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="./users/add.php" class="menu-link">
                                <span>Thêm</span>              
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- Menu products -->

                <li class="menu-header">
                    <span>Products</span>
                </li>

                <li class="menu-item">
                    <a href="" class="menu-link menu-toggle">
                        <i class="fa-solid fa-burger menu-icon"></i>                      
                        <span>Sản phẩm</span>              
                    </a>

                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="./products/list.php" class="menu-link">
                                <span>Danh sách</span>              
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="./products/add.php" class="menu-link">
                                <span>Thêm</span>              
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Menu orders -->

                <li class="menu-header">
                    <span>orders</span>
                </li>

                <li class="menu-item">
                    <a href="" class="menu-link menu-toggle">
                        <i class="fa-solid fa-list-check menu-icon"></i>                      
                        <span>Đơn hàng</span>              
                    </a>

                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="./orders/list.php" class="menu-link">
                                <span>Danh sách</span>              
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="./orders/add.php" class="menu-link">
                                <span>Thêm</span>              
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>

        <!-- Layout page inner -->
        <div class="layout-page">
            <!-- Page header -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <div class="page-header-left">
                                <button class="btn btn-nav-mobile" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                                    <i class="fa-solid fa-bars"></i>
                                </button>
                                <form class="form-search" role="search">
                                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    <input type="search" placeholder="Search..." aria-label="Search">
                                </form>
                            </div>

                            <div class="page-header-right">
                                <div class="profile">
                                    <button class="dropdown-btn">
                                        <img src="./assets/img/1.png" alt="avatar" class="avatar">
                                    </button>
                                    <ul class="dropdown">
                                        <li class="dropdown-item">
                                            <img src="./assets/img/1.png" alt="avatar" class="avatar">
                                            <div class="dropdown-content">
                                                <p>Thanh</p>
                                                <span>Admin</span>
                                            </div>
                                        </li>

                                        <li class="divider"></li>

                                        <li class="dropdown-item">
                                            <a href="./my-profile.php" class="dropdown-link">
                                                <i class="fa-regular fa-address-card"></i>
                                                <span>Thông tin tài khoản</span>
                                            </a>
                                        </li>

                                        <li class="dropdown-item">
                                            <a href="" class="dropdown-link">
                                                <i class="fa-regular fa-bell"></i>
                                                <span>Thông báo</span>
                                                <span class="badge bg-danger text-light float-end">3</span>
                                            </a>
                                        </li>

                                        <li class="dropdown-item">
                                            <a href="" class="dropdown-link">
                                                <i class="fa-solid fa-gear"></i>
                                                <span>Cài đặt</span>
                                            </a>
                                        </li>

                                        <li class="divider"></li>

                                        <li class="dropdown-item">
                                            <a href="../logout.php" class="dropdown-link">
                                                <i class="fa-solid fa-power-off"></i>
                                                <span>Đăng xuất</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

            <!-- Page content -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-content">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-12 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                          <div class="card-body-left">
                                            <span class="card-icon bg-danger bg-opacity-10">
                                                <i class="fa-solid fa-sack-dollar text-danger"></i>
                                            </span>
                                            <p class="card-text">Doanh thu tháng</p>
                                          </div>

                                          <div class="card-body-right">
                                            <p class="card-total"><?php echo $doanh_thu_thang ?>$</p>
                                            <?php if($tang_truong_doanh_thu_thang > 0) { ?>
                                                <p class="text-success"><i class="fa-solid fa-arrow-trend-up"></i> +<?=$tang_truong_doanh_thu_thang?>%</p>
                                            <?php } else { ?>
                                                <p class="text-danger"><i class="fa-solid fa-arrow-trend-down"></i> <?=$tang_truong_doanh_thu_thang?>%</p>
                                            <?php } ?>
                                          </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-12 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                          <div class="card-body-left">
                                            <span class="card-icon bg-success bg-opacity-10">
                                                <i class="fa-solid fa-coins text-success"></i>
                                            </span>
                                            <p class="card-text">Doanh thu ngày</p>
                                          </div>

                                          <div class="card-body-right">
                                            <p class="card-total"><?php echo $doanh_thu_ngay ?>$</p>
                                            <?php if($tang_truong_doanh_thu_ngay > 0) { ?>
                                                <p class="text-success"><i class="fa-solid fa-arrow-trend-up"></i> +<?=$tang_truong_doanh_thu_ngay?>%</p>
                                            <?php } else { ?>
                                                <p class="text-danger"><i class="fa-solid fa-arrow-trend-down"></i> <?=$tang_truong_doanh_thu_ngay?>%</p>
                                            <?php } ?>
                                          </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-12 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                          <div class="card-body-left">
                                            <span class="card-icon bg-info bg-opacity-10">
                                                <i class="fa-solid fa-bag-shopping text-info"></i>
                                            </span>
                                            <p class="card-text">Tổng đơn tháng</p>
                                          </div>

                                          <div class="card-body-right">
                                            <p class="card-total"><?php echo $tong_don_thang ?></p>
                                            <?php if($tang_truong_tong_don_thang > 0) { ?>
                                                <p class="text-success"><i class="fa-solid fa-arrow-trend-up"></i> +<?=$tang_truong_tong_don_thang?>%</p>
                                            <?php } else { ?>
                                                <p class="text-danger"><i class="fa-solid fa-arrow-trend-down"></i> <?=$tang_truong_tong_don_thang?>%</p>
                                            <?php } ?>
                                          </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-12 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                          <div class="card-body-left">
                                            <span class="card-icon bg-warning bg-opacity-10">
                                                <i class="fa-solid fa-burger text-warning"></i>
                                            </span>
                                            <p class="card-text">Tổng đơn ngày</p>
                                          </div>

                                          <div class="card-body-right">
                                            <p class="card-total"><?php echo $tong_don_ngay ?></p>
                                            <?php if($tang_truong_tong_don_ngay > 0) { ?>
                                                <p class="text-success"><i class="fa-solid fa-arrow-trend-up"></i> +<?=$tang_truong_tong_don_ngay?>%</p>
                                            <?php } else { ?>
                                                <p class="text-danger"><i class="fa-solid fa-arrow-trend-down"></i> <?=$tang_truong_tong_don_ngay?>%</p>
                                            <?php } ?>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery 3.6.3 -->
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script src="./assets/js/main.js"></script>

</body>
</html>