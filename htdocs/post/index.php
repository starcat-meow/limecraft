<!DOCTYPE html>
<?php
include_once '../header.php';
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
?>
<?php
session_start(); // 移动到文件顶部  
$pdo=PDOStart();
UserCookieTest();
if (!empty($_COOKIE['usercookie'])) {  
        $cookie = $_COOKIE['usercookie'];  
        $stmt = $pdo->prepare("SELECT name,gid FROM user WHERE cookie = ?");  
  $stmt->bindParam(1, $cookie, PDO::PARAM_STR);  
        $stmt->execute();  
        $arr = $stmt->fetchAll();  
        $shu=$arr[0];
        $gid=$shu['gid'];
        if (!empty($arr)) {  
            $shu = $arr[0];  
            $_SESSION['username'] = $shu['name'];
        }
        else
        {
          unset($_COOKIE['usercookie']);
          exit; 
        }
    }  
    else
    {
      header('Location: ../../login');  
      exit;  
    }
if(!empty($_POST) && $_POST['gid']>=1 && $_POST['name'])
{
$stmt = $pdo->prepare("SELECT name,gid FROM user WHERE gid = ?");  
  $stmt->bindParam(1, $_POST['gid'], PDO::PARAM_STR);  
        $stmt->execute();  
        $arr = $stmt->fetchAll();  
if(empty($arr))
        {
          $stmt = $pdo->prepare("SELECT name,gid FROM user WHERE name = ?");  
  $stmt->bindParam(1, $_POST['name'], PDO::PARAM_STR);  
    // 绑定参数  
        $stmt->execute();  
        $arr = $stmt->fetchAll(); 
        if(empty($arr))
        {
$stmt = $pdo->prepare("UPDATE `user` SET `name` = ? ,`img` = ?, `gid` = ? WHERE cookie = ?");  
  $stmt->bindParam(1, $_POST['name'], PDO::PARAM_STR);  
    // 绑定参数  
    $stmt->bindParam(2, $file_mulu, PDO::PARAM_STR);  
    $stmt->bindParam(3, $_POST['gid'], PDO::PARAM_INT); // 假设gid是整数，如果不是，请使用PDO::PARAM_STR  
    $stmt->bindParam(4, $_COOKIE['usercookie'], PDO::PARAM_STR);  
  
    // 执行语句  
    $stmt->execute();
    header('Location: ../');  
            exit; 
        }
        else
        {
          $GLOBALS['if']=6;
        }
}
else
{
  $GLOBALS['if']=5;
}
}
else
{
  $GLOBALS['if']=4;
}
?>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="./icon/logo.png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>发表帖子</title>
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
    <div class="menu-box" id="MenuBox">
    <a href="./">
    <button class="menu-btn">首页</button>
    </a>
    <a href="../login">
    <button class="menu-btn">登录</button>
    </a>
    <?php
    if(!empty($_COOKIE['usercookie']))
    echo "<a href='../user'>
      <button class='menu-btn'>用户中心</button>
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
  <form method="post" action=".">
  <input type="text" class="title" name="title" placeholder="标题"></input>
  <textarea></textarea>
  <input type="submit" value="发布" class="login"></input>
  </form>
</body>
</html>