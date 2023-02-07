<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'burger-shop') or die('Couldn\'t connect to Database');

    include('./libs/mail/sendmail.php');
    $mail = new Mailler;

    $error = array();
    session_start();
    date_default_timezone_set('Asia/Ho_Chi_Minh');

    if(isset($_SESSION['user_logged'])) {
        $user = $_SESSION['user_logged'];

        include('./libs/helper.php');

        $countID_cart = get_count_cart($conn, $user['id']) ?? 0;

    }

    if(isset($_POST['submit']) && $_POST['submit'] == 'submit') {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $person = isset($_POST['person']) ? $_POST['person'] : '';
        $date = isset($_POST['date-order']) ? date_format(date_create($_POST['date-order']), 'Y-m-d') : '';

        if(empty($name)) {
          $error['name'] = 'Bạn chưa nhập họ tên';
        }

        if(empty($email)) {
          $error['email'] = 'Bạn chưa nhập email';
        }

        if(empty($phone)) {
          $error['phone'] = 'Bạn chưa nhập số điện thoại';
        }

        if(empty($person)) {
          $error['person'] = 'Bạn chưa chọn số người';
        }

        if(empty($date)) {
          $error['date'] = 'Bạn chưa chọn ngày';
        }

        if(!($error)) {
          $sql = "INSERT INTO `dat_ban`(`ten_khach_hang`, `so_dien_thoai`, `email`, `so_nguoi`, `ngay_dat`) 
                  VALUES ('{$name}','{$phone}','{$email}', {$person} ,'{$date}')";

          $query = mysqli_query($conn, $sql);

          if($query) {
              $data = array(
                'fullname' => $name,
                'email' => $email,
                'phone' => $phone,
                'person' => $person,
                'date' => $date,
              );
              $mail->sendmail($data);

              echo "<script>
                        alert('Đặt bàn thành công, chúng tôi sẽ liên hệ bạn trong thời gian sớm nhất!');
                        window.location.href = './index.php';
                    </script>";

          } else {
              echo "<script>
                        alert('Có lỗi trong quá trình xử lý, vui lòng thử lại!');
                    </script>";
          }
        } else {
          echo "<script>
          alert('Có lỗi trong quá trình xử lý, vui lòng thử lại!');
      </script>";
        }
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
                <a class="nav-link" href="cart.php">Cart</a>
              </li>
              <li class="nav-item active">
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
                <!-- <form action="" class="form-search">
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
                </form> -->
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
                          <a href="./profile.php"><i class="fa-regular fa-user"></i> My Profile</a>
                        </li>
                        <li>
                          <a href="./order.php"><i class="fa-solid fa-list-check"></i> My Purchase Order</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                          <a href="./logout.php"><i class="fa-solid fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </div>
              <?php } else { ?>
                <a href="account.php" class="user_link">
                  <i class="fa fa-user mr-2" aria-hidden="true"></i>
                  Login
                </a>
              <?php } ?>
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
        <div class="col-md-6">
          <div class="form_container">
            <form method="POST" action="">
              <div class="mb-4">
                <input type="text" class="form-control mb-0" name="name" placeholder="Your Name" value="<?php echo !empty($user['ho_ten']) ? $user['ho_ten'] : ''; ?>"/>
                <span class="form-text ml-4 text-danger"><?php echo isset($error['name']) ? $error['name'] : ''; ?></span>
              </div>
              <div class="mb-4">
                <input type="text" class="form-control mb-0" name="phone" placeholder="Phone Number" value="<?php echo !empty($user['so_dien_thoai']) ? $user['so_dien_thoai'] : ''; ?>"/>
                <span class="form-text ml-4 text-danger"><?php echo isset($error['phone']) ? $error['phone'] : ''; ?></span>
              </div>
              <div class="mb-4">
                <input type="email" class="form-control mb-0" name="email" placeholder="Your Email" value="<?php echo !empty($user['email']) ? $user['email'] : ''; ?>"/>
                <span class="form-text ml-4 text-danger"><?php echo isset($error['name']) ? $error['name'] : ''; ?></span>
              </div>
              <div class="mb-4">
                <select class="form-control" name="person">
                  <option value="" disabled selected>
                    How many persons?
                  </option>
                  <option value="2">
                    2
                  </option>
                  <option value="3">
                    3
                  </option>
                  <option value="4">
                    4
                  </option>
                  <option value="5">
                    5
                  </option>
                </select>
                <span class="form-text ml-4 text-danger"><?php echo isset($error['person']) ? $error['person'] : ''; ?></span>
              </div>
              <div class="mb-4 mt-4">
                <input type="date" name="date-order" class="form-control mb-0">
                <span class="form-text ml-4 text-danger"><?php echo isset($error['date']) ? $error['date'] : ''; ?></span>
              </div>
              <div class="btn_box">
                <button type="submit" name="submit" value="submit">
                  Book Now
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6">
          <div class="map_container ">
            <div id="googleMap"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end book section -->

  <?php
    include_once('./partials/footer.php');
  ?>

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

</body>

</html>