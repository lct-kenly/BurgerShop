<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'burger-shop') or die('Couldn\'t connect to Database');

    session_start();
 
    if(isset($_SESSION['user_logged'])) {
        $user = $_SESSION['user_logged'];

        $id_san_pham = isset($_GET['id']) ? $_GET['id'] : '';
        $sumcart = isset($_GET['sumcart']) ? $_GET['sumcart'] : '';

        if(!empty($id_san_pham)) {
            $sql = "DELETE FROM gio_hang WHERE id_khach_hang={$user['id']} AND id_san_pham={$id_san_pham}";
    
            if(mysqli_query($conn, $sql)) {
                $sumcart -= 1;
                echo json_encode(array("notify" => "Xóa sản phẩm thành công!", "sumcart" => $sumcart));

            } else {
                echo json_encode(array("notify" => "Có lỗi trong quá trình xử lý, Vui lòng thử lại!"));
            }
         }

    } else {
        header('location: ./account.php');
    }
?>