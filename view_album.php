<?php
$servername = "localhost";
$username = "username"; // เปลี่ยนเป็นชื่อผู้ใช้ฐานข้อมูลของคุณ
$password = "password"; // เปลี่ยนเป็นรหัสผ่านฐานข้อมูลของคุณ
$dbname = "album_project"; // ชื่อฐานข้อมูล

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$album_id = $_GET['id'];

$sql = "SELECT * FROM photos WHERE album_id='$album_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Album</title>
</head>
<body>
    <h1>Photos in Album</h1>
    <ul>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<li><img src='" . $row['photo_url'] . "' style='width: 100px;' alt='Photo'><br><a href='" . $row['photo_url'] . "' download>Download</a></li>";
        }
        ?>
    </ul>
</body>
</html>

<?php
$conn->close();
?>
