<?php
$host = "localhost";
$user = "root";  // ค่าเริ่มต้นของ XAMPP คือ root
$pass = "";
$dbname = "album_db";  // ใช้ชื่อฐานข้อมูลที่สร้างไว้

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
