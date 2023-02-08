<?php
    $conn = mysqli_connect('localhost', 'root', '', 'burger-shop') or die('Couldn\'t connect to Database');

    $error = array();
    session_start();

    if(isset($_SESSION['user_logged'])) {
        $user = $_SESSION['user_logged'];

        // Cập nhật giỏ hàng
        $id = isset($_POST['id_san_pham']) ? $_POST['id_san_pham'] : array();
        $soluong = isset($_POST['so_luong']) ? $_POST['so_luong'] : array();

        if(empty($soluong)) {
            $error['soluong'] = 'Lỗi, mảng rỗng';
        }

        if(empty($id)) {
            $error['id'] = 'Lỗi, mảng rỗng';
        }

        if(!($error)) {
            for($i = 0; $i < count($id); $i++) {
                if($soluong[$i] < 0) $soluong[$i] = 1;

                $sql = "UPDATE `gio_hang` SET `so_luong`='{$soluong[$i]}' WHERE `id_khach_hang`={$user['id']} AND `id_san_pham`={$id[$i]}";
                $query = mysqli_query($conn, $sql);

            }

            if($query) {
                echo json_encode(array("notify" => "Cập nhật giỏ hàng thành công!"));
            }
        }
        
    } else {
        $_SESSION['previous-page'] = $_SERVER['HTTP_REFERER'];

        echo json_encode(array("redirect" => "Vui long dang nhap de tiep tuc!"));

    }
?> 