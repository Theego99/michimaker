<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="../sanitize.css">
</head>
<body>
    
    <h1>Home</h1>

    <a href="../add-route.html">
        <h2>道を登録</h2>
    </a>
    
    <?php if (isset($user)): ?>
        
        <p>こんにちは、 <?= htmlspecialchars($user["name"]) ?></p>
        
        <p><a href="logout.php">ログアウト</a></p>
        
    <?php else: ?>
        
        <p><a href="login.php">ログイン</a> 及び <a href="signup.html">新規登録</a></p>
        
    <?php endif; ?>
    
</body>
</html>
    
    
    
    
    
    
    
    
    
    
    