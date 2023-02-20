<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>検索</title>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1QGR-mlSKkyr4m-yQ2acRX-evJ4OILbA&callback=initMap"></script>

  <link rel="stylesheet" href="./sanitize.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.1/css/all.css">
  <link rel="stylesheet" href="./style.css?v=2">
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
          <div class="musimegame">
            <img src="./design/images/search.svg">
            <li class="nav_item"><a href="search-page.php">SEARCH</a></li>
          </div>
          <div class="arrow">
            <img src="./design/images/arrow.svg">
            <li class="nav_item"><a href="add-route.html">NEW SHORTCUT</a></li>
          </div>

          <div class="hito">
            <img src="./design/images/user.svg">
            <li class="nav_item"><a href="mypage.php">MY PAGE</a></li>
          </div>

          <div class="tikyuugi">
            <img src="./design/images/logout.png">
            <li class="nav_item"><a href="index.html">LOG OUT</a></li>
          </div>
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
            <p class=\"result-location\">%s</p>
            <p class=\"result-comment\">%s</p>
            <p id=\"point_a\" style=\"display:none;\"> %s</p>
            <p id=\"point_b\" style=\"display:none;\"> %s</p>
          </div>
        </div>",
        $r["name"],
        $r["address"],
        $r["comments"],
        $r["point_a"],
        $r["point_b"],
      );
    }
  } else {
    echo "No results found";
  }
}
?>