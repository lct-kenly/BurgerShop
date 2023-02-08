<?php
    $conn = mysqli_connect('localhost', 'root', '', 'burger-shop') or die('Couldn\'t connect to Database');

    $error = array();
    session_start();

    if(isset($_SESSION['user_logged'])) {
        $user = $_SESSION['user_logged'];

        $id_san_pham = isset($_GET['id']) ? $_GET['id'] : '';
        $soluong = isset($_GET['soluong']) ? $_GET['soluong'] : 1;
        $sumCart = isset($_GET['sumcart']) ? $_GET['sumcart'] : 0;


        if(!(empty($id_san_pham))) {
            
            $sql = "SELECT * FROM gio_hang WHERE id_khach_hang = {$user['id']} AND id_san_pham = {$id_san_pham}";
            $query = mysqli_query($conn, $sql);

            if(mysqli_num_rows($query) > 0) {
                $row = mysqli_fetch_assoc($query);

                $soluong += $row['so_luong'];

                $sql = "UPDATE `gio_hang` SET `so_luong`='{$soluong}' WHERE id_khach_hang = {$user['id']} AND id_san_pham = {$id_san_pham}";
                $query = mysqli_query($conn, $sql);
                if($query) {
                    echo json_encode(array("notify" => "Đã thêm vào giỏ hàng thành công!"));
                } else {
                    echo json_encode(array("notify" => "Có lỗi trong quá trình xử lý, Vui lòng thử lại!"));
                }
            } else {
                $sql = "INSERT INTO `gio_hang`(`id`, `id_khach_hang`, `id_san_pham`, `so_luong`) VALUES ('{$user['id']}','{$user['id']}','{$id_san_pham}','{$soluong}')";
                $query = mysqli_query($conn, $sql);
                if($query) {
                    $sumCart += 1;
                    echo json_encode(array("notify" => "Đã thêm vào giỏ hàng thành công!", "sumcart" => $sumCart));
                } else {
                    echo json_encode(array("notify" => "Có lỗi trong quá trình xử lý, Vui lòng thử lại!"));
                }
            }

        }
    } else {
        $_SESSION['previous-page'] = $_SERVER['HTTP_REFERER'];

        echo json_encode(array("redirect" => "Vui long dang nhap de tiep tuc!"));

    }
?> 