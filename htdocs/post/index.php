<!DOCTYPE html>
<?php
include_once '../header.php';
$pdo = PDOStart();
UserCookieTest();
if (!empty($_COOKIE['usercookie'])) {
  $cookie = $_COOKIE['usercookie'];
  $stmt = $pdo->prepare("SELECT img,name,gid FROM user WHERE cookie = ?");
  $stmt->bindParam(1, $cookie, PDO::PARAM_STR);
  $stmt->execute();
  $arr = $stmt->fetchAll();
  $shu = $arr[0];
  if ($shu['img'] != '') {
    $GLOBALS["img"] = $shu['img'];
  } else
    $GLOBALS["img"] = '../icon/logo.png';
  if (empty($arr)) {
    exit;
  }
}
?>
<?php
session_start(); // 移动到文件顶部
$pdo = PDOStart();
UserCookieTest();
if (!empty($_COOKIE['usercookie'])) {
  $cookie = $_COOKIE['usercookie'];
  $stmt = $pdo->prepare("SELECT img,name,gid FROM user WHERE cookie = ?");
  $stmt->bindParam(1, $cookie, PDO::PARAM_STR);
  $stmt->execute();
  $arr = $stmt->fetchAll();
  $shu = $arr[0];
  $gid = $shu['gid'];
  $GLOBALS["img"] = $shu['img'];
  if (!empty($arr)) {
    $shu = $arr[0];
  } else
  {
    unset($_COOKIE['usercookie']);
    exit;
  }
} else
{
  header('Location: ../../login');
  exit;
}
if (!empty($_POST)) {
  $stmt = $pdo->prepare("SELECT name,gid,img FROM user WHERE cookie = ?");
  $stmt->bindParam(1, $_COOKIE['usercookie'], PDO::PARAM_STR);
  // 绑定参数
  $stmt->execute();
  $arr = $stmt->fetchAll();
  $shu=$arr[0];
  $GLOBALS['gid'] = $shu['gid'];
  $GLOBALS['name'] = $shu['name'];
  $GLOBALS['img'] = $shu['img'];
  $GLOBALS['date_time'] = date("Y-m-d H:i:s");
  if (!empty($arr)) {
    $stmt = $pdo->prepare("INSERT INTO `article`(`id`, `title`, `text`, `date`, `last_date`, `post_userid`, `permissions`, `comments`, `thumbs_up`, `collection`, `post_username`, `post_useravatar`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
    $id=114;
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    // 绑定参数
    $stmt->bindParam(2, $_POST['title'], PDO::PARAM_STR);
    $stmt->bindParam(3, $_POST['text'], PDO::PARAM_STR); // 假设是整数用int，如果不是，请使用PDO::PARAM_STR
    $stmt->bindParam(4, $GLOBALS['date_time'], PDO::PARAM_STR);
    $stmt->bindParam(5, $GLOBALS['date_time'], PDO::PARAM_STR);
    $stmt->bindParam(6, $GLOBALS['gid'], PDO::PARAM_INT);
    $stmt->bindParam(7, $id, PDO::PARAM_INT);
    $stmt->bindParam(8, $id, PDO::PARAM_STR);
    $stmt->bindParam(9, $id, PDO::PARAM_STR);
    $stmt->bindParam(10,$id, PDO::PARAM_STR);
    $stmt->bindParam(11, $GLOBALS['name'], PDO::PARAM_STR);
    $stmt->bindParam(12, $GLOBALS['img'], PDO::PARAM_STR);
    // 执行语句
    $stmt->execute();
  } else
  {
    $GLOBALS['if'] = 6;
  }
} else
{
  $GLOBALS['if'] = 5;
}
?>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="./icon/logo.png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>发表</title>
  <link rel="stylesheet" href="./style_share.css">
  <script src="./script.js"></script>
  <script src="../flower.js">
    
  </script>
  
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
    if (!empty($_COOKIE['usercookie']))
      echo "<a href='../user'>
      <button class='menu-btn'>用户中心</button>
    </a>"
    ?>
  </div>
  <div class="black-layer"></div>
  <div class="user-click" onmousemove="UserOn()"></div>
  <img class="useravatar" src="<?php echo $GLOBALS["img"]; ?>">
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
    <input type="hidden" name="text" id="text">
    <!-- 引入主题css文件 -->
    <link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet">

    <!-- 引入js文件 -->
    <script src="https://cdn.quilljs.com/1.0.0/quill.js">
      
    </script>

    <!-- 自定义编辑器工具栏 -->
    <div class="editor-box">
    <div id="toolbar">
     
    </div>

    <!-- 创建编辑容器 -->
    <div id="editor">
      <p>
        
      </p>
    </div>
</div>
    <!-- 初始化编辑器，snow主题 -->
    <script>
      const editor = new Quill('#editor', {
        modules: {
          toolbar:  [
      // 默认的
      [{ header: [1, 2, 3, false] }],
      ['bold', 'italic', 'underline', 'link'],
      [{ list: 'ordered'}, { list: 'bullet' }],
      [{ 'align':[] }],
      ['image']
    ],
        },
        theme: 'snow'
      }
      );
    </script>

    <input type="submit" value="发布" class="login"></input>
  </form>
  <script>  
  
    // 在表单提交前，将Quill的内容设置到隐藏的input中  
    document.querySelector('form').onsubmit = function() {  
        var quill = document.getElementById('text');  
        quill.value = editor.root.innerHTML; 
    };  
</script>
</body>
</html>