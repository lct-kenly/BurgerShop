<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'burger-shop') or die('Couldn\'t connect to Database');

    $error = array();
    session_start();

    if(isset($_SESSION['user_logged'])) {
        $user_logged = $_SESSION['user_logged'];

        include('./libs/helper.php');

        $countID_cart = get_count_cart($conn, $user_logged['id']) ?? 0;

        $error = array();
        
        $sql = "SELECT * FROM khach_hang WHERE id = '{$user_logged['id']}' "; 

        $query = mysqli_query($conn, $sql);

        if(mysqli_num_rows($query) > 0) {
            $user = mysqli_fetch_assoc($query);
        }

        if(isset($_POST['submit']) && $_POST['submit'] == 'submit') {
            $account = isset($_POST['account']) ? addslashes($_POST['account']) : '';
            $fullname = isset($_POST['fullname']) ? addslashes($_POST['fullname']) : '';
            $email = isset($_POST['email']) ? addslashes($_POST['email']) : '';
            $password = isset($_POST['password']) ? addslashes($_POST['password']) : '';
            $phone = isset($_POST['phone']) ? addslashes($_POST['phone']) : '';
            $address = isset($_POST['address']) ? addslashes($_POST['address']) : '';
            $avatar = $_FILES["avatar"]["name"];
            $tempname = $_FILES["avatar"]["tmp_name"];
            $folder = "./storage/uploads/" . $avatar;

            if(empty($account)) {
                $error['account'] = 'Bạn chưa nhập tên tài khoản';
            }

            if(empty($fullname)) {
                $error['fullname'] = 'Bạn chưa nhập họ tên';
            }

            if(empty($email)) {
                $error['email'] = 'Bạn chưa nhập email';
            } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ // Kiểm tra định dạng email
                $error['email'] = 'Email chưa đúng định dạng!';
            }

            if(empty($password)) {
                $error['password'] = 'Bạn chưa nhập mật khẩu';
            }

            if(empty($phone)) {
                $error['phone'] = 'Bạn chưa nhập số điện thoại';
            }

            if(empty($address)) {
                $error['address'] = 'Bạn chưa nhập địa chỉ';
            }

            if($_FILES['avatar']['error'] > 0) {
                $avatar = $user['avatar'];
            } else {
                move_uploaded_file($tempname ,$folder);
            }

            // Nếu không có lỗi
            if(!($error)) {

                $data_update = array(
                    'ten_tai_khoan' => $account,
                    'ho_ten' => $fullname,
                    'so_dien_thoai' => $phone,
                    'dia_chi' => $address,
                    'email' => $email,
                    'mat_khau' => $password,
                    'avatar' => $avatar,
                );

                

                $newData = array_diff($data_update, $user);

                // Nếu tồn tại tên tài khoản, email hoặc số điện thoại thì báo lỗi
                if(isset($newData['ten_tai_khoan']) && $newData['ten_tai_khoan'] != '') {
                    $sql = "SELECT * FROM khach_hang WHERE ten_tai_khoan = '{$newData['ten_tai_khoan']}' ";

                    $query = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($query) > 0) {
                        $error['account'] = 'Tài khoản đã tồn tại';
                    }
                }
                
                // Nếu tồn tại tên tài khoản, email hoặc số điện thoại thì báo lỗi
                if(isset($newData['email']) && $newData['email'] != '') {
                    $sql = "SELECT * FROM khach_hang WHERE email = '{$newData['email']}' ";

                    $query = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($query) > 0) {
                        $error['email'] = 'Email đã tồn tại';
                    }
                }

                // Nếu tồn tại tên tài khoản, email hoặc số điện thoại thì báo lỗi
                if(isset($newData['so_dien_thoai']) && $newData['so_dien_thoai'] != '') {
                    $sql = "SELECT * FROM khach_hang WHERE so_dien_thoai = '{$newData['so_dien_thoai']}' ";

                    $query = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($query) > 0) {
                        $error['phone'] = 'Số điện thoại đã tồn tại';
                    }
                }


                if(!($error)) {

                    if(!empty($newData)) {
                        $sql = "";

                        foreach($newData as $key => $val) {
                            $sql .= $key . "='" . addslashes($val) . "'" . ",";
                        }

                        $sql = trim($sql, ',');

                        $newSql = "UPDATE khach_hang SET $sql  WHERE id = '{$user['id']}'";

                        if(mysqli_query($conn, $newSql)) {
                            echo "<script>
                                    alert('Cập nhật tài khoản thành công!');
                                    window.location.href = 'profile.php';
                                </script>";
                        } else {
                            echo "<script>
                                    alert('Có lỗi trong quá trình xử lý, vui lòng thử lại!');
                                </script>";
                        }
                    } else {
                        echo "<script>
                                    alert('Cập nhật tài khoản thành công!');
                                    window.location.href = 'profile.php';
                                </script>";
                    }
                }

            }
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
                <a class="nav-link" href="cart.php">Cart</a>
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
          Update account
        </h2>
      </div>
      <div class="row">
        <div class="col-lg-3 col-md-4 col-12">
            <div class="grid-img text-center mt-3">
                <img src="<?php echo !empty($user['avatar']) ? './storage/uploads/'.$user['avatar'] : './images/avatar-.jpg'?>" alt="" class="border" style="width: 100px; height: 100px">
                <p class="form-text my-4" style="font-size: 12px">Allowed JPG, JPEG or PNG. Max size of 800K</p>
                <label for="avatar" class="btn btn-primary">Upload new avatar</label>
                <input type="file" id="avatar" class="form-control d-none" name="avatar" form="form-profile">
            </div>
        </div>
        <div class="col-lg-9 col-md-8 col-12">
            <form id="form-profile" method="POST" action="./profile.php?id=<?php echo $user['id']; ?>" enctype="multipart/form-data">
                <div class="form-group-flex">
                    <div class="form-group">
                        <label for="fullname" class="form-label">Name</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="VD: Nguyễn Văn A" value="<?php echo isset($user['ho_ten']) ? $user['ho_ten'] : ''; ?>">
                        <span class="form-text ms-3 text-danger"><?php echo !(empty($error['fullname'])) ? $error['fullname'] : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="VD: example@gmail.com" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>">
                        <span class="form-text ms-3 text-danger"><?php echo !(empty($error['email'])) ? $error['email'] : ''; ?></span>
                    </div>
                </div>

                <div class="form-group-flex">
                    <div class="form-group">
                        <label for="account" class="form-label">Username</label>
                        <input type="text" class="form-control" id="account" name="account" placeholder="VD: abc123" value="<?php echo isset($user['ten_tai_khoan']) ? $user['ten_tai_khoan'] : ''; ?>">
                        <span class="form-text ms-3 text-danger"><?php echo !(empty($error['account'])) ? $error['account'] : ''; ?></span>
                    </div>
                    <div class="form-group position-relative">
                        <label for="password" class="form-label">Password</label>

                        <input type="password" class="form-control" id="password" name="password" placeholder="******" value="<?php echo isset($user['mat_khau']) ? $user['mat_khau'] : ''; ?>">

                        <span class="show-password hide" style="top: 70%"><i class="fa-regular fa-eye"></i></span>

                        <span class="form-text ms-3 text-danger"><?php echo !(empty($error['password'])) ? $error['password'] : ''; ?></span>
                    </div>
                </div>

                <div class="form-group-flex">
                    <div class="form-group">
                        <label for="phone" class="form-label">Number phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="VD: 0123456789" value="<?php echo isset($user['so_dien_thoai']) ? $user['so_dien_thoai'] : ''; ?>">
                        <span class="form-text ms-3 text-danger"><?php echo !(empty($error['phone'])) ? $error['phone'] : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" name="address" id="address" name="address" cols="30" rows="1"><?php echo isset($user['dia_chi']) ? $user['dia_chi'] : ''; ?></textarea>
                        <span class="form-text ms-3 text-danger"><?php echo !(empty($error['address'])) ? $error['address'] : ''; ?></span>
                    </div>
                </div>
                <button type="submit" name="submit" value="submit" class="btn-submit-form">Submit</button>
            </form>
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

  <script>
        const inputFile = document.querySelector('input[name="avatar"]');
        const gridImg = document.querySelector('.grid-img');

        uploadFile(inputFile, gridImg);
  </script>

</body>

</html>