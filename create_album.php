<?php
$servername = "localhost";
$username = "root"; // เปลี่ยนตามที่ใช้
$password = ""; // เปลี่ยนตามที่ใช้
$dbname = "my_album"; // ชื่อฐานข้อมูล

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
$albumName = $data['name'];

$sql = "INSERT INTO albums (name) VALUES ('$albumName')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => $conn->error]);
}

$conn->close();
?>
