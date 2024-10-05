<!DOCTYPE html>
<?php
if (!session_id()) session_start();
include '../header.php';
$pdo = PDOStart();
UserCookieTest();
$ip = GetIp();
$cookie = GetRandStr(100);
$now = date('Y-m-d H:i:s', time());
$stmt = $GLOBALS['pdo']->prepare("select * from user where register_ip = '".$ip."';");
$stmt->execute();
$arr1 = $stmt->fetchALL();
if (!empty($_POST['email']))
  $stmt = $GLOBALS['pdo']->prepare("select * from user where email = '".$_POST['email']."';");
$stmt->execute();
$arr2 = $stmt->fetchALL();
if (empty($arr1) && empty($arr2)) {
  unset($_SESSION['ifregister']);
  if (!empty($_POST['password']) && !empty($_POST['againpassword']) && $_POST['password'] == $_POST['againpassword'] && !empty($_POST['email'])) {
    $thenum_uid = GetUidNum();
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = 'user' . $thenum_uid;
    $gid = 0;

    // 准备 SQL 语句，使用命名参数
    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO `user`(`email`, `name`, `password`, `img`, `last_date`, `register_date`, `id`, `gid`, `register_ip`, `cookie`, `tie_post`, `ping_post`, `last_ip`, `subscribe`, `subscribed`, `collection`, `message`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

    // 绑定参数
    $stmt->bindParam(1, $email);
    $stmt->bindParam(2, $name);
    $password = $_POST['password'];
    $hashedPassword = md5($password);
    $stmt->bindParam(3, $hashedPassword);
    $img="../icon/logo.png";
    $stmt->bindParam(4, $img);
    $stmt->bindParam(5, $now);
    $stmt->bindParam(6, $now);
    $stmt->bindParam(7, $thenum_uid);
    $stmt->bindParam(8, $gid);
    $stmt->bindParam(9, $ip);
    $stmt->bindParam(10, $cookie);
    $num_0=0;
    $stmt->bindParam(11, $num_0);
    $stmt->bindParam(12, $num_0);
    $stmt->bindParam(13, $ip);
    $json="{}";
    $stmt->bindParam(14, $json);
    $stmt->bindParam(15, $json);
    $stmt->bindParam(16, $json);
    $message=FirstMessage();
    $stmt->bindParam(17, $message);
    $stmt->execute();
    $_SESSION['username'] = "user".$thenum_uid;
    header('Location:./notice');
    exit;
  }
} elseif (!empty($arr2)) {
  $_SESSION['ifregister'] = 2;
} elseif (empty($arr1)) {
  $_SESSION['ifregister'] = 1;
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
<div class="menu-box" id="MenuBox">
    <a href="../">
    <button class="menu-btn">首页</button>
    </a>
    <?php
    if(empty($_COOKIE['usercookie']))
    echo "<a href='./login'>
      <button class='menu-btn'>登录</button>
    </a>"
    ?>
    <?php
    if(!empty($_COOKIE['usercookie']))
    echo "<a href='./post'>
      <button class='menu-btn'>发布</button>
    </a>"
    ?>
    <?php
    if(!empty($_COOKIE['usercookie']))
    echo "<a href='./user'>
      <button class='menu-btn'>用户中心</button>
    </a>"
    ?>
  </div>
  <div id="main">
    <div class="div-menu">
      <div class="black-layer"></div>
      <div class="menuclose" id="menuClose"></div>
      <div class="menucloseclick" onclick="MenuOn();" id="menulose"></div>
      <div class="btn" onclick="MenuOn();"></div>
      <div class="beiji">
        <div class="navbar-toggle-btn" onclick="MenuOn();" id="menubutton">
          <span></span>
          <span></span>
         <span></span>
       </div>
      </div>
    </div>
  <div class="bj"></div>
  <div class="baise">
    <h1 class="title">注册</h1>
    <form method="post" action=".">
      <input class="youxiang" type="email" name="email" placeholder="邮箱"></input>
      <input class="password" type="password" name="password" placeholder="密码"></input>
      <input class="password" type="password" name="againpassword" placeholder="再次输入密码"></input>
      <P class="tip" style="color: red;font-size:10px; margin-bottom:15px;">
        <?php
        if (!empty($_POST) && ($_POST['password'] == '' || $_POST['email'] == '' || $_POST['againpassword'] == ''))
          echo '请输入完整的邮箱和密码';
        elseif (!empty($_POST) && $_POST['password'] != $_POST['againpassword'])
          echo '两次输入的密码不相同';
        elseif (!empty($_POST) && !empty($_SESSION['ifregister']) && $_SESSION['ifregister'] == 2)
          echo '该邮箱已被注册';
        elseif (!empty($_POST) && !empty($_SESSION['ifregister']) && $_SESSION['ifregister'] == 1)
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
</div>
</body>

</html>