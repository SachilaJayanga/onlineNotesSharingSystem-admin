<?php
session_start();
include('../config/constants.php'); 
 
if (!isset($_SESSION['id'])) {
    echo "<script type='text/javascript'> document.location ='../login.php'; </script>";
    exit;
} 
function setComment($conn) {
    if (isset($_POST['comSubmit'])) {
        $account_id = $_SESSION['id']; 
        $note_id = $_POST['note_id']; 
        $comment = mysqli_real_escape_string($conn, $_POST['comment']);  
 
        $note_check_query = "SELECT * FROM tbl_notes WHERE note_id = '1';";
        $note_check_result = mysqli_query($conn, $note_check_query);

        if (mysqli_num_rows($note_check_result) > 0) {
    
            if (!empty($comment)) {
                $sql = "INSERT INTO tbl_comments (note_id, account_id, comment) VALUES ('$note_id', '$account_id', '$comment')";
                $result = mysqli_query($conn, $sql);
                
                if ($result) {
                    echo "Comment added successfully!";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Please enter a comment before submitting.";
            }
        } else {
            echo "Invalid note ID!";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Section</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php  
 
  $note_id = 1; 

  echo "<form method='POST'>
        <input type='hidden' name='note_id' value='$note_id'>
        <textarea name='comment'></textarea> <br>
        <button type='submit' name='comSubmit' class='btn btn-primary'>Comment</button>
    </form>";
 
  setComment($conn);
?>  

</body>
</html>
