<!DOCTYPE html>
<?php
session_start();

?>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="./icon/logo.png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>login</title>
  <link rel="stylesheet" href="./style_share.css">
  <script src="./script.js"></script>
  <script src="../../flower.js"></script>
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
    <a href="../../">
      <button class="dao">首页</button>
    </a>
    <a href="../../login">
      <button class="dao">登录</button>
    </a>
    <?php
    if(!empty($_COOKIE['usercookie']))
    echo "<a href='../../user'>
      <button class='dao'>用户中心</button>
    </a>"
    ?>
  </nav>

  <div class="bj"></div>
  
  </div>
  <p class="title">注册成功</p>
  <p class="b">欢迎<?php session_start(); echo $_SESSION['username']; ?>来到本站喵～</p>
  <div class="overlay"></div>
</body>
</html>