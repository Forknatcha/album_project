<?php
$servername = "localhost";
$username = "username"; // เปลี่ยนเป็นชื่อผู้ใช้ฐานข้อมูลของคุณ
$password = "password"; // เปลี่ยนเป็นรหัสผ่านฐานข้อมูลของคุณ
$dbname = "album_project"; // ชื่อฐานข้อมูล

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $album_name = $_POST['album_name'];

    $sql = "INSERT INTO albums (name) VALUES ('$album_name')";

    if ($conn->query($sql) === TRUE) {
        echo "Album created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
