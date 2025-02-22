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
    $album_id = $_POST['album_id'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO photos (album_id, photo_url) VALUES ('$album_id', '$target_file')";

        if ($conn->query($sql) === TRUE) {
            echo "Photo uploaded successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();
?>
