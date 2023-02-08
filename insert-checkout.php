<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'burger-shop') or die('Couldn\'t connect to Database');
    include('./libs/mail/sendmail.php');
    $mail = new Mailler;
    $error = array();
    session_start();

    if(isset($_SESSION['user_logged'])) {
        $user = $_SESSION['user_logged'];

        $thanh_toan = isset($_GET['httt']) ? $_GET['httt'] : 'MoMo';

        $id_don_hang = rand(100000, 999999);

        $sql = "INSERT INTO `don_hang`(`ma_don_hang`, `id_khach_hang`, `thanh_toan`) VALUES ('{$id_don_hang}','{$user['id']}','{$thanh_toan}')";

        $query = mysqli_query($conn, $sql);
        if($query) {

            $sql = "SELECT san_pham.id, san_pham.ten_san_pham, san_pham.don_gia_ban, gio_hang.so_luong, SUM(gio_hang.so_luong * san_pham.don_gia_ban) AS tri_gia 
                FROM gio_hang, san_pham 
                WHERE gio_hang.id_san_pham = san_pham.id AND gio_hang.id_khach_hang = {$user['id']}
                GROUP BY san_pham.id";
        
            $query = mysqli_query($conn, $sql);
            $sql2 = '';
            while($row = mysqli_fetch_assoc($query)) {
                $sql2 .= "({$id_don_hang},{$row['id']},{$row['so_luong']},{$row['don_gia_ban']},{$row['tri_gia']}),";
            }

            $sql2 = trim($sql2, ',');

            $newSql = "INSERT INTO `chi_tiet_don_hang`(`ma_don_hang`, `id_san_pham`, `so_luong`, `don_gia`, `tri_gia`) VALUES " . $sql2;
            
            $query = mysqli_query($conn, $newSql);
            if($query) {

                $sql = "DELETE FROM `gio_hang` WHERE id_khach_hang={$user['id']}";
                $query = mysqli_query($conn, $sql);

                $data = array(
                    "fullname" => $user['ho_ten'],
                    "id_don_hang" => $id_don_hang
                );

                $mail->sendmail_order($data);

                echo "<script>
                        alert('Đặt hàng thành công!');
                        window.location.href = './index.php';
                    </script>";
            } else {
                echo "<script>
                        alert('Có lỗi trong quá trình xử lý, vui lòng thử lại!');
                        window.location.href = './index.php';
                    </script>";
            }
        } else {
            echo "<script>
                alert('Có lỗi trong quá trình xử lý, vui lòng thử lại!');
                window.location.href = './index.php';
            </script>";
        }
    }
?>