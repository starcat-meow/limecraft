<!DOCTYPE html>
<?php
session_start(); // 移动到文件顶部  
include '../../header.php';
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
            if($gid!=0)
          {
            header('Location: ../');  
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
      header('Location: ../../login');  
      exit;  
    }
// 允许上传的图片后缀
if(!empty($_FILES["file"]["name"]) && !empty($_POST) && $_POST['gid']>=1 && $_POST['name'])
{
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);     // 获取文件后缀名
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 2048000)   // 小于 2000 kb
&& in_array($extension, $allowedExts))
{
    if ($_FILES["file"]["error"] > 0)
    {
        echo "错误：: " . $_FILES["file"]["error"] . "<br>";
    }
    else
    {
        $houzhui=".jpg";
        if($_FILES["file"]["type"] == "image/gif")
        $houzhui=".gif";
        if($_FILES["file"]["type"] == "image/png")
        $houzhui=".png";
        $file_mulu="https://limecraft.top/user/improve/upload/".date('Y-m-d_H-i-s').$houzhui;
        $_FILES["file"]["name"]=date('Y-m-d_H-i-s').$houzhui;
        print_r($file_mulu);
        // 判断当前目录下的 upload 目录是否存在该文件
        // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
        if (file_exists("upload/" . $_FILES["file"]["name"]))
        {
            echo $_FILES["file"]["name"] . " 文件已经存在。 ";
        }
        else
        {
            // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
        }
    }
}
else
{
    echo "非法的文件格式";
}
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
    <a href="../../">
      <button class="dao">首页</button>
    </a>
    <a href="../../login">
      <button class="dao">登录</button>
    </a>
    <?php
    if(!empty($_COOKIE['usercookie']))
    echo "<a href='../'>
      <button class='dao'>用户中心</button>
    </a>"
    ?>
  </nav>

  <div class="bj"></div>
  <div class="baise">
    <h2 class="title">完善信息</h2>
    <form method="post" action="." enctype="multipart/form-data">
      <input class="youxiang" type="text" name="name" placeholder="给自己取个好听的名称喵～" maxlength="16"></input>
      <input class="password" type="text" name="gid" placeholder="绑定UID（确定后不能更改哦～" oninput = "value=value.replace(/[^\d]/g,'')" maxlength="8"></input>
      <div class="fileuse">
        <p class="title" style="color:black;">上传头像</p>
      <input type="file" name="file" id="file" style="margin-top:10px;"><br>
      </div>
	 <P class="tip" style="color: red;font-size:10px; margin-top:15px;margin-bottom:15px;">
  <?php 
          session_start();
      if(empty($_POST['gid']) || empty($_POST['name']) || empty($_FILES))
      echo '请完整填写内容';
      elseif(!empty($GLOBALS['if']) && $GLOBALS['if']==4)
      {
      echo '未知错误，请联系星星猫meow';
      unset($GLOBALS['if']);
      }
      elseif(!empty($GLOBALS['if']) && $GLOBALS['if']==5)
      {
      echo '这个uid已经被绑定了(*￣m￣)';
      unset($GLOBALS['if']);
      }
      elseif(!empty($GLOBALS['if']) && $GLOBALS['if']==6)
      {
      echo '这个名字已经被占用了(*￣m￣)';
      unset($GLOBALS['if']);
      }
      ?>
      </P>
    <input type="submit" value="保存" class="login"></input>
    </form>
  </div>

  <div class="overlay"></div>
</body>
</html>