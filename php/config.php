<?php
    $domain = "localhost/url-shortener/";
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "url_shortener";

    $conn = mysqli_connect($host, $user, $pass, $db);
    if(!$conn) { // Melakukan cek apakah koneksi database tidak berhasil
        echo "Database connection error".mysqli_connect_error();
    }
?>