<?php
include "config.php";
$original_url = mysqli_real_escape_string($conn, $_POST["shorten_url"]);
$shorten_url = str_replace(" ", "", $original_url); // Menghapus spasi dari url yang dimasukkan oleh pengguna
$hidden_url = mysqli_real_escape_string($conn, $_POST["hidden_url"]);

if (!empty($shorten_url)) {
    $domain = "localhost";
    if (preg_match("/\//i", $shorten_url)) { // Cek apakah pengguna menghapus domain utama atau tidak
        $explode_url = explode("/", $shorten_url);
        $short_url = end($explode_url);
        if ($short_url != "") {
            $sql = mysqli_query(
                $conn,
                "SELECT shorten_url FROM url WHERE shorten_url = '{$short_url}' && shorten_url != '{$hidden_url}'"
            ); // Memilih secara acak url yang telah dibuat untuk diperbarui dengan url baru yang telah dibuat oleh pengguna
            // Melakukan pengecekan apakah url yang telah dibuat oleh pengguna sudah ada di database atau belum
            if (mysqli_num_rows($sql) == 0) {
                $sql2 = mysqli_query(
                    $conn,
                    "UPDATE url SET shorten_url = '{$short_url}' WHERE shorten_url = '{$hidden_url}'"
                ); // Memperbarui url
                if ($sql2) { // Melakukan pengecekan apakah proses perbaruan url berhasil atau tidak
                    echo "success";
                } else {
                    echo "Error - Failed to update link!";
                }
            } else {
                echo "The short url that you've entered already exist. Please enter another one!";
            }
        } else {
            echo "Required - You have to enter short url!";
        }
    } else {
        echo "Invalid URL - You can't edit domain name!";
    }
} else {
    echo "Error- You have to enter short url!";
}
?>
