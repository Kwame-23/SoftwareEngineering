<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../settings/connection.php");

if (isset($_POST['submit'])){
    if (!isset($_SESSION['user_id'])) {
        header("Location:../login/login.php?msg=Please login first.");
        exit();
    }

    $gamer_id = $_SESSION['user_id'];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    //Check if file already exists
    if (file_exists($target_file)) {
        header("Location:../view/profile.php?msg=Error! File already exists.");
        exit();
    }

    //Check file type
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
        header("Location:../view/profile.php?msg=Error! Only JPG, JPEG, PNG & GIF files are allowed.");
        exit();
    }

    // Check if image file is an actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        header("Location:../view/profile.php?msg=Error! File is not an image.");
        exit();
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO profile (gamer_id, imagepath) VALUES (?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("is", $gamer_id, $target_file);

            if ($stmt->execute()) {
                header("Location:../view/profile.php?msg=Success");
            } else {
                header("Location:../view/profile.php?msg=Error executing query");
            }

            $stmt->close();
        } else {
            header("Location:../view/profile.php?msg=Error preparing statement");
        }

        $conn->close();
    } else {
        header("Location:../view/profile.php?msg=Image upload failed!");
        exit();
    }
}

?>
