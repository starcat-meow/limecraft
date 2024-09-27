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
function LastTimeUpdate()
{
  
}
//更改最近访问时间（基本上每个php文件都要更新
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
?>