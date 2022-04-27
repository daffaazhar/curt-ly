<?php
    $domain = "https://curt-ly.herokuapp.com/";
    $host = "remotemysql.com:3306";
    $user = "d9pEdB8ZXp";
    $pass = "FR8frNP8xy";
    $db = "d9pEdB8ZXp";

    $conn = mysqli_connect($host, $user, $pass, $db);
    if(!$conn) { // Melakukan cek apakah koneksi database tidak berhasil
        echo "Database connection error".mysqli_connect_error();
    }
?>