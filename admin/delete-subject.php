<?php 
session_start();
include('partials/navbar.php'); 
?>

<?php 
     include('../config/constants.php');
 
      if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
 
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];
 
        if($image_name != "")
        {
             $path = "../images/category/".$image_name;
             $remove = unlink($path);
 
            if($remove==false)
            {
                 $_SESSION['remove'] = "<div class='error'>Failed to Remove Subject Image.</div>";
                 header('location:manage-subject.php');
                 die();
            }
        }

         $sql = "DELETE FROM tbl_subjects WHERE id=$id"; 
        $res = mysqli_query($conn, $sql);
 
        if($res==true)
        {
             $_SESSION['delete'] = "<div class='success'>Subject Deleted Successfully.</div>";
             header('location:manage-subject.php');
        }
        else
        {
             $_SESSION['delete'] = "<div class='error'>Failed to Delete Subject.</div>";
             header('location:manage-subject.php');
        }

 

    }
    else
    {
         header('location:manage-subject.php');
    }
?>
