<?php
$servername = "localhost";
$username = "root"; // เปลี่ยนตามที่ใช้
$password = ""; // เปลี่ยนตามที่ใช้
$dbname = "album_project"; // ชื่อฐานข้อมูล

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name FROM albums";
$result = $conn->query($sql);

$albums = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $albums[] = $row;
    }
}

echo json_encode(["albums" => $albums]);

$conn->close();
?>
