<?php
/* 这是网站标准头文件
部分需要跨多文件使用的函数或结构体在这里编辑
*/
function PDOStart()
{
  $pdoo = new PDO('mysql:host=localhost;dbname=admin', 'admin', 'flyusb123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
  return $pdoo;
}
//开启数据库
function GetRandStr($length)
{
  $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  $len = strlen($str) - 1;
  $randstr = '';
  for ($i = 0; $i < $length; $i++) {
    $num = mt_rand(0, $len);
    $randstr .= $str[$num];
  }
  return $randstr;
}
//随机字符串生成
function GetUidNum()
{
  $pdo = PDOStart();
  $stmtt = $pdo->prepare("select * from `public` where key_ = 'num_uid';");
  $stmtt->execute();
  $arrt = $stmtt->fetchALL();
  $shut = $arrt[0];
  $num_uid = $shut[1];
  $num_uid++;
  $stmt = $GLOBALS['pdo']->prepare("UPDATE public SET value = " . $num_uid . " where key_ = 'num_uid';");
  $stmt->execute();
  return $num_uid;
}
//uid+1并获取uid总数
function GetIp()
{
  if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    $ip = explode(',', $ip)[0];
    $ip = trim($ip);
  } else {
    $ip = $_SERVER["REMOTE_ADDR"];
  }
  return $ip;
}
//获取当前ip地址
function GetDateTime()
{
  return date('Y-m-d H:i:s', time());
}
//获取当前datetime时间
function UserCookieTest()
{
  if (!empty($_COOKIE['usercookie'])) {
    $pdo = PDOStart();
    $stmt = $pdo->prepare("SELECT name FROM user WHERE cookie = ?");
    $stmt->bindParam(1, $_COOKIE['usercookie'], PDO::PARAM_STR);
    $stmt->execute();
    $arr = $stmt->fetchAll();
    if (empty($arr)) {
      echo "<script>confirm('当前登录状态已失效，请重新登录！');</script>";
      setcookie('usercookie', '', time() - 3600, '/');
    }
  }
}
//验证当前用户cookie是否能用
function GetId()
{
  if (!empty($_COOKIE['usercookie'])) {
    $pdo = PDOStart();
    $stmt = $pdo->prepare("SELECT id FROM user WHERE cookie = ?");
    $stmt->bindParam(1, $_COOKIE['usercookie'], PDO::PARAM_STR);
    $stmt->execute();
    $arr = $stmt->fetchAll();
    $shu = $arr[0];
    return $shu['id'];
  } else {
    return false;
  }
}
//使用usercookie获取用户id
function truncateHtmlWithBr($html, $maxLength, $encoding = 'UTF-8')
{
  $brPositions = [];
  if (preg_match_all('/<br\s*\/?>/iu', $html, $matches, PREG_OFFSET_CAPTURE)) {
    foreach ($matches[0] as $match) {
      $brPositions[] = ['position' => $match[1], 'length' => strlen($match[0])];
    }
  }

  $cleanHtml = preg_replace('/<(?!\/?br\s*\/?)[^>]+>/iu', '', $html);
  $textLengthWithoutBr = mb_strlen($cleanHtml, $encoding);
  if ($textLengthWithoutBr <= $maxLength) {
    return $html;
  }
  $truncatePosition = $maxLength;
  foreach ($brPositions as $br) {
    if ($br['position'] > $maxLength - 5 && $br['position'] < $maxLength) {
      if ($br['position'] + $br['length'] > $maxLength) {
        $truncatePosition = $br['position']; // 或者 $br['position'] + $br['length']，根据需要调整  
      }
      break;
    }
  }
  $truncatedHtml = mb_substr($html, 0, $truncatePosition, $encoding);
  if ($truncatePosition < mb_strlen($html, $encoding)) {
    $afterTruncate = mb_substr($html, $truncatePosition, 1, $encoding);
    if (trim($afterTruncate) !== '') {
      $truncatedHtml .= '...';
    }
  }

  // 返回截断后的HTML文本  
  return $truncatedHtml;
}
//截取帖子
class PostList
{
  private $posts = [];
  private $maxLength = 120;
  public function renderPosts()
  {
    $num = count($this->posts);
    for ($i = 0; $i < $num; $i++) {
      $shu = $this->posts[$i];
      //$truncatedText = truncateHtmlWithBr($shu['text'], $this->maxLength);  
      //$shu['text'] = $truncatedText;  
      if (empty($shu))
        break;
      echo "
        <div class='post'>  
        <div class='post-header'>  
        <img src='" . htmlspecialchars($shu['post_useravatar']) . "' alt='用户头像' class='post-avatar'>  
        <div class='post-meta'>  
            <h3 class='post-name'>" . htmlspecialchars($shu['post_username']) . "</h3>  
            <p class='post-date'>发布日期:" . htmlspecialchars($shu['date']) . "</p>
        </div>  
            <div class='post-content'>  
        <h2 class='post-title'>" . htmlspecialchars($shu['title']) . "</h2>  
        <p class='post-text' id='post-text'>" . $shu['text'] . "</p>  
    </div>  
    </div>
    </div>";
    }
  }
  public function setPosts($art)
  {
    $this->posts = $art;
  }
  public function setIdPosts($id): void
  {
    $pdo = PDOStart();
    $stmt = $pdo->prepare("SELECT id, title, text, date, post_username, post_useravatar FROM article WHERE post_userid = ?");
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $arr = $stmt->fetchAll();
    $this->posts = $arr;
  }
}
//帖子显示结构体
function GetPostsNum()
{
  $pdo = PDOStart();
  $stmtt = $pdo->prepare("select * from `public` where key_ = 'num_article';");
  $stmtt->execute();
  $arrt = $stmtt->fetchALL();
  $shut = $arrt[0];
  $num_uid = $shut[1];
  $num_uid++;
  $stmt = $GLOBALS['pdo']->prepare("UPDATE public SET value = " . $num_uid . " where key_ = 'num_article';");
  $stmt->execute();
  return $num_uid;
}
//post+1并获取总数
function GetUserData()
{
  if (!empty($_COOKIE['usercookie'])) {
    $pdo = PDOStart();
    $stmtt = $pdo->prepare("select * from `user` where cookie = ?;");
    $stmtt->bindParam(1, $_COOKIE['usercookie'], PDO::PARAM_STR);
    $stmtt->execute();
    $arrt = $stmtt->fetchALL();
    $shut = $arrt[0];
    return $shut;
  } else {
    return false;
  }
}
//说明：getuserdata获取usercookie符合的用户数据
function time_ip_update()
{
  if (!empty($_COOKIE['usercookie'])) {
    $pdo = PDOStart();
    $stmtt = $pdo->prepare("UPDATE `user` SET `last_date`= ?,`last_ip`= ? where cookie = ?;");
    $datetime = GetDateTime();
    $stmtt->bindParam(1, $datetime, PDO::PARAM_STR);
    $ip = GetIp();
    $stmtt->bindParam(2, $ip, PDO::PARAM_STR);
    $stmtt->bindParam(3, $_COOKIE['usercookie'], PDO::PARAM_STR);
    $stmtt->execute();
  }
}
//最近登录ip和时间更新
function FirstMessage()
{
  $b['induction']['num'] = 1;
  $b['induction']['update'] = 0;
  $b[0]['title'] = "欢迎来到LimeCraft官网!";
  $b[0]['text'] = "感谢您的注册~";
  $b[0]['datetime'] = GetDateTime();
  return json_encode($b);
}
//返回注册消息（json格式）
class Message
{
  private $message = [];
  public function GetById($id)
  {
    $pdo = PDOStart();
    $stmtt = $pdo->prepare("select message from `user` where id = ?;");
    $stmtt->bindParam(1, $id, PDO::PARAM_INT);
    $stmtt->execute();
    $arrt = $stmtt->fetchALL();
    $shut = $arrt[0];
    $this->message = json_decode($shut['message'], true);
  }
  public function Add($title, $text)
  {
    $num = count($this->message)-1;
    $this->message[$num]['title'] = $title;
    $this->message[$num]['text'] = $text;
    $this->message[$num]['datetime'] = GetDateTime();
    $this->message['induction']['num']+=1;
  }
  public function Select($line)
  {
    $line -= 1;
    return $this->message[$line];
  }
  public function Remove($line)
  {
    $line -= 1;
    for ($i = $line; $i < count($this->message) - 1; $i++) {
      $this->message[$i] = $this->message[$i + 1];
    }
  }
  public function Line()
  {

    return count($this->message) - 1;
  }
  public function Render()
  {
    $num = count($this->message) - 1;
    if ($num == 0) {
      echo "<p>您还没有收到任何消息哦(〃'▽'〃)</p>";
    }
    for ($i = 0; $i < $num; $i++) {
      $shu = $this->message[$i];
      if (empty($shu))
        break;
      echo "<div class='post'>  
            <div class='post-content'>  
        <p class='post-title'>" . htmlspecialchars($shu['title']) . "</p>  
        <p class='post-text' id='post-text'>" . $shu['text'] . "</p>  
    </div>  
    </div>";
    }
  }
  public function GetNoRead(){
    $num=$this->message['induction']['num'];
    $update=$this->message['induction']['update'];
    return $num-$update;
  }
  public function UpdateRead(){
    $this->message['induction']['update']=$this->message['induction']['num'];
  }
  public function ReturnSqlById($id){
    $pdo = PDOStart();
    $stmtt = $pdo->prepare("UPDATE `user` SET `message`= ? WHERE id = ?;");
    $json=json_encode($this->message);
    $stmtt->bindParam(1, $json, PDO::PARAM_STR);
    $stmtt->bindParam(2, $id, PDO::PARAM_INT);
    $stmtt->execute();
  }
}
//消息处理
?>