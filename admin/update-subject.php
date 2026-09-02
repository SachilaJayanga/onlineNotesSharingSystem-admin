<?php 
ob_start();
session_start();
include('partials/navbar.php'); 
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>
        <?php 
        
            if(isset($_SESSION['no-subject-found']))
            {
                echo $_SESSION['no-subject-found'];
                unset($_SESSION['no-subject-found']);
            }

            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            if(isset($_SESSION['failed-remove']))
            {
                echo $_SESSION['failed-remove'];
                unset($_SESSION['failed-remove']);
            }
        
        ?>

        <?php 
        
             if(isset($_GET['id']))
            { 
                $id = $_GET['id'];
                 $sql = "SELECT * FROM tbl_subjects WHERE id=$id"; 
                $res = mysqli_query($conn, $sql); 
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                     $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $active = $row['active'];
                }
                else
                {
                     $_SESSION['no-subject-found'] = "<div class='error'>Category not Found.</div>";
                    header('location:manage-subject.php');
                }

            }
            else
            {
                 header('location:manage-subject.php');
            }
        
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php 
                            if($current_image != "")
                            {
                                 ?>
                                <img src="../images/category/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                            else
                            {
                                 echo "<div class='error'>Image Not Added.</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr> 
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes 

                        <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No 
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Save" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php 
        
            if(isset($_POST['submit']))
            { 
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $active = $_POST['active'];
 
                if (isset($_FILES['image']['name'])) {
                     $image_name = $_FILES['image']['name'];
                
                     if ($image_name != "") { 
                        $extArray = explode('.', $image_name);  
                        $ext = end($extArray);   
                        $image_name = "Note_Category_" . rand(000, 999) . '.' . $ext;  
 
                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category/" . $image_name; 
                        $upload = move_uploaded_file($source_path, $destination_path);
                 
                        if ($upload == false) {
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image. </div>";
                            header('location:manage-subject.php');
                            exit();
                        } 
                        if ($current_image != "") {
                            $remove_path = "../images/category/" . $current_image;
                            if (file_exists($remove_path)) {  
                                $remove = unlink($remove_path);
                            } else {
                                $_SESSION['failed-remove'] = "<div class='error'>Current Image file does not exist.</div>";
                            }
                        }
                    } else {
                        $image_name = $current_image;
                    }
                } else {
                    $image_name = $current_image;
                } 
                $sql2 = "UPDATE tbl_subjects SET 
                    title = '$title',
                    image_name = '$image_name',
                    active = '$active' 
                    WHERE id=$id";

                 $res2 = mysqli_query($conn, $sql2); 
                if($res2==true)
                {
                     $_SESSION['update'] = "<div class='success'>Subject Updated Successfully.</div>";
                    header('location:manage-subject.php');
                    
                }
                else
                {
                     $_SESSION['update'] = "<div class='error'>Failed to Update Subject.</div>";
                    header('location:manage-subject.php');
                }

                ob_end_flush();
            }
        
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>
