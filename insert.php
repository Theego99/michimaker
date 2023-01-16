<?php

$posts = $_POST;

$point_A = $posts['point_A'];
$point_B = $posts['point_B'];
$name = $posts['shortcut-name'];

$dsn = 'mysql:dbname=nukemichimaker;host=localhost';
$user = 'root';
$password = '';

$dbh = new PDO($dsn, $user, $password);

$sql = "insert into shortcuts (point_A, point_B, name) values('{$point_A}', '{$point_B}','{$name}')";

//execute query
$dbh->query($sql);
