<?php
$mysqli = require __DIR__ . "/account_management/database.php";

// 検索
$stmt = $mysqli->prepare("select * from shortcuts where name like ? or comments like ? or address like ?;");
$stmt = $mysqli->prepare("SELECT s.*, u.name FROM shortcuts s JOIN users u ON s.user_id = u.id WHERE s.name LIKE ? OR s.comments LIKE ? OR s.address LIKE ? OR u.name LIKE ?;");

$stmt->execute(["%".$_POST["search"]."%", "%".$_POST["search"]."%", "%".$_POST["search"]."%", "%".$_POST["search"]."%"]);
$resultSet = $stmt->get_result();
$results = $resultSet->fetch_All(MYSQLI_ASSOC);
if (isset($_POST["ajax"])) {
    echo json_encode($results);
}
