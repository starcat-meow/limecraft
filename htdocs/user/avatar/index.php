<!DOCTYPE html>
<?php
session_start(); // 移动到文件顶部  
$pdo=new PDO('mysql:host=localhost;dbname=admin','admin','flyusb123',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
if (!empty($_COOKIE['usercookie'])) {  
        $cookie = $_COOKIE['usercookie'];  
        $stmt = $pdo->prepare("SELECT name,gid FROM user WHERE cookie = ?");  
  $stmt->bindParam(1, $cookie, PDO::PARAM_STR);  
        $stmt->execute();  
        $arr = $stmt->fetchAll();  
        $shu=$arr[0];
        $gid=$shu['gid'];
        if (empty($gid)) {  
           echo "该网站拒绝访问，别想没登录就进(嘿嘿" ;
           exit;
        }
    }  
    else
    {
      header('Location: ../../login');  
      exit;  
    }
// 允许上传的图片后缀
if(!empty($_FILES["file"]["name"]))
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
$stmt = $pdo->prepare("UPDATE `user` SET `img` = ? WHERE cookie = ?");  
    $stmt->bindParam(1, $file_mulu, PDO::PARAM_STR);
    $stmt->bindParam(2, $_COOKIE['usercookie'], PDO::PARAM_STR);  
  
    // 执行语句  
    $stmt->execute();
    header('Location: ../');  
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
    </a>";
    ?>
  </nav>

  <div class="bj"></div>
  <div class="baise">
    <h2 class="title">更改头像</h2>
    <form method="post" action="." enctype="multipart/form-data">
      <div class="fileuse">
        <p class="title" style="color:black;">上传头像</p>
      <input type="file" name="file" id="file" style="margin-top:10px;"><br>
<!--       <img src="<?php $src='img/'; $ufile=$_FILES['ufile']; echo $src.$ufile ?>" style="width:50%";></img>
-->
      </div>
	 <P class="tip" style="color: red;font-size:10px; margin-top:15px;margin-bottom:15px;">
  <?php 
          session_start();
      if(empty($_POST['photo']))
      echo '请上传图片';
      elseif(!empty($GLOBALS['if']) && $GLOBALS['if']==4)
      {
      echo '未知错误，请联系星星猫meow';
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