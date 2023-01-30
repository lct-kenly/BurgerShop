<?php 
    function get_count_cart($conn, $id_user) {
        $sql = "SELECT COUNT(id_san_pham) AS total FROM gio_hang WHERE id_khach_hang={$id_user}";
        $query = mysqli_query($conn, $sql);
        $result = 0;
        if(mysqli_num_rows($query) > 0) {
            $result = mysqli_fetch_assoc($query)['total'];
        }

        return $result;
    }
?>