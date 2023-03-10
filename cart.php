<?php
    $conn = mysqli_connect('localhost', 'root', '', 'burger-shop') or die('Couldn\'t connect to Database');

    $error = array();
    session_start();
    $sanpham_giohang = array();
    $sum = 0;
    $count = 0;

    if(isset($_SESSION['user_logged'])) {
        $user = $_SESSION['user_logged'];

        include('./libs/helper.php');

        $countID_cart = get_count_cart($conn, $user['id']) ?? 0;

        $sql = "SELECT san_pham.id, san_pham.ten_san_pham, san_pham.hinh_anh, san_pham.don_gia_ban, gio_hang.so_luong, SUM(gio_hang.so_luong * san_pham.don_gia_ban) AS tri_gia 
                FROM gio_hang, san_pham 
                WHERE gio_hang.id_san_pham = san_pham.id AND gio_hang.id_khach_hang = {$user['id']}
                GROUP BY san_pham.id";
        
        $query = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($query)) {
            $sanpham_giohang[] = $row;
            $sum += $row['tri_gia'];
        }

        $count = count($sanpham_giohang);
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
              <li class="nav-item active">
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
                <!-- <form action="" class="form-search">
                  <div class="form-search-header">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search..." aria-label="Search">
                    <button class="btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                  </div>
                  <div class="form-search-body">
                    <p>L???ch s??? t??m ki???m</p>
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

  <!-- book section -->
  <section class="book_section layout_padding">
    <div class="container">
      <div class="heading_container mb-5">
        <h2 class="text-center w-100">
          SHOPPING CART
        </h2>
      </div>
      <div class="row">
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th class="text-center" scope="col">Product image</th>
                    <th class="text-center" scope="col">Name</th>
                    <th class="text-center" scope="col">Price</th>
                    <th class="text-center" scope="col">Quantity</th>
                    <th class="text-center" scope="col">Total</th>
                    <th class="text-center" scope="col">Remove</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($sanpham_giohang as $item) {?>
                    <tr>
                      <td class="text-center"><img src="./storage/uploads/<?=$item['hinh_anh']?>" alt="" style="width: 60px; height: 60px"></td>
                      <td class="text-center vertical-center"><?=$item['ten_san_pham']?></td>
                      <td class="text-center vertical-center product-price">$<?=$item['don_gia_ban']?></td>
                      <td class="text-center vertical-center">
                          <input class="p-2" type="number" name="so_luong[]" form="form-update-cart" value="<?=$item['so_luong']?>" style="max-width: 50%">
                          <input type="hidden" name="id_san_pham[]" form="form-update-cart" value="<?=$item['id']?>" />
                      </td>
                      <td class="text-center vertical-center product-total">$<?=$item['tri_gia']?></td>
                      <td class="text-center vertical-center">
                        <a class="delete-product-cart" href="#" data-id="<?=$item['id']?>">
                          <i class="fa-solid fa-x"></i>
                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary btn-update-cart" class="btn btn-primary py-2 px-5">Update Cart</button>

        </div>
        <div class="col-md-4">
            <table class="table table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th class="text-center" scope="col">Total</th>
                    <th class="text-center" scope="col">Price</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center">Subtotal:</td>
                    <td class="text-center subtotal-cart">$<?=$sum?></td>
                  </tr>
                  <tr>
                    <td class="text-center">Shipping:</td>
                    <td class="text-center">$15</td>
                  </tr>
                  <tr>
                    <td class="text-center">Total:</td>
                    <td class="text-center total-cart">$<?=$sum + 15?></td>
                  </tr>
                </tbody>
              </table>
              <a href="./checkout.php" class="btn btn-primary w-100 py-2">Proceed To Checkout</a>
        </div>
      </div>
    </div>
  </section>
  <!-- end book section -->

  <?php
    include_once('./partials/footer.php');
  ?>

    <!-- Toast -->
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="1000" style="position: fixed; right: 16px; bottom: 16px; ">
        <div class="toast-header">
          
          <strong class="mr-auto">Feane</strong>
          <small>1 second ago</small>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body">
          Hello, world! This is a toast message.
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

    $(document).ready(function(){
        let arrID = [];
        let arrQuantity = [];
        $('.btn-update-cart').click(function(e){

            $('input[name="id_san_pham[]"]').each(function(index, item){
                arrID.push($(item).val());
            });

            $('input[name="so_luong[]"]').each(function(index, item){
                arrQuantity.push($(item).val());
            })

            $.ajax({
                url: 'update-cart.php',
                method: 'POST',
                dataType: 'JSON',
                data: {id_san_pham: arrID, so_luong: arrQuantity},
            }).done(function(data) {
              $('.toast').toast('show');

              $('.toast-body').html(data.notify);

            })
        });


        // chang value price product / subtotal / total
        let subTotal = Number($('.subtotal-cart').text().replace('$', ''));
        let total = Number($('.total-cart').text().replace('$', ''));
        $('input[name="so_luong[]"]').change(function() {

            // change value product total
            let price = Number($(this).parent().parent().find('.product-price').text().replace('$', ''));

            $(this).parent().parent().find('.product-total').text('$' + ($(this).val() * price));

            // change subtotal-cart / total cart
            subTotal += price;
            total = subTotal + 15;

            $('.subtotal-cart').text(subTotal);
            $('.total-cart').text(total);
        });


        $('.delete-product-cart').click(function (e) {
            e.preventDefault();

            const parent = $(this).parent().parent();
            const id = $(this).attr('data-id');
            const sumCart = $('.cart_link > span').text();

            $.ajax({
                url: 'delete-cart.php',
                method: 'GET',
                dataType: 'JSON',
                data: {id: id, sumcart: sumCart},
            }).done(function(data) {
              
              parent.remove();

              $('.toast').toast('show');
              $('.toast-body').html(data.notify);
              $('.cart_link > span').text(data.sumcart);

              console.log();
            })
        })

    })

  </script>

</body>

</html>