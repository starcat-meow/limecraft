<!DOCTYPE html>
<?php
session_start(); // 移动到文件顶部  
  $shu=array();
include_once '../header.php';
UserCookieTest();
$pdo=PDOStart();
// 预处理和绑定参数  
$email = isset($_POST['email']) ? $_POST['email'] : '';  
$password = isset($_POST['password']) ? $_POST['password'] : '';
  
$stmt = $pdo->prepare("SELECT password, email, name, cookie FROM user WHERE email = :email");  
$stmt->bindParam(':email', $email, PDO::PARAM_STR);  
$stmt->execute();  
  
$arr = $stmt->fetchAll(PDO::FETCH_ASSOC); // 使用 PDO::FETCH_ASSOC 以确保得到的是关联数组  
  
if (!empty($arr)) {  
    $shu = $arr[0];  
    if ($password != null && $shu['password'] == md5($password)) {  
        $expire = time() + 60 * 60 * 24 * 90;  
        setcookie("usercookie", $shu['cookie'], $expire,'/');  
        $_SESSION['username'] = $shu['name'];  
        header('Location: ./notice');  
        exit;  
    }  
    // 如果使用 cookie 登录  
}  
elseif (!empty($_COOKIE['usercookie'])) {  
        $cookie = $_COOKIE['usercookie'];  
        $stmt = $pdo->prepare("SELECT email, name FROM user WHERE cookie = :cookie");  
// 绑定参数 :cookie 到变量 $cookie  
        $stmt->bindParam(':cookie', $cookie);  
// 执行查询  
        $stmt->execute();  
// 获取所有结果  
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC); // 使用 PDO::FETCH_ASSOC 以关联数组形式获取结果  
        if (!empty($arr)) {  
            $shu = $arr[0];  
            $_SESSION['username'] = $shu['name'];
            header('Location: ./notice');  
            exit;  
        }  
    }  
if(isset($_POST['password']) && ($shu==array() || $shu['password'] != md5($_POST['password'])))
{
  $GLOBALS['ifregiter']=3;
}
// HTML 部分保持不变  
?>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="./icon/logo.png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>login</title>
  <link rel="stylesheet" href="./style_share.css">
  <script src="./script.js"></script>
  <script src="../flower.js"></script>
</head>
<style>
  body {
    font-family: Arial, sans-serif;
    text-align: center;
  }

  h1 {
    color: black;
  }

</style>

<body>
  <div class="beiji">
    <div class="navbar-toggle-btn" onclick="toggleNavbar()">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <nav class="navbar">
    <a href="..">
      <button class="dao">首页</button>
    </a>
    <a href=".">
      <button class="dao">登录</button>
    </a>
  </nav>

  <div class="bj"></div>
  <div class="baise">
    <h1 class="title">登录</h1>
    <form method="post" action=".">
      <input class="youxiang" type="email" name="email" placeholder="邮箱"></input>
      <input class="password" type="password" name="password" placeholder="密码"></input>
          <P class="tip" style="color: red;font-size:10px; margin-bottom:15px;">
          <?php 
          session_start();
      if((!empty($_POST['password']) || !empty($_POST['email'])) && ($_POST['password']=='' || $_POST['email']==''))
      echo '请输入完整的邮箱和密码';
      elseif(!empty($_POST) && $GLOBALS['ifregiter']==3)
      echo '密码或邮箱错误';
      ?>
      </P>
    <input type="submit" value="登录" class="login"></input>
    </form>
              <a href="../register">
      <p class="register" style="color: #4b4b4b;">
        没有账号？去注册
        </p>
        </a>
  </div>

  <div class="overlay"></div>
</body>
</html>