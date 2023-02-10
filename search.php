<?php
$mysqli = require __DIR__ . "/account_management/database.php";

// (C) SEARCH
$stmt = $mysqli->prepare("select * from shortcuts where name = ? or comments = ?;");
$stmt->bind_param(
    "ss",
    $$_POST["search"],
    $$_POST["search"]
);
$stmt->execute();
$results = $stmt->fetchAll();
if (isset($_POST["ajax"])) {
    echo json_encode($results);
}
