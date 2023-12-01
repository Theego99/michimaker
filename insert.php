<?php
session_start();
$posts = $_POST;


$point_A = filter_var($posts['point_A'], FILTER_SANITIZE_SPECIAL_CHARS);
$point_B = filter_var($posts['point_B'], FILTER_SANITIZE_SPECIAL_CHARS);
$name = filter_var($posts['shortcut-name'], FILTER_SANITIZE_SPECIAL_CHARS);
$comments = filter_var($posts['shortcut-info'], FILTER_SANITIZE_SPECIAL_CHARS);
$address = filter_var($posts['address'], FILTER_SANITIZE_SPECIAL_CHARS);
$user_id = filter_var($_SESSION["user_id"], FILTER_SANITIZE_SPECIAL_CHARS);
if (isset($_POST['private'])) {
    $private = filter_var($posts['private'], FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $private = 0;
}



$mysqli = require __DIR__ . "/account_management/database.php";

$sql = "INSERT INTO shortcuts (point_A, point_B, shortcut_name, comments, address, user_id, private) VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param(
    "sssssii",
    $point_A,
    $point_B,
    $name,
    $comments,
    $address,
    $user_id,
    $private
);

if ($stmt->execute()) {
    header("Location: add-route.html");
    exit;
} else {
    die($mysqli->error . " " . $mysqli->errno);
}
