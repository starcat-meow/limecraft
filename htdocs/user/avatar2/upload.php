<?php  
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image'])) {  
    // 获取 Base64 编码的图片数据  
    $base64Data = $_POST['image'];  
  
    // 解码 Base64 数据  
    $imageData = base64_decode($base64Data);  
  
    // 设置文件路径和名称（可以根据需要修改）  
    $uploadDir = '../improve/upload/'; // 确保这个目录存在并且可写  
    $file_mulu=date('Y-m-d_H-i-s')."_".uniqid().".jpg";
    $fileName = $file_mulu; // 你可以根据需要设置文件名和扩展名

    $filePath = $uploadDir . $fileName;
    // 将解码后的数据写入文件  
    file_put_contents($filePath, $imageData);  
  
    // 返回成功响应  
    echo json_encode(['status' => 'success', 'file' => $fileName]); 

    $file_mulu="https://limecraft.top/user/improve/upload/".$fileName;
    include("../../header.php");
    $pdo=PDOStart();
    $stmt = $pdo->prepare("UPDATE `user` SET `img` = ? WHERE cookie = ?");  
    $stmt->bindParam(1, $file_mulu, PDO::PARAM_STR);
    $stmt->bindParam(2, $_COOKIE['usercookie'], PDO::PARAM_STR);  
    // 执行语句  
    $stmt->execute();
    
    
} else {  
    // 返回错误响应  
    http_response_code(400);  
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);  
}  
?>