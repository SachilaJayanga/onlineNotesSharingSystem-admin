<?php 
ob_start();
session_start();
include('partials/navbar.php'); 
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update User</h1>

        <br><br>

        <?php 
             $id=$_GET['id']; 
            $sql="SELECT * FROM tbl_accounts WHERE id=$id";
 
            $res=mysqli_query($conn, $sql); 
            if($res==true)
            { 
                $count = mysqli_num_rows($res);
                 if($count==1)
                {
                      $row=mysqli_fetch_assoc($res); 
                    $full_name = $row['full_name'];
                    $email = $row['email'];
                    $username = $row['username'];
                    $role = $row['role'];
                }
                else
                {
                     header('location:manage-user.php');
                }
            }
        
        ?>


        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Email: </td>
                    <td>
                        <input type="text" name="email" value="<?php echo $email; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>
                <tr>
                    <td>User Type: </td>
                    <td>
                        <input <?php if ($role == "user") {echo "checked";} ?> type="radio" name="role" value="user"> User
                        <input <?php if ($role == "admin") {echo "checked";} ?> type="radio" name="role" value="admin"> Admin
                    </td>
                </tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update" class="btn btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>

<?php 

     if(isset($_POST['submit']))
    { 
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $role = $_POST['role']; 
        $sql = "UPDATE tbl_accounts SET
        full_name = '$full_name',
        email = '$email',
        username = '$username',
        role = '$role' 
        WHERE id='$id'
        "; 
        $res = mysqli_query($conn, $sql); 
        if($res==true)
        {
             $_SESSION['update'] = "<div class='success'>Updated Successfully.</div>";
             header('location:manage-user.php');
        }
        else
        {
             $_SESSION['update'] = "<div class='error'>Failed to Update User.</div>";
             header('location:manage-user.php');
        }

        ob_end_flush();
    }

?>


<?php include('partials/footer.php'); ?>
