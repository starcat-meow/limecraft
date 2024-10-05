<!DOCTYPE html>
<?php
include_once '../header.php';
if (!session_id()) session_start(); // 移动到文件顶部  
$pdo=PDOStart();
UserCookieTest();
time_ip_update();
if (!empty($_COOKIE['usercookie'])) {  
        $cookie = $_COOKIE['usercookie'];  
    if(!empty($_GET['id']))
    {
        $stmt = $pdo->prepare("SELECT img,name,gid FROM user WHERE id = ?");  
       $stmt->bindParam(1, $_GET['id'], PDO::PARAM_STR);  
    }
    else
    {
       $stmt = $pdo->prepare("SELECT img,name,gid,id FROM user WHERE cookie = ?");  
       $stmt->bindParam(1, $cookie, PDO::PARAM_STR);  
    }
       $stmt->execute();  
       $arr = $stmt->fetchAll();  
        $shu = $arr[0]; 
        if($shu['id']!=1)
        {
         print_r("404 NO FOUND");
         exit;
        }
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
    for($i=0;$i<8;$i++)
    {
    $a[$i]['id']=0;
    $a[$i]['content']="none";
    $a[$i]['reward']=0;
    $a[$i]['cycle']='day';
    $a[$i]['datetime']=date("Y-m-d H:i:s");
    $a[$i]['state']=false;
    }
    //print_r(json_encode($a));
?>

<html>

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="./icon/logo.png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>login</title>
  <link rel="stylesheet" href="./style_share.css?version=<?php echo date('YmdHi'); ?>">
  <script src="./script.js?version=<?php echo date('YmdHi'); ?>"></script>
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
  <p>快捷导航</p>
    <a href="../">
    <button class="menu-btn">首页</button>
    </a>
    <?php
    echo "<a href='../login'>
      <button class='menu-btn'>登录</button>
    </a>"
    ?>
    <?php
    echo "<a href='../register'>
      <button class='menu-btn'>注册</button>
    </a>"
    ?>
    <?php
    echo "<a href='../post'>
      <button class='menu-btn'>发布</button>
    </a>"
    ?>
    <?php
    echo "<a href='../user'>
      <button class='menu-btn'>用户中心</button>
    </a>"
    ?>
    <?php
    echo "<a href='./'>
      <button class='menu-btn'>后台管理</button>
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

  <div class="userbar">
  <ul class="tabs">  
    <li class="tab" onclick="showContent(0)">个人信息</li>  
    <li class="tab" onclick="showContent(1);ds();">编辑用户</li> 
    <li class="tab" onclick="showContent(2);">编辑任务</li> 
    <li class="tab" onclick="showContent(3)">发送通知</li>
    <li class="tab" onclick="showContent(4)">管理通知</li> 
    <li class="tab" onclick="showContent(5)">编辑信用</li> 
</ul>  
  
<div id="content1" class="content active">  
    <p><?php 
      $user=GetUserData();
      if($user!=false)
      {
        echo "<p>用户名:{$user['name']}</p>";
        echo "<p>UID:{$user['id']}</p>";
        echo "<p>GID:{$user['gid']}</p>";
        echo "<p>注册日期:{$user['register_date']}</p>";
        echo "<p>最近访问:{$user['last_date']}</p>";
        echo "<p>发布过的帖子:{$user['tie_post']}</p>";
        echo "<p>发布过的评论:{$user['ping_post']}</p>";
        echo "<p>注册IP:{$user['register_ip']}</p>";
        echo "<p>最近访问IP:{$user['last_ip']}</p>";
      }
    ?></p>  
</div>  
<div id="content2" class="content">  
<div class="progress-circle">
  <svg>
    <circle stroke="var(--inactive-color)" 
            style="stroke-dasharray: calc(3.1415 * var(--r) * var(--active-degree) / 180),
                                     calc(3.1415 * var(--r) * var(--gap-degree) / 180)" 
    />
    <circle stroke="var(--color)"
            class="progress-value"
            style="stroke-dasharray:calc(3.1415 * var(--r) * var(--percent) * var(--active-degree) / 180 / 100), 1000"
            />
  </svg>
  
</div>

</div>  
<div id="content3" class="content">  
  <ol>
    <?php 
    for($i=1;$i<=8;$i++)
    {
    echo "<li class='task-box'>
    <p class='task-text'>{$i}.<input type='text' value='none' placeholder='内容'>
    <input type='text' placeholder='周期'>
    <input type='text' placeholder='奖励'>
    <input type='text' placeholder='任务事件id'>
      <button class='finish'>发布任务</button>
    </p>
    </li>
  </ol>";
    }
    ?>
  
</div>  
<div id="content4" class="content">  
 
</div>  
  </div>
</body>
<script>
function ds(){
  document.documentElement.style.setProperty('--percent', <?php
  $userdata=GetUserData();
  echo $userdata['credit'];
    ?>);
}
</script>
</html>