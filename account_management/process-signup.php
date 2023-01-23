<?php

if (empty($_POST["name"])) {
    die("名前を入力してください");
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("有効なメールアドレスを入力してください");
}

if (strlen($_POST["password"]) < 8) {
    die("８文字以上のパスワードを入力してください");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("パスワードにローマ字を一つ以上入力してください");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("パスワードに数字を一つ以上入力してください");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("パスワードは一致しません");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO users (name, email, password_hash)
        VALUES (?, ?, ?)";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss",
                  $_POST["name"],
                  $_POST["email"],
                  $password_hash);
                  
if ($stmt->execute()) {

    header("Location: signup-success.html");
    exit;
    
} else {
    
    if ($mysqli->errno === 1062) {
        die("メールアドレスは登録済みです");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}








