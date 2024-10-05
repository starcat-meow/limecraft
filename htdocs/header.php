<?php
/* 这是网站标准头文件
部分需要跨多文件使用的函数或结构体在这里编辑
*/
function PDOStart()
{
  $pdoo=new PDO('mysql:host=localhost;dbname=admin','admin','flyusb123',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
  return $pdoo;
}
//开启数据库
function GetRandStr($length){
 $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
 $len = strlen($str)-1;
 $randstr = '';
 for ($i=0;$i<$length;$i++) {
  $num=mt_rand(0,$len);
  $randstr .= $str[$num];
 }
 return $randstr;
}
//随机字符串生成
function GetUidNum()
{
  $pdo=PDOStart();
  $stmtt=$pdo->prepare("select * from `public` where key_ = 'num_uid';");
  $stmtt->execute();
  $arrt=$stmtt->fetchALL();
  $shut=$arrt[0];
  $num_uid=$shut[1];
  $num_uid++;
  $stmt=$GLOBALS['pdo']->prepare("UPDATE public SET value = ".$num_uid." where key_ = 'num_uid';");
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
  if(!empty($_COOKIE['usercookie']))
  {
  $pdo=PDOStart();
  $stmt = $pdo->prepare("SELECT name FROM user WHERE cookie = ?");  
  $stmt->bindParam(1, $_COOKIE['usercookie'], PDO::PARAM_STR);  
  $stmt->execute();  
  $arr = $stmt->fetchAll(); 
  if (empty($arr)) {  
  echo "<script>confirm('当前登录状态已失效，请重新登录！');</script>";
  setcookie('usercookie','',time()-3600,'/');
  }
  }
}
//验证当前用户cookie是否能用
class PostList{
  public $posts=[];
public function renderPosts()
{
  $num=count($this->posts);
  for($i=0;$i<$num;$i++)
{
$shu=$this->posts[$i];
if(empty($shu))
  break;
echo "<div class='post-box'>
        <div class='post'>  
    <div class='post-header'>  
        <img src='".htmlspecialchars($shu['post_useravatar'])."' alt='用户头像' class='post-avatar'>  
        <div class='post-meta'>  
            <h3 class='post-name'>".htmlspecialchars($shu['post_username'])."</h3>  
            <p class='post-date'>发布日期:".htmlspecialchars($shu['date'])."</p>
        </div>  
            <div class='post-content'>  
        <h2 class='post-title'>".htmlspecialchars($shu['title'])."</h2>  
        <p class='post-text' id='post-text'>".$shu['text']."</p>  
    </div>  
    </div>

    </div>  ";
}
}
public function setPosts($art){
  $this->posts=$art;
}
}
//帖子显示结构体
function GetPostsNum()
{
  $pdo=PDOStart();
  $stmtt=$pdo->prepare("select * from `public` where key_ = 'num_article';");
  $stmtt->execute();
  $arrt=$stmtt->fetchALL();
  $shut=$arrt[0];
  $num_uid=$shut[1];
  $num_uid++;
  $stmt=$GLOBALS['pdo']->prepare("UPDATE public SET value = ".$num_uid." where key_ = 'num_article';");
  $stmt->execute();
  return $num_uid;
}
//post+1并获取总数
function GetUserData(){
  if(!empty($_COOKIE['usercookie']))
  {
  $pdo=PDOStart();
  $stmtt=$pdo->prepare("select * from `user` where cookie = ?;");
  $stmtt->bindParam(1, $_COOKIE['usercookie'], PDO::PARAM_STR); 
  $stmtt->execute();
  $arrt=$stmtt->fetchALL();
  $shut=$arrt[0];
  return $shut;
  }
  else
  {
    return false;
  }
}
//说明：getuserdata获取usercookie符合的用户数据
function time_ip_update(){
  if(!empty($_COOKIE['usercookie']))
  {
  $pdo=PDOStart();
  $stmtt=$pdo->prepare("UPDATE `user` SET `last_date`= ?,`last_ip`= ? where cookie = ?;");
  $datetime=GetDateTime();
  $stmtt->bindParam(1, $datetime, PDO::PARAM_STR);
  $ip=GetIp();
  $stmtt->bindParam(2, $ip, PDO::PARAM_STR);
  $stmtt->bindParam(3, $_COOKIE['usercookie'], PDO::PARAM_STR); 
  $stmtt->execute();
  }
}
//最近登录ip和时间更新
?>