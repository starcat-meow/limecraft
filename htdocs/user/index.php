<!DOCTYPE html>
<?php
include_once '../header.php';
if (!session_id())
  session_start(); // 移动到文件顶部  
$pdo = PDOStart();
UserCookieTest();
time_ip_update();
if (!empty($_COOKIE['usercookie'])) {
  $cookie = $_COOKIE['usercookie'];
  if (!empty($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT img,name,gid FROM user WHERE id = ?");
    $stmt->bindParam(1, $_GET['id'], PDO::PARAM_STR);
  } else {
    $stmt = $pdo->prepare("SELECT img,name,gid FROM user WHERE cookie = ?");
    $stmt->bindParam(1, $cookie, PDO::PARAM_STR);
  }
  $stmt->execute();
  $arr = $stmt->fetchAll();
  $shu = $arr[0];
  if ($shu['img'] != '')
    $GLOBALS["img"] = $shu['img'];
  else
    $GLOBALS["img"] = '../icon/logo.png';
  $GLOBALS["name"] = $shu['name'];
  if (!empty($arr)) {
    $shu = $arr[0];
    $_SESSION['username'] = $shu['name'];
    $gid = $shu['gid'];
    if ($gid == 0 && empty($_GET['id'])) {
      header('Location: ./improve');
      exit;
    }
  } else {
    unset($_COOKIE['usercookie']);
    exit;
  }
} else {
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
    <a href="../">
      <button class="menu-btn">首页</button>
    </a>
    <?php
    if (empty($_COOKIE['usercookie']))
      echo "<a href='../login'>
      <button class='menu-btn'>登录</button>
    </a>"
        ?>
      <?php
    if (!empty($_COOKIE['usercookie']))
      echo "<a href='../post'>
      <button class='menu-btn'>发布</button>
    </a>"
        ?>
      <?php
    if (!empty($_COOKIE['usercookie']))
      echo "<a href='../user'>
      <button class='menu-btn'>用户中心</button>
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
      <button class="editor">编辑</button>
      <div class="img-box">
        <a href="./avatar">
          <img src="<?php echo $GLOBALS["img"]; ?>" class="img" draggable="flase">
        </img>
      </a>
      <p class="username">
        <?php echo $GLOBALS["name"]; ?>
      </p>
      <p class="uid">
        <?php $text = "GID:" . $GLOBALS["gid"] . "";
        echo $text; ?>
      </p>
    </div>
    <div class="userbar">
      <ul class="tabs">
        <li class="tab" onclick="showContent(0)">个人信息</li>
        <li class="tab" onclick="showContent(1);ds();">信用度</li>
        <li class="tab" onclick="showContent(2);">任务</li>
        <li class="tab" onclick="showContent(3)">我发布的</li>
        <li class="tab" onclick="showContent(4)">我的消息
        <span class='unread-messages' id='unreadMessages'>
        <?php
        $message = new Message();
        $message->GetById(GetId());
        if($message->GetNoRead()>0)
          echo $message->GetNoRead();
        else
          echo "<style>
          #unreadMessages
          {
            display:none;
            
          }
          </style>";
        ?>
        </span>
      </li>       
        <li class="tab" onclick="showContent(5)">我的订阅</li>
      </ul>
      <div id="content1" class="content">
        <p>
          <?php
          $user = GetUserData();
          if ($user != false) {
            echo "<p>用户名:{$user['name']}</p>";
            echo "<p>ID:{$user['id']}</p>";
            echo "<p>GID:{$user['gid']}</p>";
            echo "<p>注册日期:{$user['register_date']}</p>";
            echo "<p>最近访问:{$user['last_date']}</p>";
            echo "<p>发布过的帖子:{$user['tie_post']}</p>";
            echo "<p>发布过的评论:{$user['ping_post']}</p>";
            echo "<p>注册IP:{$user['register_ip']}</p>";
            echo "<p>最近访问IP:{$user['last_ip']}</p>";
          }
          ?>
        </p>
      </div>
      <div id="content2" class="content">
        <div class="progress-circle">
          <svg>
            <circle stroke="var(--inactive-color)" style="stroke-dasharray: calc(3.1415 * var(--r) * var(--active-degree) / 180),
                                     calc(3.1415 * var(--r) * var(--gap-degree) / 180)" />
            <circle stroke="var(--color)" class="progress-value"
              style="stroke-dasharray:calc(3.1415 * var(--r) * var(--percent) * var(--active-degree) / 180 / 100), 1000" />
          </svg>

        </div>

      </div>
      <div id="content3" class="content">
        <ol>
          <li class="task-box">
            <p class="task-text">1.每日签到 +1
              <button class="finish" style="<?php echo "background-color:green;" ?>">完成任务</button>
            </p>
          </li>
          <li class="task-box">
            <p class="task-text">2.完善个人信息 +20
              <button class="finish">完成任务</button>
            </p>
          </li>
        </ol>
      </div>
      <div id="content4" class="content">
        <?php
        $post = new PostList();
        $pdo = PDOStart();
        if (empty($_POST['page']) || !is_numeric($_POST['page']) || $_POST['page'] < 1) {
          $_POST['page'] = 1;
        }
        $perPage = 8; // 每页显示的记录数  
        $begin = ($_POST['page'] - 1) * $perPage;
        $end = $begin + $perPage - 1;
        $stmt = $pdo->prepare("SELECT id, title, text, date, post_username, post_useravatar FROM article WHERE post_userid = ? ORDER BY id DESC LIMIT ? , ?");
        $id = GetId();
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $begin, PDO::PARAM_INT);
        $stmt->bindParam(3, $perPage, PDO::PARAM_INT);
        $stmt->execute();
        $arr = $stmt->fetchAll();
        $post->setPosts($arr);
        $post->renderPosts();

        ?>
        <form method="post" action="." style="" id="form">
          <div class="page_change">
            <button class="ChangePage" onclick="fh()">←</button>
            <input id="page" name="page" class="pagechange" type="number" value="<?php
            echo $_POST['page'];
            ?>" onfocus="pageFocus()" onblur="pageBlur()" style=""></input>
            <input class="ChangePage" type="submit" value=">>" id="go" style="margin-right:0;"></input>
            <button class="ChangePage" onclick="xyg()">→</button>

          </div>
        </form>
      </div>
      <div id="content5" class="content">
        <?php
        $message = new Message();
        $message->GetById(GetId());
        $message->Render();
        ?>
      </div>
    </div>
</body>
<script>
  function ds() {
    document.documentElement.style.setProperty('--percent', <?php
    $userdata = GetUserData();
    echo $userdata['credit'];
    ?>);
  }
  let post = <?php echo $_POST['page'] ?>;
  if (post > 1) {
    showContent(3);
  }
</script>

</html>