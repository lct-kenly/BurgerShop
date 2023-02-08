<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'burger-shop') or die('Couldn\'t connect to Database');

    session_start();

    if(isset($_SESSION['user_logged'])) {
        unset($_SESSION['user_logged']);
    }

    if(isset($_SESSION['previous-page'])) {
        unset($_SESSION['previous-page']);
    }

    header('location: ./account.php');
?>