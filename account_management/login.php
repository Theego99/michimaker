<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM users
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style.css">

  <title>michi maker hp</title>
  <!--ファビコンの設定-->
<link rel="shortcut icon" href="./images/favicon.ico">
<link rel="apple-touch-icon" sizes="180x180" href="./images/apple-touch-icon.png">
</head>

<body>

  <div class ="login-header">
    <img class ="login-image" src="../design/images/NUKEMICHI_login.png">
</div>

      <h2 class ="new-user-btn"><a href="./signup.html">新規登録はこちら</a></h2>

  <?php if ($is_invalid): ?>
        <em>メールアドレスまたはパスワードが間違っています</em>
    <?php endif; ?>
    
    <form method="post" id="login-form">
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" placeholder="メールアドレス" required>
        
        <input type="password" name="password" id="password" placeholder="パスワード" required>
        
        <input id="login-submitbtn" type="submit" value="ログイン">
    </form>
</body>

</html>