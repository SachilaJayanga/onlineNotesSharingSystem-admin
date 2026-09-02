<?php
  
 session_start(); 

 include_once('partials/navbar.php'); 
 
 ?>


<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $subject = $_POST['subject'];
    $active = isset($_POST['active']) ? 'Yes' : 'No';
    $account_id = $_SESSION['id'];  

     
    $image_name = '';
    $document_name = '';

    if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No"; 
                }

    
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $image_name = $_FILES['image']['name'];

       
        $ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $image_name = "Note-Img-".rand(0000, 9999).".".$ext;  

        $source_path = $_FILES['image']['tmp_name'];
        $destination_path = "../images/icon/".$image_name;

        
        $upload = move_uploaded_file($source_path, $destination_path);

        
        if ($upload == false) {
            $_SESSION['message'] = "<div class='error'>Failed to upload image.</div>";
            header('location:add-note.php');
            exit();
        }
    }

    
    if (isset($_FILES['doc']['name']) && $_FILES['doc']['name'] != "") {
        $document_name = $_FILES['doc']['name'];
 
        $ext = pathinfo($document_name, PATHINFO_EXTENSION);
        $document_name = "Note-Doc-".rand(0000, 9999).".".$ext; 

        $source_path = $_FILES['doc']['tmp_name'];
        $destination_path = "../documents/".$document_name;
 
        $upload = move_uploaded_file($source_path, $destination_path);
 
        if ($upload == false) {
            $_SESSION['message'] = "<div class='error'>Failed to upload document.</div>";
            header('location:add-note.php');
            exit();
        }
    }
 
    $sql = "INSERT INTO tbl_notes SET
        title='$title',
        description='$description',
        image_name='$image_name',
        subject_id = $subject,
        doc_name='$document_name',
        active='$active',
        account_id='$account_id'
    ";

 
    $res = mysqli_query($conn, $sql);

 
    if ($res == true) {
        $_SESSION['message'] = "<div class='success'>Note added successfully.</div>";
        header('location:myprofile.php');
    } else {
        $_SESSION['message'] = "<div class='error'>Failed to add note.</div>";
        header('location:myprofile.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Note</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    

    <div class="main-content">
        <div class="wrapper">
            <h1>Add New Note.</h1>
        <hr>
            <br><br>

            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title: </td>
                        <td><input type="text" name="title" placeholder="Title of the Note" required></td>
                    </tr>
                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description" cols="30" rows="5" placeholder="Description of the Note"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Select Image: </td>
                        <td><input type="file" name="image"></td>
                    </tr>
                    <tr>
                        <td>Select Document: </td>
                        <td><input type="file" name="doc"></td>
                    </tr>
                    <tr>
                    <td>Subject : </td>
                    <td>
                        <select class="dropdown" name="subject">

                          <option hidden selected>Choose Subject</option>
                            <?php 
                                 
                                
                                $sql = "SELECT * FROM tbl_subjects WHERE active='Yes'";
 
                                $res = mysqli_query($conn, $sql);
 
                                $count = mysqli_num_rows($res);
 
                                if($count>0)
                                {
 
                                    while($row=mysqli_fetch_assoc($res))
                                    {
 
                                        $id = $row['id'];
                                        $title = $row['title'];

                                        ?>

                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                        <?php
                                    }
                                }
                                else
                                {
 
                                    ?>
                                    <option value="0">No Subject Found</option>
                                    <?php
                                }
                            
                            ?>

                        </select>
                    </td>
                </tr>
                    <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes 
                        <input type="radio" name="active" value="No"> No
                    </td>
                    </tr>
                    <br>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Note" class="btn btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <?php include('partials/footer.php'); ?>
</body>
</html>
