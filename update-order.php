<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'burger-shop') or die('Couldn\'t connect to Database');

    session_start();
    date_default_timezone_set('Asia/Ho_Chi_Minh'); 
    $date_current = '';
    $date_current = date("Y-m-d H:i:s");
 
    if(isset($_SESSION['user_logged'])) {
        $user = $_SESSION['user_logged'];

        $ma_don_hang = isset($_GET['id']) ? $_GET['id'] : '';
        $trang_thai = isset($_GET['state']) ? $_GET['state'] : '';

        if(!empty($ma_don_hang)) {
            $sql = "UPDATE don_hang SET trang_thai = {$trang_thai}, updated_at = '{$date_current}' WHERE ma_don_hang={$ma_don_hang}";
    
            if(mysqli_query($conn, $sql)) {
                echo "<script>
                        alert('Hủy đơn hàng thành công!');
                        window.location.href = './order.php';
                    </script>";
            } else {
                echo "<script>
                        alert('Có lỗi trong quá trình xử lý, vui lòng thử lại!');
                        window.location.href = './order.php';
                    </script>";
            }
         }

    } else {
        header('location: ./account.php');
    }
?>