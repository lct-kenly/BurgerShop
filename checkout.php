<?php
    $conn = mysqli_connect('localhost', 'root', '', 'burger-shop') or die('Couldn\'t connect to Database');

    $error = array();
    session_start();
    $sanpham_giohang = array();


    if(isset($_SESSION['user_logged'])) {
        $user = $_SESSION['user_logged'];

        include('./libs/helper.php');

        $countID_cart = get_count_cart($conn, $user['id']) ?? 0;

        $sql = "SELECT san_pham.id, san_pham.ten_san_pham, san_pham.don_gia_ban, gio_hang.so_luong, SUM(gio_hang.so_luong * san_pham.don_gia_ban) AS tri_gia 
                FROM gio_hang, san_pham 
                WHERE gio_hang.id_san_pham = san_pham.id AND gio_hang.id_khach_hang = {$user['id']}
                GROUP BY san_pham.id";
        
        $query = mysqli_query($conn, $sql);
        $sum = 0;
        $count = 0;
        while($row = mysqli_fetch_assoc($query)) {
            $sanpham_giohang[] = $row;
            $sum += $row['tri_gia'];
        }

        $count = count($sanpham_giohang);


        $sql = "SELECT * FROM khach_hang WHERE id = {$user['id']}";
        $query = mysqli_query($conn, $sql);
        $khach_hang = mysqli_fetch_assoc($query);


        // Kiểm tra thông tin đặt hàng
        if(isset($_POST['submit']) && $_POST['submit'] == 'submit') {
            $ho_ten = isset($_POST['ho_ten']) ? addslashes($_POST['ho_ten']) : '';
            $email = isset($_POST['email']) ? addslashes($_POST['email']) : '';
            $so_dien_thoai = isset($_POST['so_dien_thoai']) ? addslashes($_POST['so_dien_thoai']) : '';
            $dia_chi = isset($_POST['dia_chi']) ? addslashes($_POST['dia_chi']) : '';
            $thanh_toan = isset($_POST['thanh_toan']) ? addslashes($_POST['thanh_toan']) : '';

            if(empty($ho_ten)) {
                $error['ho_ten'] = 'Vui lòng nhập trường này!';
            }

            if(empty($email)) {
                $error['email'] = 'Vui lòng nhập trường này!';
            }

            if(empty($so_dien_thoai)) {
                $error['so_dien_thoai'] = 'Vui lòng nhập trường này!';
            }

            if(empty($dia_chi)) {
                $error['dia_chi'] = 'Vui lòng nhập trường này!';
            }

            if(empty($thanh_toan)) {
                $error['thanh_toan'] = 'Bạn chưa chọn hình thức thanh toán!';
            }

            if(!($error)) {
                $data = array(
                    'ho_ten' => $ho_ten,
                    'email' => $email,
                    'so_dien_thoai' => $so_dien_thoai,
                    'dia_chi' => $dia_chi,
                );

                $newData = array_diff($data, $khach_hang);

                if(isset($newData['email'])) {
                    $sql = "SELECT email FROM khach_hang WHERE email='{$newData['email']}'";
                    $query = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($query) > 0) {
                        $error['email'] = 'Email đã được tài khoản khác sử dụng!';
                    }
                }

                if(isset($newData['so_dien_thoai'])) {
                    $sql = "SELECT so_dien_thoai FROM khach_hang WHERE so_dien_thoai='{$newData['so_dien_thoai']}'";
                    $query = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($query) > 0) {
                        $error['so_dien_thoai'] = 'Số điện thoại đã được tài khoản khác sử dụng!';
                    }
                }

                if(!($error) && !(empty($sanpham_giohang))) {

                    if(!(empty($newData))) {
                        $sql = '';
                        foreach($newData as $key => $val) {
                            $sql .= "'" . $key . "'='" . $val . "',";
                        }

                        $sql = trim($sql, ',');

                        $newSql = "UPDATE khach_hang SET $sql WHERE id={$user['id']}";
                        $query = mysqli_query($conn, $newSql);

                        if($query) {
                            header('location: insert-checkout.php?httt='.$thanh_toan);
                        } else {
                            echo "<script>
                                    alert('Có lỗi xảy ra, vui lòng thử lại!');
                                </script>";
                        }
                    } else {
                        header('location: insert-checkout.php?httt='.$thanh_toan);
                    }

                } else {
                    echo "<script>
                        alert('Vui lòng thêm sản phẩm vào giỏ hàng của bạn!');
                        window.location.href = './index.php';
                    </script>";
                }
            }
        }

    } else {
        echo "<script>
                alert('Vui lòng đăng nhập để tiếp tục!');
                window.location.href = './login.php';
            </script>";
    }
?>
<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="images/favicon.png" type="">

    <title> Feane </title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

    <!--owl slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <!-- nice select  -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css"
        integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ=="
        crossorigin="anonymous" />
    <!-- font awesome style -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="css/responsive.css" rel="stylesheet" />

</head>

<body class="sub_page">

    <div class="hero_area">
        <div class="bg-box">
            <img src="images/hero-bg.jpg" alt="">
        </div>
        <!-- header section strats -->
        <header class="header_section">
            <div class="container">
                <nav class="navbar navbar-expand-lg custom_nav-container ">
                    <a class="navbar-brand" href="index.php">
                        <span>
                            Feane
                        </span>
                    </a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class=""> </span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav  mx-auto ">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="menu.php">Menu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="about.php">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="about.php">Cart</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="book.php">Book Table <span class="sr-only">(current)</span>
                                </a>
                            </li>
                        </ul>
                        <div class="user_option">
                            <a class="cart_link" href="#">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span>3</span>
                            </a>

                            <div class="btn  my-2 my-sm-0 nav_search-btn" type="submit">
                                <span><i class="fa fa-search" aria-hidden="true"></i></span>
                                <form action="" class="form-search">
                                    <div class="form-search-header">
                                        <input class="form-control mr-sm-2" type="search" placeholder="Search..."
                                            aria-label="Search">
                                        <button class="btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                    <div class="form-search-body">
                                        <p>Lịch sử tìm kiếm</p>
                                        <ul class="list-group">
                                            <li class="list-group-item"><a href="">Cras justo odio</a></li>
                                        </ul>
                                    </div>
                                </form>
                            </div>

                            <a href="account.php" class="user_link">
                                <i class="fa fa-user mr-2" aria-hidden="true"></i>
                                Đăng nhập
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <!-- end header section -->
    </div>

    <!-- book section -->
    <section class="book_section layout_padding">
        <div class="container">
            <div class="heading_container">
                <h2>
                    Book A Table
                </h2>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="form_container">
                        <form id="form-checkout" method="POST" action="">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" class="form-control mr-2" name="ho_ten" placeholder="Your Name" 
                                        value="<?php echo isset($khach_hang['ho_ten']) ? $khach_hang['ho_ten'] : ''; ?>" />

                                    <p class="form-text ml-3 text-danger"><?php echo !(empty($error['ho_ten'])) ? $error['ho_ten'] : ''; ?></p>
                                </div>

                                <div class="col-md-6 form-group">
                                    <input type="text" class="form-control mr-2" name="email" placeholder="Your Email" 
                                        value="<?php echo isset($khach_hang['email']) ? $khach_hang['email'] : ''; ?>" />

                                    <p class="form-text ml-3 text-danger"><?php echo !(empty($error['email'])) ? $error['email'] : ''; ?></p>
                                </div>

                                <div class="col-md-6 form-group">
                                    <input type="text" class="form-control mr-2" name="so_dien_thoai" placeholder="Your Phone Number" 
                                        value="<?php echo isset($khach_hang['so_dien_thoai']) ? $khach_hang['so_dien_thoai'] : ''; ?>" />

                                    <p class="form-text ml-3 text-danger"><?php echo !(empty($error['so_dien_thoai'])) ? $error['so_dien_thoai'] : ''; ?></p>
                                </div>

                                <div class="col-md-6 form-group">
                                    <input type="text" class="form-control mr-2" name="dia_chi" placeholder="Your Address" 
                                        value="<?php echo isset($khach_hang['dia_chi']) ? $khach_hang['dia_chi'] : ''; ?>" />

                                    <p class="form-text ml-3 text-danger"><?php echo !(empty($error['dia_chi'])) ? $error['dia_chi'] : ''; ?></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-5">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th class="" scope="col">
                                    <h4 style="font-weight: bold">Đơn hàng</h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <h5 class="mb-4">Sản phẩm</h5>
                                    <div>
                                        <?php foreach($sanpham_giohang as $item) { ?>
                                            <p class="mb-0"><?=$item['ten_san_pham']?></p>
                                            <div class="d-flex justify-content-between">
                                                <p>x <?=$item['so_luong']?></p>
                                                <p>$ <?=$item['don_gia_ban']?></p>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <p>Tổng số tiền (<?=$count?> sản phẩm)</p>
                                        <p>$<?=$sum?></p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p>Phí vận chuyển</p>
                                        <p>$15</p>
                                    </div>
                                </td>
                            </tr>
                            <tr class="bg-dark">
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <h5 class="text-white" style="font-weight: bold">Tổng cộng: </h5>
                                        <h5 class="text-white" style="font-weight: bold">$<?=$sum + 15?></h5>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th class="" scope="col">
                                    <h5 style="font-weight: bold">Thanh toán</h5>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input custom-input-control" type="radio" name="thanh_toan" form="form-checkout" id="exampleRadios1" value="Thanh-toan-khi-nhan-hang" checked>
                                        <label class="form-check-label custom-label-control" for="exampleRadios1">
                                            Thanh toán khi nhận hàng
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input custom-input-control" type="radio" name="thanh_toan" form="form-checkout" id="exampleRadios2" value="Thanh-toan-momo">
                                        <label class="form-check-label custom-label-control" for="exampleRadios2">
                                            Thanh toán qua momo
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input custom-input-control" type="radio" name="thanh_toan" form="form-checkout" id="exampleRadios3" value="Chuyen-khoan-ngan-hang">
                                        <label class="form-check-label custom-label-control" for="exampleRadios3">
                                            Chuyển khoản ngân hàng
                                        </label>
                                    </div>
                                    <p class="form-text ml-3 text-danger"><?php echo !(empty($error['thanh_toan'])) ? $error['thanh_toan'] : ''; ?></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" name="submit" value="submit" form="form-checkout" class="btn btn-primary w-100 py-2">Proceed To Checkout</button>
                </div>
            </div>
        </div>
    </section>
    <!-- end book section -->

    <!-- footer section -->
    <footer class="footer_section">
        <div class="container">
            <div class="row">
                <div class="col-md-4 footer-col">
                    <div class="footer_contact">
                        <h4>
                            Contact Us
                        </h4>
                        <div class="contact_link_box">
                            <a href="">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <span>
                                    Location
                                </span>
                            </a>
                            <a href="">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <span>
                                    Call +01 1234567890
                                </span>
                            </a>
                            <a href="">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <span>
                                    demo@gmail.com
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 footer-col">
                    <div class="footer_detail">
                        <a href="" class="footer-logo">
                            Feane
                        </a>
                        <p>
                            Necessary, making this the first true generator on the Internet. It uses a dictionary of
                            over 200 Latin words, combined with
                        </p>
                        <div class="footer_social">
                            <a href="">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-linkedin" aria-hidden="true"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-pinterest" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 footer-col">
                    <h4>
                        Opening Hours
                    </h4>
                    <p>
                        Everyday
                    </p>
                    <p>
                        10.00 Am -10.00 Pm
                    </p>
                </div>
            </div>
            <div class="footer-info">
                <p>
                    &copy; <span id="displayYear"></span>
                    <a href="https://html.design/"></a><br><br>
                    &copy; <span id="displayYear"></span>
                    <a href="https://themewagon.com/" target="_blank"></a>
                </p>
            </div>
        </div>
    </footer>
    <!-- footer section -->

    <!-- jQery -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <!-- popper js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
        </script>
    <!-- bootstrap js -->
    <script src="js/bootstrap.js"></script>
    <!-- owl slider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
    </script>
    <!-- isotope js -->
    <script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
    <!-- nice select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
    <!-- custom js -->
    <script src="js/custom.js"></script>
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
    </script>
    <!-- End Google Map -->

</body>

</html>