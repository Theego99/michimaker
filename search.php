<?php
$mysqli = require __DIR__ . "/account_management/database.php";

// (C) SEARCH
$stmt = $mysqli->prepare("select * from shortcuts where name like ? or comments like ?;");

$stmt->execute(["%".$_POST["search"]."%", "%".$_POST["search"]."%"]);
$resultSet = $stmt->get_result();
$results = $resultSet->fetch_All(MYSQLI_ASSOC);
if (isset($_POST["ajax"])) {
    echo json_encode($results);
}
