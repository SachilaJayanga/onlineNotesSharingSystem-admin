<?php 
ob_start();
session_start();
include('partials/navbar.php'); 

?>

<?php 
if (isset($_GET['note_id'])) {
    $note_id = (int)$_GET['note_id'];  

     $sql2 = "SELECT * FROM tbl_notes WHERE note_id = $note_id";
     $res2 = mysqli_query($conn, $sql2);

     if ($res2 == true) {
         $count = mysqli_num_rows($res2);
         if ($count == 1) {
             $row2 = mysqli_fetch_assoc($res2);
            $title = $row2['title'];
            $description = $row2['description'];
            $current_image = $row2['image_name'];
            $current_doc = $row2['doc_name'];
            $current_subject = $row2['subject_id'];
            $active = $row2['active'];
        } else {
             $_SESSION['no-note-found'] = "<div class='error'>Note not found.</div>";
            header('location:manage-note.php');
            exit();
        }
    }
} else {
     header('location:manage-note.php');
    exit();
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Note</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" required><?php echo htmlspecialchars($description); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php 
                        if ($current_image != "") {
                             echo "<img src='../images/icon/$current_image' width='150px'>";
                        } else {
                             echo "<div class='error'>Image not available.</div>";
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Current Document: </td>
                    <td>
                        <?php 
                        if ($current_doc != "") {
                             echo "<a href='../documents/$current_doc' target='_blank'>View Current Document</a>";
                        } else {
                             echo "<div class='error'>Document not available.</div>";
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Document: </td>
                    <td>
                        <input type="file" name="doc">
                    </td>
                </tr>

                <tr>
                    <td>Subject: </td>
                    <td>
                        <select class="dropdown" name="subject">
                            <?php 
                             $sql = "SELECT * FROM tbl_subjects WHERE active='Yes'";
                             $res = mysqli_query($conn, $sql);
                             $count = mysqli_num_rows($res);

                             if ($count > 0) {
                                 while ($row = mysqli_fetch_assoc($res)) {
                                    $subject_title = $row['title'];
                                    $subject_id = $row['id'];
                                    ?>
                                    <option <?php if ($current_subject == $subject_id) {echo "selected";} ?> value="<?php echo $subject_id; ?>"><?php echo $subject_title; ?></option>
                                    <?php
                                }
                            } else {
                                 echo "<option value='0'>Category Not Available.</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if ($active == "Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if ($active == "No") {echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="note_id" value="<?php echo $note_id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="current_doc" value="<?php echo $current_doc; ?>">
                        <input type="submit" name="submit" value="Update" class="btn btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php 
        if (isset($_POST['submit'])) {
             $note_id = $_POST['note_id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $current_image = $_POST['current_image'];
            $current_doc = $_POST['current_doc'];
            $subject = $_POST['subject'];
            $active = $_POST['active'];

             if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                 $image_name = $_FILES['image']['name'];
                $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                $image_name = "Note-Image-" . rand(0000, 9999) . ".$ext";
                $image_temp_path = $_FILES['image']['tmp_name'];
                $image_dest_path = "../images/icon/" . $image_name;

                 $upload = move_uploaded_file($image_temp_path, $image_dest_path);

                 if ($upload == false) {
                    $_SESSION['upload'] = "<div class='error'>Failed to upload new image.</div>";
                    header('location:manage-note.php');
                    exit();
                }

                 if ($current_image != "" && file_exists("../images/icon/" . $current_image)) {
                    unlink("../images/icon/" . $current_image);
                }
            } else {
                $image_name = $current_image;
            }

             if (isset($_FILES['doc']['name']) && $_FILES['doc']['name'] != "") {
                 $doc_name = $_FILES['doc']['name'];
                $doc_temp_path = $_FILES['doc']['tmp_name'];
                $doc_dest_path = "../documents/" . $doc_name;

                 $upload = move_uploaded_file($doc_temp_path, $doc_dest_path);

                 if ($upload == false) {
                    $_SESSION['upload'] = "<div class='error'>Failed to upload new document.</div>";
                    header('location:manage-note.php');
                    exit();
                } 
                if ($current_doc != "" && file_exists("../documents/" . $current_doc)) {
                    unlink("../documents/" . $current_doc);
                }
            } else {
                $doc_name = $current_doc;
            } 
            $sql3 = "UPDATE tbl_notes SET 
                title = '$title',
                description = '$description',
                image_name = '$image_name',
                doc_name = '$doc_name',
                subject_id = '$subject',
                active = '$active'
                WHERE note_id=$note_id";
 
            $res3 = mysqli_query($conn, $sql3); 
            if ($res3 == true) {
                $_SESSION['update'] = "<div class='success'>Note updated successfully.</div>";
                header('location:manage-note.php');
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to update note.</div>";
                header('location:manage-note.php');
            }
 
            ob_end_flush();
        }
        ?>

    </div>
</div>

<?php 
 
include_once('partials/footer.php'); 
?>
