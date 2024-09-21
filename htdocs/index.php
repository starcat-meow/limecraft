<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="./icon/logo.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LimeCraft</title>
  <link rel="stylesheet" href="./style.css">
  <script src="./script.js"></script>
  <script src="./flower.js"></script>
</head>
<script>
</script>


<body>
  <div class="black-board"></div>
  <div class="beiji">
    <div class="navbar-toggle-btn" onclick="toggleNavbar()">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="huadong">
    <div class="overlay"></div>
    <div class="bj"></div>
    <div class="baise"></div>
    <nav class="navbar">
      <a href=".">
        <button class="dao">首页</button>
      </a>
      <a href="./login">
        <button class="dao">登录</button>
      </a>
    <?php
    if(!empty($_COOKIE['usercookie']))
    echo "<a href='./user'>
      <button class='dao'>用户中心</button>
    </a>"
    ?>
    </nav>
    <div class="title">
      <p class="title">LimeCraft</p>
    </div>
    <a href="https://www.bilibili.com/video/BV1GJ411x7h7/?spm_id_from=333.337.search-card.all.click&vd_source=44fa48c3eecc09542e1a1f8cf45755d8" id="none-line">
      <button class="download">More</button>
    </a>
</div>
<?php
for($i;$i<=10;$i++)
echo "         <div class='post-box'>
        <div class='post'>  
    <div class='post-header'>  
        <img src='./icon/logo.png' alt='用户头像' class='post-avatar'>  
        <div class='post-meta'>  
            <h3 class='post-name'>用户名</h3>  
            <p class='post-date'>发布日期: 2023-04-01</p>
        </div>  
            <div class='post-content'>  
        <h2 class='post-title'>帖子标题</h2>  
        <p class='post-text' id='post-text'>这里是帖子的正文内容，这里是帖子的正文内容这里是帖子的正文内容可以很长很长这里是帖子的正文内容，可以很长很长这里是帖子的正文内容，这里是帖子的正文内容这里是帖子的正文内容可以很长很长这里是帖子的正文内容，可以很长很长</p>  
    </div>  
    </div>

    </div>  ";
?>
  </div>
  
</body> 

</html>