<?php

session_start();

if (isset($_SESSION["user_id"])) {

    $mysqli = require __DIR__ . "/account_management/database.php";

    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nukemichi maker hp</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./sanitize.css">
    <script src="./validate_coordenates.js"></script>
    <script src="./map.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1QGR-mlSKkyr4m-yQ2acRX-evJ4OILbA&callback=initMap"></script>
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
                        <li class="nav_item"><a href="mypage.html">MY PAGE</a></li>
                    </div>

                    <div class="tikyuugi">
                        <img src="./design/images/logout.png">
                        <li class="nav_item"><a href="index.html">LOG OUT</a></li>
                    </div>
                </ul>
            </nav>
        </div>
    </header>

    <?php
    if (isset($user)) {
        // User is logged in, display information and logout link
    ?>
        <p>こんにちは、 <?= htmlspecialchars($user["name"]) ?></p>
        <p><?= htmlspecialchars($user["email"]) ?></p>
        <p><?= htmlspecialchars($user["id"]) ?></p>
        <p><a href="./account_management/logout.php">ログアウト</a></p>
    <?php
    } else {
        // User is not logged in, redirect to login page
        header('Location: ./account_management/login.php');
        exit;
    }
    ?>



    <!-- reset password -->
    <?php
    $db = require __DIR__ . "/account_management/database.php";
    if (isset($_POST['submit'])) :
        extract($_POST);
        if ($old_password != "" && $password != "" && $confirm_pwd != "") :
            $user_id = '1'; // sesssion id
            $old_pwd = password_hash(mysqli_real_escape_string($db, $_POST['old_password']), PASSWORD_DEFAULT);
            $pwd = password_hash(mysqli_real_escape_string($db, $_POST['password']), PASSWORD_DEFAULT);
            $c_pwd = password_hash(mysqli_real_escape_string($db, $_POST['confirm_pwd']), PASSWORD_DEFAULT);
            if ($pwd == $c_pwd) :
                if ($pwd != $old_pwd) :
                    $sql = "SELECT * FROM users WHERE id ='$user_id' AND password_hash = $old_pwd";
                    $db_check = $db->query($sql);
                    $count = mysqli_num_rows($db_check);
                    if ($count == 1) :
                        $fetch = $db->query("UPDATE users SET password_hash = '$pwd' WHERE id ='$user_id'");
                        $old_password = '';
                        $password = '';
                        $confirm_pwd = '';
                        $msg_sucess = "Your new password update successfully.";
                    else :
                        $error = "The password you gave is incorrect.";
                    endif;
                else :
                    $error = "Old password new password same Please try again.";
                endif;
            else :
                $error = "New password and confirm password do not matched";
            endif;
        else :
            $error = "Please fil all the fields";
        endif;
    endif;
    ?>
    <form method="post" autocomplete="off" id="password_form">
        <p>old password<br />
            <input type="password" name="old_password" />
        </p>
        <p>New password<br />
            <input type="password" name="password" id="password" class="ser" />
        </p>
        <p>Confirm password<br />
            <input type="password" name="confirm_pwd" id="confirm_pwd" class="ser" />
        </p>
        <p>
            <input name="submit" type="submit" value="Save Password" class="submit" />
        </p>
        <div class="<?= (@$msg_sucess == "") ? 'error' : 'green'; ?>" id="logerror">
            <?php echo @$error; ?><?php echo @$msg_sucess; ?>
        </div>
    </form>
</body>
