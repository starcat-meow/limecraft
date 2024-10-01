<?php  
  
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['images'])) {  
    $images = json_decode(file_get_contents("php://input"), true)['images'];  
  
    foreach ($images as $image) {  
        // 解析 Data URL  
        list($type, $data) = explode(';', $image);  
        list(, $data)      = explode(',', $data);  
        $data = base64_decode($data);  
  
        // 生成文件名（这里只是一个简单的例子，你可能需要更复杂的逻辑来避免重名）  
        $filename = uniqid() . '.png'; // 假设所有图片都是 PNG 格式  
  
        // 保存文件  
        file_put_contents("uploads/" . $filename, $data);  
  
        // 这里可以记录文件路径或进行其他处理  
        echo "File {$filename} uploaded successfully.";  
    }  
} else {  
    http_response_code(400);  
    echo "Invalid request";  
}  
  
?>