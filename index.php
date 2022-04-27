<?php
// Me-redirect pengguna ke url asli menggunakan shorten url
include "php/config.php";
$new_url = "";
if (isset($_GET)) {
    foreach ($_GET as $key => $val) {
        $u = mysqli_real_escape_string($conn, $key);
        $new_url = str_replace("/", "", $u); // Menghapus karakter slash (/) dari url
    }
    // Mendapatkan full url dari short url
    $sql = mysqli_query(
        $conn,
        "SELECT full_url FROM url WHERE shorten_url = '{$new_url}'"
    );
    if (mysqli_num_rows($sql) > 0) {
        $count_query = mysqli_query(
            $conn,
            "UPDATE url SET clicks = clicks + 1 WHERE shorten_url = '{$new_url}'"
        );
        if ($count_query) {
            // redirect pengguna
            $full_url = mysqli_fetch_assoc($sql);
            header("Location:" . $full_url["full_url"]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="css/style.css">
    <title>URL Shortener</title>
  </head>
  <body>
    <div class="wrapper" style="overflow-x: auto;">
      <form action="#">
        <i class="url-icon uil uil-link"></i>
        <input type="text" name="full_url" placeholder="Enter or paste a long url" required />
        <button>Shorten</button>
      </form>
      <?php
      $sql2 = mysqli_query($conn, "SELECT * FROM url ORDER BY id DESC");
      if (mysqli_num_rows($sql2) > 0): ?>
            <div class="count">
              <?php
              $sql3 = mysqli_query($conn, "SELECT COUNT(*) FROM url");
              $res = mysqli_fetch_assoc($sql3);
              $sql4 = mysqli_query($conn, "SELECT clicks FROM url");
              $total = 0;
              while ($i = mysqli_fetch_assoc($sql4)) {
                  $total += $i["clicks"];
              }
              ?>
              <span>Total Links: <span><strong><?php echo end(
                  $res
              ); ?></strong></span> & Total Clicks: <span><strong><?php echo $total; ?></span></strong></span>
              <a href="php/delete.php?delete=all">Clear All</a>
            </div>

            <!-- Mulai disini -->
            <div class="urls-area" style="overflow-x: auto;">
              <table>
                <tr class="title">
                  <th style="width: 30%;">Shorten URL</th>
                  <th style="width: 40%;">Original URL</th>
                  <th style="width: 15%">Click</th>
                  <th style="width: 15%;">Action</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($sql2)): ?>
                  <tr class="data">
                    <td>
                      <a href="<?php echo $domain.$row["shorten_url"]; ?>" target="_blank">
                        <?php if ($domain . strlen($row["shorten_url"]) > 50): ?>
                          <?php echo $domain .
                              substr($row["shorten_url"], 0, 50) .
                              "..."; ?>
                        <?php else: ?>
                          <?php echo $domain . $row["shorten_url"]; ?>
                        <?php endif; ?>
                      </a>
                    </td>
                    <td class="original-url-table">
                    <?php if (strlen($row["full_url"]) > 65): ?>
                          <?php echo substr($row["full_url"], 0, 65) . "..."; ?>
                        <?php else: ?>
                          <?php echo $row["full_url"]; ?>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $row["clicks"]; ?></td>
                    <td><a href="php/delete.php?id=<?php echo $row[
                        "shorten_url"
                    ]; ?>">Delete</a></td>
                  </tr>
                <?php endwhile; ?>
              </table>
            </div>
        <?php endif;
      ?>
    </div>

    <div class="blur-effect"></div>
    <div class="popup-box">
      <div class="info-box">Your short link is ready. You can also edit your short link now but can't edit once you save it.</div>
      <form action="#">
        <label for="">Edit your shorten url</label>
        <input class="shorten-url" type="text" spellcheck="false" value="" />
        <i class="copy-icon uil uil-copy-alt"></i>
        <button>Save</button>
      </form>
    </div>

    <script src="script.js"></script>
  </body>
</html>
