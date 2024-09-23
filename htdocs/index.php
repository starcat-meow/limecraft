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
$pdo = PDOStart();  
  
if (empty($_GET['page']) || !is_numeric($_GET['page']) || $_GET['page'] < 1) {  
    $_GET['page'] = 1;  
}  
  
$perPage = 8; // 每页显示的记录数  
$begin = ($_GET['page'] - 1) * $perPage;  
$end = $begin + $perPage - 1;  
  
// 首先，我们不需要先查询所有id来计算总数（这会很慢且不必要），除非你需要它来做其他事情  
// 但为了分页显示，我们只需要确保$end不超过实际的最大id  
  
// 假设我们不知道最大id，我们可以先查询一个足够大的id（比如最大id），但这里我们简化处理  
// 实际上，你可能需要在另一个查询中先获取最大id，或者使用LIMIT和OFFSET进行分页，而不需要BETWEEN  
  
// 使用LIMIT和OFFSET进行分页（推荐方式）  
$stmt = $pdo->prepare("SELECT id, title, text, date, post_username, post_useravatar FROM article ORDER BY id DESC LIMIT :offset, :limit");  
$stmt->bindParam(':offset', $begin, PDO::PARAM_INT);  
$stmt->bindParam(':limit', $perPage, PDO::PARAM_INT);  
$stmt->execute();  
$arr = $stmt->fetchAll();  
  
// 如果需要显示总页数或进行其他基于总数的计算，可以单独查询总数  
// $stmt = $pdo->prepare("SELECT COUNT(id) AS total FROM article");  
// $stmt->execute();  
// $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];  
// $totalPages = ceil($total / $perPage);  
  
print_r($arr);
for($i=0;$i<8;$i++)
{
$shu=$arr[$i];
if(empty($shu))
  break;
echo "<div class='post-box'>
        <div class='post'>  
    <div class='post-header'>  
        <img src='".$shu['post-avatar']."' alt='用户头像' class='post-avatar'>  
        <div class='post-meta'>  
            <h3 class='post-name'>".$shu['post_username']."</h3>  
            <p class='post-date'>发布日期:".$shu['date']."</p>
        </div>  
            <div class='post-content'>  
        <h2 class='post-title'>".$shu['title']."</h2>  
        <p class='post-text' id='post-text'>".$shu['text']."</p>  
    </div>  
    </div>

    </div>  ";
}
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
$num_article=count($arr);
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