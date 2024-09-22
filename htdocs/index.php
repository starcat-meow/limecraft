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
include './header.php';
$pdo=PDOStart();
$stmt = $pdo->prepare("SELECT id,title,text,date,post_username,post_useravatar FROM article ORDER BY id BETWEEN ? AND ?");  
$stmt->bindParam(1, $begin, PDO::PARAM_STR);  
$stmt->bindParam(2, $end, PDO::PARAM_STR);  
$stmt->execute();  

for($i=0;$i<8;$i++)
echo "<div class='post-box'>
        <div class='post'>  
    <div class='post-header'>  
        <img src='https://limecraft.top/user/improve/upload/2024-09-17_21-33-30.jpg' alt='用户头像' class='post-avatar'>  
        <div class='post-meta'>  
            <h3 class='post-name'>用户名</h3>  
            <p class='post-date'>发布日期: 2024-09-21</p>
        </div>  
            <div class='post-content'>  
        <h2 class='post-title'>文章标题</h2>  
        <p class='post-text' id='post-text'>这里是帖子的正文内容，这里是帖子的正文内容这里是帖子的正文内容可以很长很长这里是帖子的正文内容，可以很长很长这里是帖子的正文内容，这里是帖子的正文内容这里是帖子的正文内容可以很长很长这里是帖子的正文内容，可以很长很长</p>  
    </div>  
    </div>

    </div>  ";
?>
<div class="page_change">
<a>
  <button>上一页</button>
</a>
<form enctype='multipart/form-data' method='get' action="" id='form'>
  <select name='page' id='page' onchange='ToChangePage()'>
<?php
$pdo=PDOStart();
$stmt = $pdo->prepare("SELECT id FROM article"); 
$stmt->execute(); 
$arr = $stmt->fetchAll(); 
$shu=$arr[0];
$num_article=count($shu)-1;
$num_for=$num_article/8+1;//计算文章页数
for($i=1;$i<=$num_for;$i++)
{
$selected=( $_GET['page'] == $i ? 'selected' : '');
//判断get页数并让下拉框选中当前页数～
echo "<option value='{$i}' {$selected}>第 {$i} 页</option>";
}
?>
  </select>
</form>
<a>
  <button>下一页</button>
</a>
</div>
  </div>
  
</body> 

</html>