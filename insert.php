<?php
$posts = $_POST;

$point_A = $posts['point_A'];
$point_B = $posts['point_B'];
$name = $posts['shortcut-name'];
$comments = $posts['shortcut-info'];
$address = $posts['address'];


$mysqli = require __DIR__ . "/account_management/database.php";

$sql = "INSERT INTO shortcuts (point_A, point_B, name, comments, address, user_id) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sssssi",
                  $point_A,
                  $point_B,
                  $name,
                  $comments,
                  $address,
                  $user_id
                );
                  
if ($stmt->execute()) {
    header("Location: add-route.html");
    exit;
} else {
    die($mysqli->error . " " . $mysqli->errno);
}
