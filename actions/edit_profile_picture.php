<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../settings/connection.php");

if (isset($_POST['submit'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location:../login/login.php?msg=Please login first.");
        exit();
    }

    $gamer_id = $_SESSION['user_id'];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        $target_file = $target_dir . time() . '_' . basename($_FILES["image"]["name"]);
    }

    // Check file type
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
        // Check if user already has a profile picture
        $check_sql = "SELECT imagepath FROM profile WHERE gamer_id = ?";
        if ($check_stmt = $conn->prepare($check_sql)) {
            $check_stmt->bind_param("i", $gamer_id);
            $check_stmt->execute();
            $check_stmt->store_result();

            if ($check_stmt->num_rows > 0) {
                // Update existing profile picture
                $update_sql = "UPDATE profile SET imagepath = ? WHERE gamer_id = ?";
                if ($update_stmt = $conn->prepare($update_sql)) {
                    $update_stmt->bind_param("si", $target_file, $gamer_id);
                    if ($update_stmt->execute()) {
                        header("Location:../view/profile.php?msg=Profile picture updated successfully");
                    } else {
                        header("Location:../view/profile.php?msg=Error updating profile picture");
                    }
                    $update_stmt->close();
                } else {
                    header("Location:../view/profile.php?msg=Error preparing update statement");
                }
            } else {
                // Insert new profile picture
                $insert_sql = "INSERT INTO profile (gamer_id, imagepath) VALUES (?, ?)";
                if ($insert_stmt = $conn->prepare($insert_sql)) {
                    $insert_stmt->bind_param("is", $gamer_id, $target_file);
                    if ($insert_stmt->execute()) {
                        header("Location:../view/profile.php?msg=Profile picture added successfully");
                    } else {
                        header("Location:../view/profile.php?msg=Error adding profile picture");
                    }
                    $insert_stmt->close();
                } else {
                    header("Location:../view/profile.php?msg=Error preparing insert statement");
                }
            }
            $check_stmt->close();
        } else {
            header("Location:../view/profile.php?msg=Error preparing check statement");
        }
    } else {
        header("Location:../view/profile.php?msg=Image upload failed!");
        exit();
    }

    $conn->close();
}
?>