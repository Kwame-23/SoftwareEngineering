<?php
include_once '../settings/core.php';
include_once '../functions/getprofile.php';
include_once '../settings/connection.php';
$profilePictureUrl = getProfilePicture($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/profile.css" />
    <meta charset="UTF-8" />
    <title>User Profile</title>
    <style>
        .profile {
            position: relative;
            display: inline-block;
        }
        .profile img {
            width: 210px;
            height: 200px;
            margin-right:40%;
        }
        .btn-edit-picture {
            position: absolute;
            bottom: 10px;
            background-color: white;
            border-radius: 50%;
            border: 2px solid #007bff;
            padding: 8px;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .btn-upload-picture {
            left: 10px;
        }
        .btn-edit-picture-pencil {
            right: 10px;
        }
        .btn-edit-picture i {
            color: #007bff;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="row py-5 px-4">
        <div class="col-md-5 mx-auto">
            <!-- Profile widget -->
            <div class="bg-white shadow rounded overflow-hidden">
                <div class="px-4 pt-0 pb-4 cover">
                    <div class="media align-items-end profile-head">
                        <div class="profile mr-3">
                            <img src="../img/gamelogo.png" class='rounded mb-2 img-thumbnail'>
                           
                            <a href="#" class="btn-edit-picture btn-upload-picture" data-toggle="modal" data-target="#uploadProfilePictureModal">
                                <i class="fas fa-camera"></i>
                            </a>
                            <a href="#" class="btn-edit-picture btn-edit-picture-pencil" data-toggle="modal" data-target="#editProfilePictureModal">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadProfilePictureModal" tabindex="-1" role="dialog" aria-labelledby="uploadProfilePictureModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadProfilePictureModalLabel">Upload Profile Picture</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="uploadProfilePictureForm" action="../actions/upload_profile_picture.php" method="POST" enctype="multipart/form-data">
                        <input type="file" name="image" accept="image/*">
                        <button type="submit" class="btn btn-outline-dark btn-sm btn-block mt-2" name="submit">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editProfilePictureModal" tabindex="-1" role="dialog" aria-labelledby="editProfilePictureModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfilePictureModalLabel">Edit Profile Picture</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editProfilePictureForm" action="../actions/edit_profile_picture.php" method="POST" enctype="multipart/form-data">
                        <input type="file" name="image" accept="image/*">
                        <button type="submit" class="btn btn-outline-dark btn-sm btn-block mt-2" name="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>