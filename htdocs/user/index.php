<!DOCTYPE html>
<?php
include_once '../header.php';
session_start(); // 移动到文件顶部  
$pdo=PDOStart();
UserCookieTest();
if (!empty($_COOKIE['usercookie'])) {  
        $cookie = $_COOKIE['usercookie'];  
    if(!empty($_GET['id']))
    {
        $stmt = $pdo->prepare("SELECT img,name,gid FROM user WHERE id = ?");  
       $stmt->bindParam(1, $_GET['id'], PDO::PARAM_STR);  
    }
    else
    {
       $stmt = $pdo->prepare("SELECT img,name,gid FROM user WHERE cookie = ?");  
       $stmt->bindParam(1, $cookie, PDO::PARAM_STR);  
    }
       $stmt->execute();  
       $arr = $stmt->fetchAll();  
        $shu = $arr[0]; 
        if($shu['img']!='')
           $GLOBALS["img"]=$shu['img'];
        else
          $GLOBALS["img"]='../icon/logo.png';
        $GLOBALS["name"]=$shu['name'];
        if (!empty($arr)) {  
            $shu = $arr[0];  
            $_SESSION['username'] = $shu['name'];
            $gid=$shu['gid'];
            if($gid==0 && empty($_GET['id']))
          {
            header('Location: ./improve');  
            exit; 
          }
        }
        else
        {
          unset($_COOKIE['usercookie']);
            exit; 
        }
    }  
    else
    {
      header('Location: ../login');  
      exit;  
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

</style>

<body>
    <div class="menu-box" id="MenuBox">
    <a href="../">
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
  <button class="editor">编辑</button>
  <div class="black-layer"></div>
  <div class="user-click" onmousemove="UserOn()"></div>
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

  <div class="img-box">
    <a href="./avatar">
    <img src="<?php echo $GLOBALS["img"]; ?>" class="img" draggable="flase">
    </img>
    </a>
    <p class="username"><?php echo $GLOBALS["name"]; ?></p>
        <p class="uid">
          <?php $text="UID:".$GLOBALS["gid"].""; echo $text; ?>
          </p>
  </div>
</body>
</html>