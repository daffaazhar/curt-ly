<?php
    include "config.php";
    $full_url = mysqli_real_escape_string($conn, $_POST['full_url']); // Mengambil data yang telah dikirimkan oleh AJAX
    $full_url_sanitize = strpos($full_url, 'http') !== 0 ? "http://$full_url" : $full_url;

    // Melakukan cek apakah pengguna telah memasukkan URL yang valid atau tidak
    if(!empty($full_url_sanitize) && filter_var($full_url_sanitize, FILTER_VALIDATE_URL)) {
        $random_url = substr(md5(microtime()), rand(0, 26), 5); // Menghasilkan 5 karakter acak
        $sql = mysqli_query($conn, "SELECT shorten_url FROM url WHERE shorten_url = '{$random_url}'"); // Melakukan cek apakah karakter yang dihasilkan sudah ada di database atau belum
        if(mysqli_num_rows($sql) > 0) {
            echo "Terjadi kesalahan. Silakan coba kembali.";
        } else {
            $sql2 = mysqli_query($conn, "INSERT INTO url (shorten_url, full_url, clicks) VALUES ('{$random_url}', '{$full_url_sanitize}', '0')"); // Memasukkan url yang telah dibuat oleh pengguna ke database bersamaan dengan karakter acak yang telah dihasilkan
            if($sql2) { // Melakukan cek apakah data telah berhasil dimasukkan ke database atau tidak
                $sql3 = mysqli_query($conn, "SELECT shorten_url FROM url WHERE shorten_url = '{$random_url}'"); // Memilih shorten url yang baru saja dibuat oleh pengguna
                if(mysqli_num_rows($sql3) > 0) {
                    $shorten_url = mysqli_fetch_assoc($sql3);
                    echo $shorten_url['shorten_url'];
                }
            } else {
                echo "Terjadi kesalahan. Silakan coba kembali.";
            }
        }
    } else {
        echo "$full_url_sanitize - URL tidak valid.";
    }
?>