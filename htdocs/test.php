<?php
include "header.php";
$message=new Message();
$message->Add(1,1);
$message->Add(2,1);
$message->Add(3,1);
$message->Add(4,1);
$message->Add(5,1);
$message->Remove(2);
$message->GetNoRead();
print_r($message->Select(2));
?>