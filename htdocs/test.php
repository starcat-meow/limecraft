<?php
include "header.php";
$message=new Message();
$message->Add(1,1);
$message->Remove(2);
$message->GetNoRead();
print_r($message->Select(2));
?>