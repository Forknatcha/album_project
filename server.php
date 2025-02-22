<?php
include 'db.php';

// 📌 ดึงรายการอัลบั้ม
if (isset($_GET['albums'])) {
    $result = $conn->query("SELECT * FROM albums");
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
    exit;
}

// 📌 ดึงรูปภาพในอัลบั้ม
if (isset($_GET['photos']) && isset($_GET['album_id'])) {
    $album_id = intval($_GET['album_id']);
    $result = $conn->query("SELECT * FROM photos WHERE album_id = $album_id");
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
    exit;
}

// 📌 สร้างอัลบั้มใหม่
if (isset($_POST['album_name'])) {
    $album_name = $_POST['album_name'];
    $stmt = $conn->prepare("INSERT INTO albums (name) VALUES (?)");
    $stmt->bind_param("s", $album_name);
    $stmt->execute();
    echo json_encode(["status" => "success"]);
    exit;
}

// 📌 อัปโหลดรูปภาพ
if (isset($_FILES['photo']) && isset($_POST['album_id'])) {
    $album_id = intval($_POST['album_id']);
    $target_dir = "uploads/";
    $file_name = basename($_FILES["photo"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO photos (album_id, file_name) VALUES (?, ?)");
        $stmt->bind_param("is", $album_id, $file_name);
        $stmt->execute();
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
    exit;
}

// 📌 ลบรูปภาพ
if (isset($_POST['delete_photo_id'])) {
    $photo_id = intval($_POST['delete_photo_id']);

    $stmt = $conn->prepare("SELECT file_name FROM photos WHERE id = ?");
    $stmt->bind_param("i", $photo_id);
    $stmt->execute();
    $stmt->bind_result($file_name);
    $stmt->fetch();
    $stmt->close();

    if ($file_name) {
        unlink("uploads/" . $file_name);
        $stmt = $conn->prepare("DELETE FROM photos WHERE id = ?");
        $stmt->bind_param("i", $photo_id);
        $stmt->execute();
    }

    echo json_encode(["status" => "success"]);
    exit;
}
?>
