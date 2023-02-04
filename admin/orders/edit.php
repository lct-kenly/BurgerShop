<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'burger-shop') or die('Couldn\'t connect to Database');

    session_start();
    date_default_timezone_set('Asia/Ho_Chi_Minh'); 
    $date_current = '';
    $date_current = date("Y-m-d H:i:s");

    if(!isset($_SESSION['admin_logged'])) {
        header('location: ../../account.php');
    }

    $ma_don_hang = isset($_GET['id']) ? $_GET['id'] : '';
 
    if(!(empty($ma_don_hang))) {
        $san_pham_don_hang = array();
        $don_hang = array();
        $sum = 0;

        // select danh sách sản phẩm trong đơn hàng
        $sql = "SELECT san_pham.id, san_pham.ten_san_pham, chi_tiet_don_hang.so_luong, chi_tiet_don_hang.don_gia, chi_tiet_don_hang.tri_gia
                FROM san_pham, chi_tiet_don_hang
                WHERE san_pham.id = chi_tiet_don_hang.id_san_pham AND chi_tiet_don_hang.ma_don_hang = {$ma_don_hang}";
        $query = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($query)) {
            $san_pham_don_hang[] = $row;
            $sum += $row['tri_gia'];
        }

        // select thông tin khách hàng
        $sql = "SELECT khach_hang.ho_ten, khach_hang.email, khach_hang.so_dien_thoai, don_hang.ma_don_hang, don_hang.created_at, don_hang.trang_thai, don_hang.thanh_toan, don_hang.id_khach_hang
                FROM khach_hang, don_hang
                WHERE khach_hang.id = don_hang.id_khach_hang AND don_hang.ma_don_hang={$ma_don_hang}";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0) {
            $don_hang = mysqli_fetch_assoc($query);
        }

        $trang_thai['id'] = $don_hang['trang_thai'];

        switch($trang_thai['id']) {
            case 0: {$trang_thai['name'] = "Đơn hàng đang xử lý"; $trang_thai['update'] = "Xác nhận đơn hàng"; }; break;
            case 1: {$trang_thai['name'] = "Đơn hàng đã được xác nhận"; $trang_thai['update'] = "Xác nhận đơn hàng đã giao đơn vị vận chuyển";}; break;
            case 2: {$trang_thai['name'] = "Đơn hàng đã giao cho đơn vị vận chuyển"; $trang_thai['update'] = "Xác nhận giao hàng thành công";}; break;
            case 3: {$trang_thai['name'] = "Giao hàng thành công"; $trang_thai['update'] = "Giao hàng thành công";}; break;
            default: $trang_thai['name'] = "Đơn hàng đã hủy"; break;
        }

        if(isset($_GET['state'])) {

            switch($_GET['state']) {
                case 0: $state = 1; break;
                case 1: $state = 2; break;
                case 2: $state = 3; break;
                case 3: $state = 3; break;
                case 4: $state = 4; break;
                default: $state = 3; break;
            }

            $sql = "UPDATE don_hang SET trang_thai={$state}, updated_at='{$date_current}' WHERE ma_don_hang={$ma_don_hang} AND id_khach_hang={$don_hang['id_khach_hang']}";
            $query = mysqli_query($conn, $sql);
            if($query) {
                echo "<script>
                            alert('Cập nhật trạng thái đơn hàng thành công!');
                            window.location.href = 'list.php';
                        </script>";
            } else {
                echo "<script>
                            alert('Có lỗi trong quá trình xử lý, vui lòng thử lại!');
                            window.location.href = 'list.php';
                        </script>";
            }
        } 

    }
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
    <link rel="stylesheet" href="../assets/css/base.css">

    <!-- Style CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- Responsive CSS -->
    <link rel="stylesheet" href="../assets/css/responsive.css">

    <title>ADMIN</title>
</head>
<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper">

        <!-- Layout menu -->
        <div class="layout-menu layout-menu-fixed offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">

            <!-- Logo brand -->
            <div class="app-brand">
                <a href="../index.php" class="">
                    <h5>APP BRAND</h5>
                </a>
            </div>

            <!-- Menu inner -->
            
            <ul class="menu-inner">
                <li class="menu-item">
                    <a href="../index.php" class="menu-link">
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
                            <a href="./list.php" class="menu-link">
                                <span>Danh sách</span>              
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="./add.php" class="menu-link">
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
                            <a href="../products/list.php" class="menu-link">
                                <span>Danh sách</span>              
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="../products/add.php" class="menu-link">
                                <span>Thêm</span>              
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Menu orders -->

                <li class="menu-header">
                    <span>orders</span>
                </li>

                <li class="menu-item active">
                    <a href="" class="menu-link menu-toggle active">
                        <i class="fa-solid fa-list-check menu-icon"></i>                      
                        <span>Đơn hàng</span>              
                    </a>

                    <ul class="menu-sub open">
                        <li class="menu-item">
                            <a href="../orders/list.php" class="menu-link">
                                <span>Danh sách</span>              
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="../orders/add.php" class="menu-link">
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
                                        <img src="../assets/img/1.png" alt="avatar" class="avatar">
                                    </button>
                                    <ul class="dropdown">
                                        <li class="dropdown-item">
                                            <img src="../assets/img/1.png" alt="avatar" class="avatar">
                                            <div class="dropdown-content">
                                                <p>Thanh</p>
                                                <span>Admin</span>
                                            </div>
                                        </li>

                                        <li class="divider"></li>

                                        <li class="dropdown-item">
                                            <a href="../my-profile.php" class="dropdown-link">
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
                                            <a href="../../logout.php" class="dropdown-link">
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
                <!-- <div class="row mt-4">
                    <div class="col-md-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb ms-4">
                                <li class="breadcrumb-item"><a href="../index.php" class="text-decoration-none fs-5">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="./add.php" class="text-decoration-none fs-5">Khách hàng</a></li>
                                <li class="breadcrumb-item active fs-5" aria-current="page">Thêm tài khoản</li>
                            </ol>
                        </nav>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-content bg-white rounded-3 p-4">
                            <div class="">
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="w-50 fw-bold">Khách hàng: <?php echo $don_hang['ho_ten']?></p>
                                    <p class="w-50 fw-bold">Mã đơn hàng: <?php echo $don_hang['ma_don_hang']?></p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="w-50 fw-bold">Ngày lập: <?php echo $don_hang['created_at']?></p>
                                    <p class="w-50 fw-bold">Trạng thái: <?php echo $trang_thai['name']?></p>
                                
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="w-50 fw-bold">Hình thức thanh toán: <?php echo $don_hang['thanh_toan']?></p>
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Mã sản phẩm</th>
                                        <th scope="col">Tên sản phẩm</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Đơn giá</th>
                                        <th scope="col">Trị giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($san_pham_don_hang as $item) { ?>
                                        <tr>
                                            <td><?=$item['id']?></td>
                                            <td><?=$item['ten_san_pham']?></td>
                                            <td><?=$item['so_luong']?></td>
                                            <td>$<?=$item['don_gia']?></td>
                                            <td>$<?=$item['tri_gia']?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="5" class="text-center fw-bold">Tổng cộng: $<?=$sum?></td>
                                    </tr>
                                </tbody>
                            </table>

                            <div>
                                <a href="mailto:<?=$don_hang['email']?>" class="btn btn-outline-success me-2"><i class="fa-regular fa-envelope me-2"></i> Liên hệ khách hàng</a>
                                <a href="tel:<?=$don_hang['so_dien_thoai']?>" class="btn btn-outline-success me-2"><i class="fa-solid fa-phone-volume me-2"></i> Liên hệ khách hàng</a>
                                <a href="edit.php?id=<?=$ma_don_hang?>&state=<?=$don_hang['trang_thai']?>" class="btn btn-outline-success me-2"><i class="fa-solid fa-repeat me-2"></i><?=$trang_thai['update']?></a>
                                <a href="edit.php?id=<?=$ma_don_hang?>&state=4" class="btn btn-outline-danger me-2"><i class="fa-solid fa-trash me-2"></i>Hủy đơn hàng</a>
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

    <script src="../assets/js/main.js"></script>

    <script>
        const inputFile = document.querySelector('input[name="avatar"]');
        const gridImg = document.querySelector('.grid-img');

        uploadFile(inputFile, gridImg);
    </script>

</body>
</html>