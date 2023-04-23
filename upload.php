<?php
session_start();

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $_SESSION['uploaded_image'] = $target_file;
            header("Location: index.php");
        } else {
            header("Location: index.php?error=upload_error");
        }
    } else {
        header("Location: index.php?error=invalid_image");
    }
} else {
    header("Location: index.php");
}
