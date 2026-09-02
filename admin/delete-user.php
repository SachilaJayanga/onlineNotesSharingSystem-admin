<?php 
    session_start();
     include('../config/constants.php');

     $id = $_GET['id'];
 
     $sql = "DELETE FROM tbl_accounts WHERE id=$id";
 
    $res = mysqli_query($conn, $sql); 
    if($res==true)
    { 
        $_SESSION['delete'] = "<div class='success'>User Deleted Successfully.</div>";
         header('location:manage-user.php');
    }
    else
    { 
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try Again Later.</div>";
        header('location:manage-user.php');
    }
 
?>
