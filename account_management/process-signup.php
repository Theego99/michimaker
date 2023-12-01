<?php
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

#データのサニタイジング
$name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

$sql = "INSERT INTO users (name, email, password_hash)
        VALUES (?, ?, ?)";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss",
                  $name,
                  $email,
                  $password_hash);
                  
if ($stmt->execute()) {

    header("Location: signup-success.php");
    exit;
    
} else {
    
    if ($mysqli->errno === 1062) {
        die("メールアドレスは登録済みです");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
