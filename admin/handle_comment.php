<?php
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['submit_edit']) && isset($_POST['comment_id'])) {
                 $comment_id = $_POST['comment_id'];
                $new_comment_text = mysqli_real_escape_string($conn, $_POST['edit_comment']);

                $edit_sql = "UPDATE tbl_comments SET comment = '$new_comment_text' WHERE id = $comment_id AND account_id = {$_SESSION['account_id']}";
                $edit_res = mysqli_query($conn, $edit_sql);
                if ($edit_res) {
                     header("Location: note_page.php?note_id=$note_id");
                    exit();
                } else {
                    echo "<div class='error'>Failed to update comment.</div>";
                }
            }

            if (isset($_POST['submit_delete']) && isset($_POST['comment_id'])) {
                 $comment_id = $_POST['comment_id'];

                $delete_sql = "DELETE FROM tbl_comments WHERE id = $comment_id AND account_id = {$_SESSION['account_id']}";
                $delete_res = mysqli_query($conn, $delete_sql);
                if ($delete_res) {
                     header("Location: note_page.php?note_id=$note_id");
                    exit();
                } else {
                    echo "<div class='error'>Failed to delete comment.</div>";
                }
            }
        }
        ?>
