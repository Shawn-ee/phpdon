<?php
$servername = "localhost";
$username = "love_9img_cn";
$password = "love_9img_cn";
$dbname = "love_9img_cn";


// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
 
 $result = mysqli_query($conn,"SELECT * FROM ims_massage_code");

 $list=[];
while($row = mysqli_fetch_array($result))
{
    $list[]=[
            'id'=>$row["id"],
        
            'add_time'=>$row["add_time"],
     
            ];
}
  $data=[
        'list'=>$list,
        ];
    
    echo json_encode($data);

$conn->close();
?>