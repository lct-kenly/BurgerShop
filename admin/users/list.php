<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'burger-shop') or die('Couldn\'t connect to Database');

    session_start();

    if(!isset($_SESSION['admin_logged'])) {
        header('location: ../../account.php');
    }

    $user_logged = $_SESSION['user_logged'];

    $users = array();
    $user_logged = $_SESSION['user_logged'];

    $sql = "SELECT * FROM khach_hang WHERE khach_hang.id NOT IN({$user_logged['id']})";
    $query = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($query)) {
        $users[] = $row;
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

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">


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
                        <span>Trang ch???</span>              
                    </a>
                </li>

                <!-- Menu users -->

                <li class="menu-header">
                    <span>Users</span>
                </li>

                <li class="menu-item active">
                    <a href="" class="menu-link menu-toggle active">
                        <i class="fa-solid fa-user menu-icon"></i>                       
                        <span>Kh??ch h??ng</span>              
                    </a>

                    <ul class="menu-sub open">
                        <li class="menu-item">
                            <a href="./list.php" class="menu-link active">
                                <span>Danh s??ch</span>              
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="./add.php" class="menu-link">
                                <span>Th??m</span>              
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
                        <span>S???n ph???m</span>              
                    </a>

                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="../products/list.php" class="menu-link">
                                <span>Danh s??ch</span>              
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="../products/add.php" class="menu-link">
                                <span>Th??m</span>              
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
                        <span>????n h??ng</span>              
                    </a>

                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="../orders/list.php" class="menu-link">
                                <span>Danh s??ch</span>              
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="../orders/add.php" class="menu-link">
                                <span>Th??m</span>              
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
                                        <img src="<?php echo !empty($user_logged['avatar']) ? '../../storage/uploads/'. $user_logged['avatar'] : '../../storage/uploads/1.png';?>" alt="avatar" class="avatar">
                                    </button>
                                    <ul class="dropdown">
                                        <li class="dropdown-item">
                                            <img src="<?php echo !empty($user_logged['avatar']) ? '../../storage/uploads/'. $user_logged['avatar'] : '../../storage/uploads/1.png';?>" alt="avatar" class="avatar">
                                            <div class="dropdown-content">
                                                <p><?php echo !empty($user_logged['ten_tai_khoan']) ? $user_logged['ten_tai_khoan'] : 'Admin website';?></p>
                                                <span>Admin</span>
                                            </div>
                                        </li>

                                        <li class="divider"></li>

                                        <li class="dropdown-item">
                                            <a href="../my-profile.php" class="dropdown-link">
                                                <i class="fa-regular fa-address-card"></i>
                                                <span>Th??ng tin t??i kho???n</span>
                                            </a>
                                        </li>

                                        <li class="dropdown-item">
                                            <a href="" class="dropdown-link">
                                                <i class="fa-regular fa-bell"></i>
                                                <span>Th??ng b??o</span>
                                                <span class="badge bg-danger text-light float-end">3</span>
                                            </a>
                                        </li>

                                        <li class="dropdown-item">
                                            <a href="" class="dropdown-link">
                                                <i class="fa-solid fa-gear"></i>
                                                <span>C??i ?????t</span>
                                            </a>
                                        </li>

                                        <li class="divider"></li>

                                        <li class="dropdown-item">
                                            <a href="../../logout.php" class="dropdown-link">
                                                <i class="fa-solid fa-power-off"></i>
                                                <span>????ng xu???t</span>
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
                                <li class="breadcrumb-item"><a href="../index.php" class="text-decoration-none fs-5">Trang ch???</a></li>
                                <li class="breadcrumb-item"><a href="./add.php" class="text-decoration-none fs-5">Kh??ch h??ng</a></li>
                                <li class="breadcrumb-item active fs-5" aria-current="page">Th??m t??i kho???n</li>
                            </ol>
                        </nav>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-content bg-white rounded-3 p-4">
                            <table class="table table-bordered display mt-3" id="table-list-users">
                                <thead>
                                  <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">H??? t??n</th>
                                    <th scope="col">T??n t??i kho???n</th>
                                    <th scope="col">H??nh ?????ng</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $item) { ?>
                                        <tr>
                                            <td><?=$item['id']?></td>
                                            <td><?=$item['ho_ten']?></td>
                                            <td><?=$item['ten_tai_khoan']?></td>
                                            <td>
                                                <?php if($item['level'] == 1 && $item['ten_tai_khoan'] == 'admin') { ?>
                                                <?php } else { ?>
                                                    <a href="./edit.php?id=<?=$item['id']?>" class="btn btn-sm btn-outline-info"><i class="fa-regular fa-pen-to-square"></i></a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?=$item['id']?>">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </button>
                                                <?php } ?>
                                            </td> 
                                        </tr>
                                    <?php } ?>
                                </tbody>
                              </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">X??a t??i kho???n</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    B???n ch???c ch???n mu???n x??a v??nh vi???n t??i kho???n n??y?
                </div>
                <div class="modal-footer">
                    <a class="btn btn-danger btn-delete-user">X??a</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">H???y</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery 3.6.3 -->
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

    <script src="../assets/js/main.js"></script>

    <script>
        $(document).ready( function () {
            $('#table-list-users').DataTable();
        } );


        document.addEventListener("DOMContentLoaded", function() {
            let id;

            const btnDelete = document.querySelector('.btn-delete-user');
            const exampleModal = document.getElementById('exampleModal')
            exampleModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                
                id = button.getAttribute('data-id');

                btnDelete.setAttribute('href', `./delete.php?id=${id}`);
            });
        })
    </script>
</body>
</html>