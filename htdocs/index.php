<!DOCTYPE html>
<?php
include_once './header.php';
$pdo=PDOStart();
UserCookieTest();
if (!empty($_COOKIE['usercookie'])) {  
        $cookie = $_COOKIE['usercookie'];  
       $stmt = $pdo->prepare("SELECT img,name,gid FROM user WHERE cookie = ?");  
       $stmt->bindParam(1, $cookie, PDO::PARAM_STR);  
       $stmt->execute();  
       $arr = $stmt->fetchAll();  
        $shu = $arr[0]; 
        if($shu['img']!='')
           $GLOBALS["img"]=$shu['img'];
        else
          $GLOBALS["img"]='../icon/logo.png';
        if (empty($arr)) {  
           $GLOBALS["img"]='../icon/logo.png';
            exit; 
        }
    }  
$pdo=PDOStart();
$stmt = $pdo->prepare("SELECT id FROM article"); 
$stmt->execute(); 
$arr = $stmt->fetchAll(); 
$num_article=count($arr);
$num_for=(int)(($num_article-1)/8+1);//计算文章页数
$page = (int)($_GET['page']);
if ($page < 1) {  
    $page = 1; // 如果页码小于1，则重置为1  
} elseif ($page > $num_for) {  
    $page = $num_for; //如果页码大于最大页码，则设置为最大页码  
} 
// 如果当前页码不是用户请求的页码，则进行重定向  
if ($page != $_GET['page'] ?? null) { // 使用 null 合并运算符处理未设置的 $_GET['page']  
    header("Location: ./?page=" . $page);  
    exit;  
}  
?>
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
  <div class="menu-box" id="MenuBox">
    <a href="./">
    <button class="menu-btn">首页</button>
    </a>
    <a href="../login">
    <button class="menu-btn">登录</button>
    </a>
    <?php
    if(!empty($_COOKIE['usercookie']))
    echo "<a href='./user'>
      <button class='menu-btn'>用户中心</button>
    </a>"
    ?>
    <?php
    if(!empty($_COOKIE['usercookie']))
    echo "<a href='./post'>
      <button class='menu-btn'>发布</button>
    </a>"
    ?>
  </div>
  <div class="black-layer"></div>
  <div class="user-click" onmousemove="UserOn()"></div>
  <img class="useravatar" src="<?php echo $GLOBALS["img"];?>">
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
  <div class="huadong">
    <div class="overlay"></div>
    <div class="bj"></div>
    <div class="baise"></div>
    <div class="title">
      <h1 class="title">LimeCraft</h1>
    </div>
    <a href="https://www.bilibili.com/video/BV1GJ411x7h7/?spm_id_from=333.337.search-card.all.click&vd_source=44fa48c3eecc09542e1a1f8cf45755d8" id="none-line">
      <button class="download">More</button>
    </a>
</div>
  <div class="black-board">
<?php
$pdo = PDOStart();  
if (empty($_GET['page']) || !is_numeric($_GET['page']) || $_GET['page'] < 1) {  
    $_GET['page'] = 1;  
}  
$perPage = 8; // 每页显示的记录数  
$begin = ($_GET['page'] - 1) * $perPage;  
$end = $begin + $perPage - 1;  
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
$post=new PostList();
$post->setPosts($arr);
$post->renderPosts();
?>

<form method="get" action="." style="" id="form">
<div class="page_change">
  <button class="ChangePage" onclick="fh()">←</button>
<input id="page" name="page" class="pagechange" type="number" value="<?php
  echo $_GET['page'];
  ?>" onfocus="pageFocus()" onblur="pageBlur()" style=""></input>
  <input class="ChangePage" type="submit" value=">>" id="go" style="margin-right:0;"></input>
  <button class="ChangePage" onclick="xyg()">→</button>

</div>
</form>
  </div>
<div class="introduce">
  <p></p>
</div>
</body> 
<script>
function fh() {  
  var but = document.getElementById('page');  
  var currentPage = parseInt(but.value, 10);  
  if (currentPage > 1) { // 确保不会变成0或负数  
    but.value = currentPage - 1;  
    document.getElementById('form').submit();  
  }  
}  
  
function xyg() {  
  var but = document.getElementById('page');  
  var currentPage = parseInt(but.value, 10);  
  but.value = currentPage + 1;  
  document.getElementById('form').submit();  
}
</script>
</html>