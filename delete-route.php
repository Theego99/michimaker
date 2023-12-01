<?php
$id = filter_var($_POST["result-shortcut_id"], FILTER_SANITIZE_SPECIAL_CHARS);

$mysqli = require __DIR__ . "/account_management/database.php";

$sql = "DELETE shortcuts, votes FROM shortcuts
LEFT JOIN votes ON shortcuts.id = votes.shortcut_id
WHERE shortcuts.id = $id;";

$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("SQL error: " . $mysqli->error);
}

if ($stmt->execute()) {
    header("location: mypage.php");
    exit;
} else {
    die($mysqli->error . " " . $mysqli->errno);
}
