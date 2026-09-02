<?php
session_start();
include('partials/navbar.php');

 if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['note_id'])) {
    $note_id = $_GET['note_id'];

     $sql = "SELECT tbl_notes.*, tbl_accounts.full_name 
            FROM tbl_notes 
            JOIN tbl_accounts ON tbl_notes.account_id = tbl_accounts.id 
            WHERE note_id = $note_id";
    
    $res = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $description = $row['description'];
        $image_name = $row['image_name'];
        $doc_name = $row['doc_name'];
        $likes = $row['likes'];
        $uploaded_by = $row['full_name'];
    } else {
        header("Location: error.php");
    }
} else {
    header("Location: index.php");
}

 if (isset($_POST['submit_comment'])) {
    $account_id = $_SESSION['id'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    $sql2 = "INSERT INTO tbl_comments (note_id, account_id, comment) VALUES ($note_id, $account_id, '$comment')";
    mysqli_query($conn, $sql2);
    
    header("Location: note_page.php?note_id=" . $note_id);
    exit();
}

 if (isset($_POST['update_comment'])) {
    $comment_id = $_POST['comment_id'];
    $updated_comment = mysqli_real_escape_string($conn, $_POST['updated_comment']);
    
    $sql3 = "UPDATE tbl_comments SET comment = '$updated_comment' WHERE id = $comment_id";
    mysqli_query($conn, $sql3);
}

 if (isset($_GET['delete_comment_id'])) {
    $comment_id = $_GET['delete_comment_id'];
    
    $sql4 = "DELETE FROM tbl_comments WHERE id = $comment_id";
    mysqli_query($conn, $sql4);
}

?>

<section class="main-content text-center">
    <div class="container">
        <h2 style="text-transform:uppercase;"><?php echo $title; ?></h2>
        <hr>
    <br>
        <?php 
         if ($image_name != "") {
            ?>
            <img src="../images/icon/<?php echo $image_name; ?>" alt="Note Image" class="img-curve" width="30%">
            <?php
        } else {
            ?>
            <img src="../images/default.png" alt="No Image Available" class="img-curve" width="30%">
            <?php
        }
        ?>
    <br>    
        </div>

        <br>
        <h3>Description:</h3>
        <p><?php echo $description; ?></p>
        
        <h3>Uploaded by:</h3>
        <p><a href="uploader_profile.php?uploader_id=<?php echo $row['account_id']; ?>" style="text-decoration: none; color: blue;"><?php echo $uploaded_by; ?></a></p>


        <div class="btn-like-align">
        
        
                Likes:
                            <button id="like-button-<?php echo $note_id; ?>" class="btn btn-like" style="margin-left:2px;" onclick="toggleLike(<?php echo $note_id; ?>)">
                            
                            <?php
                             $account_id = $_SESSION['id'];
                            $check_like_sql = "SELECT * FROM tbl_likes WHERE account_id = $account_id AND note_id = $note_id";
                            $check_like_res = mysqli_query($conn, $check_like_sql);
                            if (mysqli_num_rows($check_like_res) > 0) {
                                echo '<i class="fa-solid fa-heart fa-xl"></i>';
                            } else {
                                echo '<i class="fa-regular fa-heart fa-xl"></i>';
                            }
                            ?>
                            
                        </button>
                        
                            <span id="like-count-<?php echo $note_id; ?>" style="margin-right:20px;"><?php echo $likes; ?></span>
                        
                    <a href="../documents/<?php echo $doc_name; ?>" class="btn btn-primary" style="padding: 10px;  margin-right:100px;">View Document</a>                 
                        
            </div>   
            
        <br><br>
    <hr>
</section>

<section class="main-content">
    <div class="container">
        
        <p style="font-weight:600;">Give Your Comments</p>
        <form action="" method="POST">
            <textarea name="comment" placeholder="Add Public Comment" cols="50" rows="3" required></textarea><br><br>
            <button type="submit" name="submit_comment" class="btn btn-secondary">Add Comment</button>
        </form>
        <br><br>

        <h2>Comments :</h2>
    <hr>
        <?php
        $sql5 = "SELECT tbl_comments.*, tbl_accounts.full_name 
                 FROM tbl_comments 
                 JOIN tbl_accounts ON tbl_comments.account_id = tbl_accounts.id 
                 WHERE tbl_comments.note_id = $note_id 
                 ORDER BY tbl_comments.created_at DESC";
        $res5 = mysqli_query($conn, $sql5);

        while ($comment_row = mysqli_fetch_assoc($res5)) {
            $comment_text = $comment_row['comment'];
            $comment_user = $comment_row['full_name'];
            $comment_id = $comment_row['id'];
            $comment_time = $comment_row['created_at'];
            
            ?>

            <div class="comment-box">
                
                <p>
                    <strong><?php echo $comment_user; ?> :</strong> <p style="float: right;"> <?php echo $comment_time; ?></p>
                    <span class="comment-text" id="comment-<?php echo $comment_id; ?>"><?php echo $comment_text; ?></span>
                </p>
 
                 <a href="javascript:void(0);" onclick="showEditForm(<?php echo $comment_id; ?>)" style="color: blue; text-decoration: none; margin-right: 10px;">Edit</a>
                
                 <a href="?note_id=<?php echo $note_id; ?>&delete_comment_id=<?php echo $comment_id; ?>" onclick="return confirm('Are you sure you want to delete this comment?');" style="color: red">Delete</a>
                
                 <div id="edit-form-<?php echo $comment_id; ?>" style="display:none;">
                    <form action="" method="POST">
                        <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>">
                        <textarea name="updated_comment" required><?php echo $comment_text; ?></textarea><br>
                        <button type="submit" name="update_comment">Update Comment</button>
                    </form>
                </div>
            </div>
            <hr><br><br>
            <?php
        }
        ?>
    </div>
</section>

<script src="../js/like.js">
function showEditForm(commentId) {
    const form = document.getElementById('edit-form-' + commentId);
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>

<?php include('partials/footer.php'); ?>
