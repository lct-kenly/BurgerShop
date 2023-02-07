<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'burger-shop') or die('Couldn\'t connect to Database');

    $error = array();
    session_start();

    if(isset($_POST['submit']) && $_POST['submit'] == 'submit') {
        $username_email = isset($_POST['username-email']) ? addslashes( $_POST['username-email']) : ''; 
        $password = isset($_POST['password']) ? addslashes( $_POST['password']) : ''; 

        if(empty($username_email)) {
            $error['username-email'] = 'Bạn chưa nhập tên tài khoản / email!';
        }

        if(empty($password)) {
            $error['password'] = 'Bạn chưa nhập mật khẩu!';
        }

        if(!($error)) {
            $sql = "SELECT * FROM khach_hang WHERE ten_tai_khoan = '{$username_email}' OR email = '{$username_email}'";
            $query = mysqli_query($conn, $sql);

            if(mysqli_num_rows($query) > 0) {
                $user = mysqli_fetch_assoc($query);

                if($username_email == $user['email'] || $username_email == $user['ten_tai_khoan']) {
                    if($password == $user['mat_khau']) {
                        // Lưu thông tin đăng nhập
                        $_SESSION['user_logged'] = array(
                            'id' => $user['id'],
                            'ho_ten' => $user['ho_ten'],
                            'ten_tai_khoan' => $user['ten_tai_khoan'],
                            'email' => $user['email'],
                            'so_dien_thoai' => $user['so_dien_thoai'],
                            'avatar' => $user['avatar'],
                        );

                        // Nếu là admin
                        if($user['level'] == 1) {

                            $_SESSION['admin_logged'] = array (
                              'set_logged' => true,
                            );


                            if(isset($_SESSION['previous-page'])) {
                                header('location: ' . $_SESSION['previous-page']);
                            } else {
                                header('location: ./admin/index.php');
                            }
                            
                        } else {
                            if(isset($_SESSION['previous-page'])) {
                                header('location: ' . $_SESSION['previous-page']);
                            } else {
                                header('location: ./index.php');
                            }
                        }
                    } else {
                        $error['password'] = 'Mật khẩu không đúng, vui lòng thử lại!';
                    }
                }

            } else {
                $error['username-email'] = 'Tên tài khoản hoặc mật khẩu không đúng!';
                $error['password'] = 'Tên tài khoản hoặc mật khẩu không đúng!';

            }
        }

    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
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
      
</head>
<body>
  <div class="">
    <div class="bg-account">
      <!-- <img src="images/hero-bg.jpg" alt=""> -->
    </div>
    <!-- header section strats -->
    <header class="header_section__account">
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
              <li class="nav-item">
                <a class="nav-link" href="book.php">Book Table <span class="sr-only">(current)</span> </a>
              </li>
            </ul>
            <div class="user_option">
              <a class="cart_link" href="#">
                <i class="fa-solid fa-cart-shopping"></i>
                <span><?php echo $countID_cart ?? 0; ?></span>
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
              </a>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>

<!-- Start Account Section -->
  <section class="account_section layout_padding">
    <div class="container">
      <div class="heading_container-account">
        <h2 class="account-title">
          Log In
        </h2>
      </div>
      <div class="row">
        <div class="col-md-4 offset-md-4">
          <div class="form_container">
            <form id="form-1" method="POST" action="">
              <div class="form-group">
                <input id="username" type="text" class="form-control" name="username-email" placeholder="Username or email" />
                <span class="form-message text-danger"><?php echo !(empty($error['username-email'])) ? $error['username-email'] : ''; ?></span>
              </div>
              <div class="form-group">
                <input id="password" type="password" class="form-control" name="password" placeholder="Password" />
                <span class="form-message text-danger"><?php echo !(empty($error['password'])) ? $error['password'] : ''; ?></span>
                <span class="show-password"><i class="fa-regular fa-eye-slash"></i></span>
              </div>
              <div class="account-register">
                <p>Don't have account? <a href="register.php" class="register-link"> Sign up here</a></p>
              </div>
              <div class="btn_box">
                <button type="submit" name="submit" value="submit"> Log In </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>







<!-- End Account Section -->

  <?php
    include_once('./partials/footer.php');
  ?>
  <!-- footer section -->

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