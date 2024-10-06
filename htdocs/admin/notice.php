<?php
include "../header.php";
if($_POST['user']=='all')
{
    $pdo = PDOStart();
    $stmt = $pdo->prepare("select id from `user`");
    $stmt->execute();
    $arr = $stmt->fetchALL();
    for($i=0;$i<count($arr);$i++){
        $id=$arr[$i]['id'];
        $message=new Message();
        $message->GetById($id);
        $message->Add($_POST['title'],$_POST['text']);
        $message->ReturnSqlById($id);
    }
    echo "消息已发送给所有用户~";
}
else
{
    $id=$_POST['user'];
    $message=new Message();
    $message->GetById($id);
    $message->Add($_POST['title'],$_POST['text']);
    $message->ReturnSqlById($id);
    echo "消息已发送给指定用户~";
}
?>