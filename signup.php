<?php

error_reporting(E_ALL);
ini_set('display_errors','On');

// 定数にメッセージを設定
const MSG = array(
  'EMPTY' => '入力必須です',
  'EMAIL_TYPE' => 'メールアドレスの形式で入力して下さい',
  'PASS_NO' => 'パスワード再入力が合いません',
  'PASS_TYPE' => '半角英数字で入力して下さい',
  'PASS_MAX' => '8文字以上で入力して下さい'
);

// 送信があった場合
if(!empty($_POST)){

  // 配列変数を用意
  $err_msg = array();
  
  // 入力されてない場合
  if(empty($_POST['email'])){
    $err_msg['email'] = MSG['EMPTY'];
  }
  
  if(empty($_POST['pass'])){ 
    $err_msg['pass'] = MSG['EMPTY'];
  }

  if(empty($_POST['pass_re'])){ 
    $err_msg['pass_re'] = MSG['EMPTY']; 
  }

  if(empty($err_msg)){

    // 変数へ入力された値を代入
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass_re = $_POST['pass_re'];

    // メールアドレスの形式でない場合
    if(!preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/',$email)){
      $err_msg['email'] = MSG['EMAIL_TYPE'];
    }

    // パスワード再入力が合ってない場合
    if($pass !== $pass_re){
      $err_msg['pass_re'] = MSG['PASS_NO'];
    }

    if(empty($err_msg)){

      // パスワードが半角英数字でない場合
      if(!preg_match('/^[a-zA-Z0-9]+$/',$pass)){
        $err_msg['pass'] = MSG['PASS_TYPE'];

      }

      // パスワードが8文字以上ない場合
      if(mb_strlen($pass) < 8){
        $err_msg['pass'] = MSG['PASS_MAX'];
      }

      if(empty($err_msg)){

        $dsn = 'mysql:dbname=作品;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $options = array(
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
        );

        // PDOオブジェクト生成
        $dbh = new PDO($dsn,$user,$password,$options);
        // クエリー作成
        $stmt = $dbh->prepare('INSERT INTO flower_shop (email,pass,login_time) VALUES (:email,:pass,:login_time)');
        // プレースホルダセットしてクエリー実行
        $stmt->execute(array(':email' => $email,':pass' => $pass, ':login_time' => date('Y-m-d H:i:s')));
        // レッスン画面へ遷移
        header("Location:flower_lesson.html");
    
      } 
    }
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
        <li><a href="login.php">LOGIN</a></li>        
      </ul>
    </nav>
  </header>
  <main>
    <h2 class="title">会員登録</h2>
    <form method="post">
      <div class="form-item">
        <label>メールアドレス　<span class="error-msg"><?php if(!empty($err_msg['email'])) echo $err_msg['email']; ?></span>
            <input type="text" name="email" class="valid-email" value="<?php if(!empty($_POST['email'])) echo $_POST['email'];?>">
        </label>            
      </div>   
      <div class="form-item">
        <label>パスワード　<span class="error-msg"><?php if(!empty($err_msg['pass'])) echo $err_msg['pass']; ?></span>
            <input type="password" name="pass" class="valid-pass" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass'];?>">
        </label>      
      </div> 
      <div class="form-item">
        <label>パスワード再入力　<span class="error-msg"><?php if(!empty($err_msg['pass_re'])) echo $err_msg['pass_re']; ?></span>
            <input type="password" name="pass_re" class="valid-pass" value="<?php if(!empty($_POST['pass_re'])) echo $_POST['pass_re'];?>">
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
