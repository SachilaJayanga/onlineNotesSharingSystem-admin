<?php 
session_start();
include('partials/navbar.php'); 

?>

<?php
 
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}

?>
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Notes</h1>
    <hr>
        <br><br>

                
        <a href="add-note.php" class="btn btn-primary">Add Notes</a>

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

                <table class="tbl-full">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        
                        <th>Image</th>
                        
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        
                        $sql = "SELECT * FROM tbl_notes";
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
                                    
                                    <td><?php echo $active; ?></td>
                                    <td>
                                        <a href="update-notes.php?note_id=<?php echo $note_id; ?>" class="btn btn-secondary">Update</a>
                                        <a href="delete-notes.php?note_id=<?php echo $note_id; ?>&image_name=<?php echo $image_name; ?>&doc_name=<?php echo $doc_name; ?>" class="btn btn-danger">Delete</a>
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




<?php include_once('partials/footer.php'); ?>
