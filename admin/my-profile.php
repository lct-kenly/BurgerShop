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
                                            <a href="" class="dropdown-link">
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
                        <div class="page-content bg-white rounded-3">
                            <div class="page-content-header p-4">
                                <h5>Thông tin tài khoản</h5>
                                <div class="d-flex mt-4">
                                    <img src="./assets/img/1.png" alt="">
                                    <div>
                                        <div>
                                            <label for="avatar" class="form-label btn btn-upload"></label>
                                            <input type="file" class="form-control" id="avatar" name="avatar" form="form-profile">

                                            <a href="" class="btn btn-outline-secondary btn-reset"></a>
                                        </div>

                                        <p class="mt-4">Allowed JPG, JPEG or PNG. Max size of 800K</p>
                                    </div>
                                </div>
                            </div>

                            <div class="divider"></div>

                            <form class="p-4" id="form-profile">
                                <div class="form-group-flex">
                                    <div class="form-group">
                                        <label for="fullname" class="form-label">Họ tên</label>
                                        <input type="text" class="form-control" id="fullname" placeholder="VD: Nguyễn Văn A">
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" placeholder="VD: example@gmail.com">
                                    </div>
                                </div>

                                <div class="form-group-flex">
                                    <div class="form-group">
                                        <label for="account" class="form-label">Tên tài khoản</label>
                                        <input type="text" class="form-control" id="account" name="fullname" placeholder="VD: abc123">
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="form-label">Mật khẩu</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="******">
                                    </div>
                                </div>

                                <div class="form-group-flex">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="VD: 0123456789">
                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="form-label">Địa chỉ</label>
                                        <textarea class="form-control" name="address" id="address" name="address" cols="30" rows="1"></textarea>
                                    </div>
                                </div>
                                <div class="form-group-flex">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Level</label>
                                        <select class="form-select" name="level" aria-label="Default select example">
                                            <option value="0">0 - Admin</option>
                                            <option value="1">1 - User</option>
                                          </select>
                                    </div>
                                </div>
                                <button type="submit" name="submit" value="submit" class="btn-submit-form">Xác nhận</button>
                            </form>
                        </div>

                        <div class="page-content-second bg-white rounded-3 mt-3 mx-3 p-4 ">
                            <h5>Xóa tài khoản</h5>

                            <p class="my-3 p-3 bg-warning bg-opacity-10 rounded-3 text-warning">
                                <span class="fw-bold">Are you sure you want to delete your account?</span> <br>
                                Once you delete your account, there is no going back. Please be certain.
                            </p>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="check-delete-account">
                                <label class="form-check-label" for="flexCheckDefault">
                                  Xác nhận xóa tài khoản
                                </label>
                            </div>

                            <a href="" class="btn btn-danger mt-3 btn-delete-account disabled">Xóa tài khoản</a>
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

    <script>

        // change inner html input avatar, button reset
        if(window.innerWidth < 576) {
            document.querySelector('.btn-upload').innerHTML = '<i class="fa-solid fa-upload"></i>';
            document.querySelector('.btn-reset').innerHTML = '<i class="fa-solid fa-rotate-right"></i>';
        } else {
            document.querySelector('.btn-upload').innerHTML = 'Upload new photo';
            document.querySelector('.btn-reset').innerHTML = 'Reset';
        }



        // on/off disabled button delete account

        const checkBoxDelete = document.querySelector('input[name="check-delete-account"]');
        const checkBtnDelete = document.querySelector('.btn-delete-account');
        checkBoxDelete.onchange = function() {
            if(checkBoxDelete.checked) {
                checkBtnDelete.classList.remove('disabled');
            } else {
                checkBtnDelete.classList.add('disabled');
            }
        }


    </script>

</body>
</html>