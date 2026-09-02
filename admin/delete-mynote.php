<?php 
session_start();
 
include('../config/constants.php');
 
if (isset($_GET['note_id']) && isset($_GET['image_name']) && isset($_GET['doc_name'])) {
   
    $note_id = (int)$_GET['note_id']; 
    $image_name = $_GET['image_name'];
    $doc_name = $_GET['doc_name'];
 
    if ($image_name != "") {
   
        $image_path = "../images/icon/" . $image_name;
        if (file_exists($image_path)) {
            $remove_image = unlink($image_path);
            if ($remove_image == false) {
        
                $_SESSION['remove-failed'] = "<div class='error'>Failed to remove image file.</div>";
                header('location:myprofile.php');
                exit();
            }
        }
    }
 
    if ($doc_name != "") {
 
        $doc_path = "../documents/" . $doc_name;  
        if (file_exists($doc_path)) {
            $remove_doc = unlink($doc_path);
            if ($remove_doc == false) {
    
                $_SESSION['remove-failed'] = "<div class='error'>Failed to remove document file.</div>";
                header('location:myprofile.php');
                exit();
            }
        }
    }

 
    $sql = "DELETE FROM tbl_notes WHERE note_id=$note_id";
    $res = mysqli_query($conn, $sql);

    if ($res == true) {
 
        $_SESSION['delete'] = "<div class='success'>Note deleted successfully.</div>";
    } else {
         
        $_SESSION['delete'] = "<div class='error'>Failed to delete note.</div>";
    }

 
    header('location:myprofile.php');
    exit();
} else {
 
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorized access.</div>";
    header('location:myprofile.php');
    exit();
}
?>
