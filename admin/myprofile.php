<?php
ob_start(); 
session_start(); 
include_once('partials/navbar.php'); 

 if (!isset($_SESSION['id'])) {
    echo "<script type='text/javascript'> document.location ='../login.php'; </script>";
    exit;
}

 if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
?>

<div class="main-content text-center">
    <div class="wrapper">
        <h1>My Profile</h1>
        <hr><br><br>
        
        <?php 
             if (isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
            if (isset($_SESSION['change-pwd'])) {
                echo $_SESSION['change-pwd'];
                unset($_SESSION['change-pwd']);
            }
            if (isset($_SESSION['pwd-not-match'])) {
                echo $_SESSION['pwd-not-match'];
                unset($_SESSION['pwd-not-match']);
            }
            if (isset($_SESSION['user-not-found'])) {
                echo $_SESSION['user-not-found'];
                unset($_SESSION['user-not-found']);
            }

             $id = $_SESSION['id'];
            $sql = "SELECT * FROM tbl_accounts WHERE id=$id";
            $res = mysqli_query($conn, $sql);

            if ($res && mysqli_num_rows($res) == 1) {
                $row = mysqli_fetch_assoc($res);
                $full_name = $row['full_name'];
                $email = $row['email'];
                $username = $row['username'];
                $image_profile = $row['image_profile'];
            } else {
                header('location:myprofile.php');
            }
        ?>
                         <?php 
                        if ($image_profile == "") {
                            echo "<img src='../images/default.png' alt='notes' class='img-curve' width='50px'>";
                        } else {
                            echo "<img src='../images/icon/{$image_profile}' alt='Profile Image' width='40%' class='img-curve'>";
                        }
                        ?>
                
         <br><br> 
                
    </div>
    <h3>Name:</h3>
        <p><?php echo $full_name; ?></p>                
       <hr>
       
</div>
<section>
<div class="main-content">
    <div class="wrapper">
        <h1>Uploaded Notes</h1>
        <hr>
        <br><br>

                 <a href="add-note.php" class="btn btn-primary">Upload New</a>

                <br><br><br>

                <?php 
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['upload']))
                    {
                        echo $_SESSION['upload'];
                        unset($_SESSION['upload']);
                    }
                    
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }

                    if(isset($_SESSION['unauthorize']))
                    {
                        echo $_SESSION['unauthorize'];
                        unset($_SESSION['unauthorize']);
                    }

                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                
                ?>
                <br><br>
                <table class="tbl-full">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        
                        <th>Image</th>
                        <th>Document</th>
                        
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                    
                        $id = $_SESSION['id'];
                        
                        
                        $sql = "SELECT * FROM tbl_notes WHERE account_id = $id";
                        $res = mysqli_query($conn, $sql);

                        if ($res && mysqli_num_rows($res) > 0) {
                            $sn = 1;  
                            while ($row = mysqli_fetch_assoc($res)) {
                                $note_id = $row['note_id'];
                                $title = $row['title'];
                                $image_name = $row['image_name'];
                                $doc_name = $row['doc_name'];
                                $active = $row['active'];
                     ?>

                                <tr>
                                    <td><?php echo $sn++; ?>. </td>
                                    <td><?php echo $title; ?></td>
                                    
                                    <td>
                                        <?php  
                                             if($image_name=="")
                                            {
                                                 echo "<div class='error'>Image not Added.</div>";
                                            }
                                            else
                                            {
                                                 ?>
                                                <img src="../images/icon/<?php echo $image_name; ?>" width="100px">
                                                <?php
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php  
                                             if($doc_name=="")
                                            {
                                                 echo "<div class='error'>Document not Added.</div>";
                                            }
                                            else
                                            {
                                                 ?>
                                                <a href="../documents/<?php echo $doc_name; ?>" >View Document</a>
                                                <?php
                                            }
                                        ?>
                                    </td>
                                    
                                    <td><?php echo $active; ?></td>
                                    <td>
                                        <a href="update-mynote.php?note_id=<?php echo $note_id; ?>" class="btn btn-secondary">Update</a>
                                        <a href="delete-mynote.php?note_id=<?php echo $note_id; ?>&image_name=<?php echo $image_name; ?>&doc_name=<?php echo $doc_name; ?>" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>

                                <?php
                            }
                        }
                        else
                        {
                             echo "<tr> <td colspan='7' class='error'> Notes not Added Yet. </td> </tr>";
                        }

                    ?>

                    
                </table>
    </div>
    
</div>
</section><br><br>
<?php include('partials/footer.php'); ?>

<?php ob_end_flush(); ?>
