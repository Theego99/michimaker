<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>検索</title>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1QGR-mlSKkyr4m-yQ2acRX-evJ4OILbA&callback=initMap"></script>
  <script src="lidi.js" defer></script>
  <link rel="stylesheet" href="./sanitize.css">
  <link rel="stylesheet" href="./lidi.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <link rel="stylesheet" href="./style.css">
  <!--ファビコンの設定-->
  <link rel="shortcut icon" href="./design/images/favicon.ico">
  <link rel="apple-touch-icon" sizes="180x180" href="./design/images/apple-touch-icon.png">
</head>

<body>
<header class="header">
        <img class="logoimage" src="./design/images/NUKEMICHI.png">
        <!-- ヘッダーロゴ -->
        <div class="logo"></div>
        <!-- ハンバーガーメニュー部分 -->
        <div class="nav">
            <!-- ハンバーガーメニューの表示・非表示を切り替えるチェックボックス -->
            <input id="drawer_input" class="drawer_hidden" type="checkbox">

            <!-- ハンバーガーアイコン -->
            <label for="drawer_input" class="drawer_open"><span></span></label>
            <!-- メニュー -->
            <nav class="nav_content">
                <ul class="nav_list">
                    <!-- 三本線のやつ -->
                    <a href="search-page.php" class="musimegame">
                        <img src="./design/images/search.svg">
                        <li class="nav_item">SEARCH</li>
                    </a>
                    <a href="add-route.html" class="arrow">
                        <img src="./design/images/arrow.svg">
                        <li class="nav_item">NEW SHORTCUT</li>
                    </a>

                    <a href="mypage.php" class="hito">
                        <img src="./design/images/user.svg">
                        <li class="nav_item">MY PAGE</li>
                    </a>

                    <a href="index.html" class="tikyuugi">
                        <img src="./design/images/logout.svg">
                        <li class="nav_item">LOG OUT</li>
                    </a>
                </ul>
            </nav>
        </div>
    </header>


  <div class="search-box">

    <form action="search-page.php" method="post">
      <input class="search-txtbox" type="search" name="search" placeholder="    キーワードを入力">
      <button type="submit"><i class="fas fa-search"></i></button>
    </form>
  </div>



    <script src="./searched_map.js"></script>
</body>

</html>


<?php
// 検索処理
if (isset($_POST["search"])) {
  require "search.php";

  // 結果を表示
  if (count($results) > 0) {
    foreach ($results as $r) {
      printf(
        "<div class=\"search-results-container\">
          <div class=\"search-result\">
            <h1 class=\"route-name\">%s</h1>
            <small class=\"username\">発見者: %s</small>
            <p class=\"result-location\">%s</p>
            <p class=\"result-comment\">%s</p>
            <p id=\"result-point_a\" style=\"display:none;\">%s</p>
            <p id=\"result-point_b\" style=\"display:none;\">%s</p>
            <p id=\"result-shortcut_id\" style=\"display:none;\">%s</p>
          </div>
        </div>",
        $r["shortcut_name"],
        $r["name"],
        $r["address"],
        $r["comments"],
        $r["point_a"],
        $r["point_b"],
        $r["id"],
      );
    }
  } else {
    echo "<h3 style=\"text-align:center;\">検索結果なし</h3>";
  }
}