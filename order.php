<?php
    $conn = mysqli_connect('localhost', 'root', '', 'burger-shop') or die('Couldn\'t connect to Database');

    $error = array();
    session_start();
    $donhang = array();
    $sanpham_donhang = array();


    if(isset($_SESSION['user_logged'])) {
        $user = $_SESSION['user_logged'];

        include('./libs/helper.php');

        $countID_cart = get_count_cart($conn, $user['id']) ?? 0;


        function get_don_hang($conn, $id_user, $trang_thai) {
            $donhang = array();

            if(isset($trang_thai) && $trang_thai == "All") {
                $sql = "SELECT don_hang.ma_don_hang, don_hang.trang_thai
                FROM don_hang
                WHERE don_hang.id_khach_hang = {$id_user}
                ORDER BY don_hang.created_at desc";
                $query = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($query)) {
                    $donhang[] = $row;
                }
            } else {
                $sql = "SELECT don_hang.ma_don_hang, don_hang.trang_thai
                FROM don_hang
                WHERE don_hang.id_khach_hang = {$id_user} AND don_hang.trang_thai = {$trang_thai}
                ORDER BY don_hang.created_at desc";
                $query = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($query)) {
                    $donhang[] = $row;
                }
            }

            return $donhang;
        }

        function get_san_pham($id_don_hang, $conn) {
            $san_pham = array();
            $sql = "SELECT san_pham.ten_san_pham, san_pham.hinh_anh, chi_tiet_don_hang.so_luong, chi_tiet_don_hang.don_gia, chi_tiet_don_hang.tri_gia
                    FROM san_pham, chi_tiet_don_hang
                    WHERE san_pham.id = chi_tiet_don_hang.id_san_pham AND chi_tiet_don_hang.ma_don_hang={$id_don_hang}";
            $query = mysqli_query($conn, $sql);

            while($row = mysqli_fetch_assoc($query)) {
                $san_pham[] = $row;
            }

            return $san_pham;
        }

        function get_state($state) {
          $trang_thai['id'] = $state;
  
          switch($trang_thai['id']) {
              case 0: $trang_thai['name'] = "Đơn hàng đang xử lý"; break;
              case 1: $trang_thai['name'] = "Đơn hàng đã được xác nhận"; break;
              case 2: $trang_thai['name'] = "Đang giao hàng"; break;
              case 3: $trang_thai['name'] = "Giao hàng thành công"; break;
              default: $trang_thai['name'] = "ĐÃ HỦY"; break;
          }
  
          return $trang_thai['name'];
      }

    } else {
        echo "<script>
                alert('Vui lòng đăng nhập để tiếp tục!');
                window.location.href = './account.php';
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
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <!-- nice select  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ==" crossorigin="anonymous" />
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

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                <a class="nav-link" href="book.php">Book Table <span class="sr-only">(current)</span> </a>
              </li>
            </ul>
            <div class="user_option">
              <a class="cart_link" href="./cart.php">
                <i class="fa-solid fa-cart-shopping"></i>
                <span><?php echo $countID_cart ?? 0;?></span>
              </a>

              <div class="btn  my-2 my-sm-0 nav_search-btn" type="submit">
                <span><i class="fa fa-search" aria-hidden="true"></i></span>
                <form action="" class="form-search">
                  <div class="form-search-header">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search..." aria-label="Search">
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
              
              <?php if(isset($user)) { ?>
                <div class="grid-logged">
                  <button class="user_logged btn-show-nav-sub" type="button">
                      <img src="<?php echo !empty($user['avatar']) ? './storage/uploads/'.$user['avatar'] : './images/avatar-.jpg'?>" alt="">
                      <span><?=$user['ten_tai_khoan']?></span>
                    </button>
                    <ul class="nav-sub-logged">
                        <li>
                          <img src="<?php echo !empty($user['avatar']) ? './storage/uploads/'.$user['avatar'] : './images/avatar-.jpg'?>" alt="">
                          <span><?=$user['ten_tai_khoan']?></span>
                        </li>
                        <li class="divider"></li>
                        <li>
                          <a href="./profile.php"><i class="fa-regular fa-user"></i> Thông tin tài khoản</a>
                        </li>
                        <li>
                          <a href="./order.php"><i class="fa-solid fa-list-check"></i> Đơn hàng của bạn</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                          <a href="./logout.php"><i class="fa-solid fa-power-off"></i> Đăng xuất</a>
                        </li>
                    </ul>
                </div>
              <?php } else { ?>
                <a href="account.php" class="user_link">
                  <i class="fa fa-user mr-2" aria-hidden="true"></i>
                  Đăng nhập
                </a>
              <?php } ?>
              </a>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>

  <!-- book section -->
  <section class="book_section layout_padding" style="background-color: #f5f5f5;">
    <div class="container">
      <!-- <div class="heading_container mb-5">
        <h2 class="text-center w-100">
          SHOPPING CART
        </h2>
      </div> -->
      <div class="row">
        <div class="col-md-12">
          <ul class="tab-list">
              <li class="tab-item active">
                <a href="#" data-id="#Tat-ca">Tất cả</a>
              </li>
              <li class="tab-item">
                <a href="#" data-id="#Cho-xac-nhan">Chờ xác nhận</a>
              </li>
              <li class="tab-item">
                <a href="#" data-id="#Dang-giao-hang">Đang giao hàng</a>
              </li>
              <li class="tab-item">
                <a href="#" data-id="#Hoan-thanh">Hoàn thành</a>
              </li>
              <li class="tab-item">
                <a href="#" data-id="#Da-huy">Đã hủy</a>
              </li>
            </ul>
            <div class="tab-content active" id="Tat-ca">
                <?php $donhang = get_don_hang($conn, $user['id'], "All") ?>
                <?php foreach($donhang as $item ) { 
                    $sanpham_donhang = get_san_pham($item['ma_don_hang'], $conn);
                    $sum = 0;
                    $state = get_state($item['trang_thai']);
                ?>
                    <div class="card mb-5">
                        <div class="card-header d-flex align-items-center justify-content-between bg-white">
                            <p class="mb-0 font-weight-bold">
                                Mã đơn hàng: <?=$item['ma_don_hang']?> 
                            </p>
                            <p class="mb-0 text-<?=$item['trang_thai'] == 4 ? 'danger' : 'success'; ?>"><i class="fa-solid fa-truck-moving mr-2"></i> <?=$state?></p>
                        </div>
                        <div class="card-body">
                            <?php foreach($sanpham_donhang as $value) {
                                $sum += $value['tri_gia'];
                            ?>
                                <div class="d-flex align-items-center mt-4">
                                    <div><img src="./storage/uploads/<?=$value['hinh_anh']?>" alt="" style="width: 80px; height: 80px;"></div>
                                    <div class="ml-3 w-100">
                                        <p><?=$value['ten_san_pham']?></p>
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <p>x <?=$value['so_luong']?></p>
                                            <p>$<?=$value['don_gia']?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card-footer bg-white">
                            <p class="text-right font-weight-bold mb-0">Tổng cộng: $<?=$sum?> </p>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="tab-content" id="Cho-xac-nhan">
                <?php $donhang = get_don_hang($conn, $user['id'], "0") ?>
                <?php foreach($donhang as $item ) { 
                    $sanpham_donhang = get_san_pham($item['ma_don_hang'], $conn);
                    $sum = 0;
                    $state = get_state($item['trang_thai']);
                ?>
                    <div class="card mb-5">
                        <div class="card-header d-flex align-items-center justify-content-between bg-white">
                            <p class="mb-0 font-weight-bold">
                                Mã đơn hàng: <?=$item['ma_don_hang']?>
                            </p>
                            <p class="mb-0 text-success">
                                <i class="fa-solid fa-truck-moving mr-2"></i> <?=$state?>
                            </p>
                        </div>
                        <div class="card-body">
                            <?php foreach($sanpham_donhang as $value) {
                                $sum += $value['tri_gia'];
                            ?>
                                <div class="d-flex align-items-center mt-4">
                                    <div><img src="./storage/uploads/<?=$value['hinh_anh']?>" alt="" style="width: 80px; height: 80px;"></div>
                                    <div class="ml-3 w-100">
                                        <p><?=$value['ten_san_pham']?></p>
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <p>x <?=$value['so_luong']?></p>
                                            <p>$<?=$value['don_gia']?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between bg-white">
                            <button class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#exampleModal" data-id="<?=$item['ma_don_hang']?>">
                                Hủy đơn
                            </button> 
                            <p class="text-right font-weight-bold mb-0">Tổng cộng: $<?=$sum?> </p>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="tab-content" id="Dang-giao-hang">
                <?php $donhang = get_don_hang($conn, $user['id'], 2) ?>
                <?php foreach($donhang as $item ) { 
                    $sanpham_donhang = get_san_pham($item['ma_don_hang'], $conn);
                    $sum = 0;
                    $state = get_state($item['trang_thai']);
                ?>
                    <div class="card mb-5">
                        <div class="card-header d-flex align-items-center justify-content-between bg-white">
                            <p class="mb-0 font-weight-bold">Mã đơn hàng: <?=$item['ma_don_hang']?></p>
                            <p class="mb-0 text-success"><i class="fa-solid fa-truck-moving mr-2"></i> <?=$state?></p>
                        </div>
                        <div class="card-body">
                            <?php foreach($sanpham_donhang as $value) {
                                $sum += $value['tri_gia'];
                            ?>
                                <div class="d-flex align-items-center mt-4">
                                    <div><img src="./storage/uploads/<?=$value['hinh_anh']?>" alt="" style="width: 80px; height: 80px;"></div>
                                    <div class="ml-3 w-100">
                                        <p><?=$value['ten_san_pham']?></p>
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <p>x <?=$value['so_luong']?></p>
                                            <p>$<?=$value['don_gia']?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card-footer bg-white">
                            <p class="text-right font-weight-bold mb-0">Tổng cộng: $<?=$sum?> </p>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="tab-content" id="Hoan-thanh">
            <?php $donhang = get_don_hang($conn, $user['id'], 3) ?>
                <?php foreach($donhang as $item ) { 
                    $sanpham_donhang = get_san_pham($item['ma_don_hang'], $conn);
                    $sum = 0;
                    $state = get_state($item['trang_thai']);
                ?>
                    <div class="card mb-5">
                        <div class="card-header d-flex align-items-center justify-content-between bg-white">
                            <p class="mb-0 font-weight-bold">Mã đơn hàng: <?=$item['ma_don_hang']?></p>
                            <p class="mb-0 text-success"><i class="fa-solid fa-truck-moving mr-2"></i> <?=$state?></p>
                        </div>
                        <div class="card-body">
                            <?php foreach($sanpham_donhang as $value) {
                                $sum += $value['tri_gia'];
                            ?>
                                <div class="d-flex align-items-center mt-4">
                                    <div><img src="./storage/uploads/<?=$value['hinh_anh']?>" alt="" style="width: 80px; height: 80px;"></div>
                                    <div class="ml-3 w-100">
                                        <p><?=$value['ten_san_pham']?></p>
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <p>x <?=$value['so_luong']?></p>
                                            <p>$<?=$value['don_gia']?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card-footer bg-white">
                            <p class="text-right font-weight-bold mb-0">Tổng cộng: $<?=$sum?> </p>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="tab-content" id="Da-huy">
                <?php $donhang = get_don_hang($conn, $user['id'], 4) ?>
                <?php foreach($donhang as $item ) { 
                    $sanpham_donhang = get_san_pham($item['ma_don_hang'], $conn);
                    $sum = 0;
                    $state = get_state($item['trang_thai']);
                ?>
                    <div class="card mb-5">
                        <div class="card-header d-flex align-items-center justify-content-between bg-white">
                            <p class="mb-0 font-weight-bold">Mã đơn hàng: <?=$item['ma_don_hang']?></p>
                            <p class="mb-0 text-danger"><?=$state?></p>
                        </div>
                        <div class="card-body">
                            <?php foreach($sanpham_donhang as $value) {
                                $sum += $value['tri_gia'];
                            ?>
                                <div class="d-flex align-items-center mt-4">
                                    <div><img src="./storage/uploads/<?=$value['hinh_anh']?>" alt="" style="width: 80px; height: 80px;"></div>
                                    <div class="ml-3 w-100">
                                        <p><?=$value['ten_san_pham']?></p>
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <p>x <?=$value['so_luong']?></p>
                                            <p>$<?=$value['don_gia']?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card-footer bg-white">
                            <p class="text-right font-weight-bold mb-0">Tổng cộng: $<?=$sum?> </p>
                        </div>
                    </div>
                <?php } ?>
            </div>
                
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
              Necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with
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

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">Hủy đơn hàng</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn chắc chắn muốn hủy đơn hàng này?
                </div>
                <div class="modal-footer">
                    <a class="btn btn-danger text-white btn-delete-order">Xác nhận</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                </div>
            </div>
        </div>
    </div>

  <!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
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

  <script>
        document.addEventListener("DOMContentLoaded", function() {
            let maDonHang;
            const btnDelete = document.querySelector('.btn-delete-order');
            const exampleModal = document.getElementById('exampleModal')
            exampleModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                
                maDonHang = button.getAttribute('data-id');

                btnDelete.setAttribute('href', `./update-order.php?id=${maDonHang}&state=4`);
            });
        })

        $(document).ready(function() {
            let maDonHang;
            const btnDelete = $('.btn-delete-order');
            const exampleModal = $('#exampleModal');

              $('#exampleModal').on('show.bs.modal', function (event) {
                  var button = $(event.relatedTarget);
                  var maDonHang = button.data('id');
                  
                  $(btnDelete).attr('href', './update-order.php?id=' + maDonHang + '&state=4');
              });
        });
    </script>

</body>

</html>