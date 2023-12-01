<?php
session_start();
$posts = $_POST;
$shortcut_id = filter_var($posts['shortcut_id'], FILTER_SANITIZE_SPECIAL_CHARS);
$user_id = $_SESSION["user_id"];

$mysqli = require __DIR__ . "/account_management/database.php";

//sum of all votes
$stmt = $mysqli->prepare("SELECT SUM(vote) AS total_votes FROM votes WHERE shortcut_id = $shortcut_id");
$stmt->execute();
$resultSet = $stmt->get_result();
$votes_sum = $resultSet->fetch_all(MYSQLI_ASSOC);

// my vote
$stmt = $mysqli->prepare("SELECT vote FROM votes WHERE user_id = $user_id and shortcut_id = $shortcut_id");
$stmt->execute();
$resultSet = $stmt->get_result();
$results = $resultSet->fetch_all(MYSQLI_ASSOC);



if ($results) {
    $results = array(
        "vote" => $results,
        "sum" => $votes_sum
    );
    echo json_encode($results);
} else {
    $results = array(
        "vote" => $results,
        "sum" => $votes_sum
    );
    $stmt = $mysqli->prepare("INSERT INTO votes (user_id ,shortcut_id, vote) VALUES ($user_id, $shortcut_id, 0)");
    $stmt->execute();
    $stmt = $mysqli->prepare("SELECT vote FROM votes WHERE user_id = $user_id and shortcut_id = $shortcut_id");
    $stmt->execute();
    $resultSet = $stmt->get_result();
    $results = $resultSet->fetch_all(MYSQLI_ASSOC);
    echo json_encode($results);
}
