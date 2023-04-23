<?php
session_start();

if (isset($_SESSION['uploaded_image'])) {
    $file_path = $_SESSION['uploaded_image'];

    if (file_exists($file_path)) {
        unlink($file_path);
    }

    unset($_SESSION['uploaded_image']);
}

header("Location: index.php");
