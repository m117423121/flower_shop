<?php

error_reporting(E_ALL); 
ini_set('display_errors','on'); 
 
// 送信があった場合
if(!empty($_POST)){
 
  // 変数へ入力された値を代入
  $email = $_POST['email'];
  $pass = $_POST['pass'];
 
  $dsn = 'mysql:dbname=作品;host=localhost;charset=utf8';
  $user = 'root';
  $password = 'root';
  $options = array(
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
      );
  // PDOオブジェクト生成
  $dbh = new PDO($dsn, $user, $password, $options);
  // クエリー作成
  $stmt = $dbh->prepare('SELECT * FROM flower_shop WHERE email = :email AND pass = :pass');
  // プレースホルダセットしてクエリー実行
  $stmt->execute(array(':email' => $email, ':pass' => $pass));
 
  $result = 0;
  // 登録結果を変数へ代入
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if(!empty($result)){
    // 登録があった場合
    session_start(); // セッション使う前に呼び出す
    
    $_SESSION['login'] = true; // サーバーのセッション領域に値を保存
 
    header("Location:flower_lesson.html"); // レッスン画面へ遷移
  }else{
    header("Location:login.php");
  }
}
 
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Flower Shop</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <h1><a href="flower_shop.html">FlowerShop</a></h1>
    <nav class="header-nav">
      <ul>
        <li><a href="flower_shop.html">TOP</a></li>
        <li><a href="contact.html">CONTACT</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <h3 class="title">ログイン</h3>
    <form method="post">    
      <div class="form-item">
        <label>メールアドレス　<span class="error-msg"></span>
            <input type="text" name="email" class="valid-email" value="<?php if(!empty($_POST['email'])) echo $_POST['email'];?>">
        </label>      
      </div>  
      <div class="form-item">
        <label>パスワード　<span class="error-msg"></span>
            <input type="password" name="pass" class="valid-pass" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass'];?>">
        </label>          
      </div>          
      <input type="submit" name="submit" value="送信">
    </form>
  </main>
  <footer>
      <p>Copyright © 2020 inc. All Right Reserved.</p>
  </footer>
  <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="main.js"></script>
</body>
</html>
