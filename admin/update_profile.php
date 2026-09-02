<?php
session_start();
include('../config/constants.php');

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $current_image = $_POST['current_image'];

     if (isset($_FILES['new_image']['name']) && $_FILES['new_image']['name'] != "") {
         $image_name = $_FILES['new_image']['name'];
        $image_tmp = $_FILES['new_image']['tmp_name'];
        move_uploaded_file($image_tmp, "../images/icon/" . $image_name);
    } else {
         $image_name = $current_image;
    }

     $sql = "UPDATE tbl_accounts SET
        full_name = '$full_name',
        email = '$email',
        username = '$username',
        image_profile = '$image_name'
        WHERE id = $id";
    
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $_SESSION['update'] = "Profile updated successfully.";
    } else {
        $_SESSION['update'] = "Failed to update profile.";
    }

    header('location: myprofile.php');
}
?>
