<?php
error_reporting(E_ALL & ~E_NOTICE);

session_start();


$posts = $_POST;

$vote = filter_var($posts['vote'], FILTER_SANITIZE_SPECIAL_CHARS);
$vote_int = intval($vote);
$shortcut_id = filter_var($posts['shortcut_id'], FILTER_SANITIZE_SPECIAL_CHARS);
$user_id = $_SESSION["user_id"];


$mysqli = require __DIR__ . "/account_management/database.php";


// update vote status
$sql_insert = "UPDATE votes SET vote = ? WHERE user_id = ? AND shortcut_id= ?";
$stmt_insert = $mysqli->prepare($sql_insert);
if (!$stmt_insert) {
    die("Error preparing UPDATE statement: " . $mysqli->error);
}

// Bind the parameters and execute the UPDATE statement
$stmt_insert->bind_param("iii", $vote, $user_id, $shortcut_id) ;
if (!$stmt_insert->execute()) {
    die("Error executing UPDATE statement: " . $stmt_insert->error);
}
include 'myvote.php';
