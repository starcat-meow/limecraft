<!DOCTYPE html>
<?php
session_start(); 
include_once '../header.php';
$pdo=PDOStart();
UserCookieTest();
$ip=GetIp();
$cookie=GetRandStr(100);
$now = date('Y-m-d H:i:s',time());
$stmt=$GLOBALS['pdo']->prepare("select * from user where register_ip = '".$ip."';");
$stmt->execute();
$arr1=$stmt->fetchALL();
if(!empty($_POST['email']))
$stmt=$GLOBALS['pdo']->prepare("select * from user where email = '".$_POST['email']."';");
$stmt->execute();
$arr2=$stmt->fetchALL();
if(empty($arr1) && empty($arr2))
{
  unset($_SESSION['ifregister']);
  if(!empty($_POST['password']) && !empty($_POST['againpassword'])&&$_POST['password']==$_POST['againpassword'] && !empty($_POST['email']))
  {
    $thenum_uid=GetUidNum();
    $email = $_POST['email'];  
$password = $_POST['password'];  
$name = 'user' . $thenum_uid; 
$gid=0;
  
// 准备 SQL 语句，使用命名参数  
$stmt = $GLOBALS['pdo']->prepare("INSERT INTO `user`(`email`, `name`, `password`, `img`, `last_date`, `register_date`, `id`, `gid`, `register_ip`, `cookie`) VALUES (:email, :name, :password, '', :last_date, :register_date, :id, :gid, :register_ip, :cookie)");  
  
// 绑定参数  
$stmt->bindParam(':email', $email);  
$stmt->bindParam(':name', $name);  
$password = $_POST['password'];  
$hashedPassword = md5($password);  
$stmt->bindParam(':password', $hashedPassword);  
$stmt->bindParam(':last_date', $now);  
$stmt->bindParam(':register_date', $now);  
$stmt->bindParam(':id', $thenum_uid);  
$stmt->bindParam(':gid', $gid);
$stmt->bindParam(':register_ip', $ip);  
$stmt->bindParam(':cookie', $cookie);  
$stmt->execute();  
    $_SESSION['username']="user".$thenum_uid;
    header('Location:./notice');
    exit;
  }
}
elseif($arr2!=array())
{
  $_SESSION['ifregister']=2;
}
elseif($arr1!=array())
{
  $_SESSION['ifregister']=1;
}
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

  p {
    color: #555;
    margin-bottom: 10px;
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
    <a href="../login">
      <button class="dao">登录</button>
    </a>
    <?php
    if(!empty($_COOKIE['usercookie']))
    echo "<a href='../user'>
      <button class='dao'>用户中心</button>
    </a>"
    ?>
  </nav>

  <div class="bj"></div>
  <div class="baise">
    <h1 class="title">注册</h1>
    <form method="post" action=".">
      <input class="youxiang" type="email" name="email" placeholder="邮箱"></input>
    <input class="password" type="password" name="password" placeholder="密码"></input>
    <input class="password" type="password" name="againpassword" placeholder="再次输入密码"></input>
      <P class="tip" style="color: red;font-size:10px; margin-bottom:15px;">
          <?php 
          session_start(); 
      if(!empty($_POST) && ($_POST['password']=='' || $_POST['email']=='' || $_POST['againpassword']==''))
      echo '请输入完整的邮箱和密码';
      elseif(!empty($_POST) && $_POST['password']!=$_POST['againpassword'])
      echo '两次输入的密码不相同';
      elseif(!empty($_POST) && !empty($_SESSION['ifregister']) && $_SESSION['ifregister']==2)
      echo '该邮箱已被注册';
      elseif(!empty($_POST) && !empty($_SESSION['ifregister']) && $_SESSION['ifregister']==1)
      echo '你所在的ip已注册过一个账号';
      ?>
      </P>
    <input type="submit" value="注册" class="login"></input>
    </form>
    <a href="../login">
      <p class="register">
        已有账号？去登录
        </p>
        </a>
  </div>

  <div class="overlay"></div>
  <br>
  <br>
</body>

</html>