<?php 
ob_start();
session_start();
include('partials/navbar.php'); 

?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add New User</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['add']))  
            {
                echo $_SESSION['add'];  
                unset($_SESSION['add']);  
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Full Name" required>
                    </td>
                </tr>

                <tr>
                    <td>Email: </td>
                    <td>
                        <input type="text" name="email" placeholder="Enter Your Email" required>
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Your Username" required>
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Your Password" required>
                    </td>
                </tr>
                </tr>
                    <tr>
                    <td>User Type: </td>
                    <td>
                        <input type="radio" name="role" value="user"> User 
                        <input type="radio" name="role" value="admin"> Admin
                    </td>
                    </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Save" class="btn btn-secondary" required>
                    </td>
                </tr>

            </table>

        </form>


    </div>
</div>

<?php include('partials/footer.php'); ?>


<?php 
     

    if(isset($_POST['submit']))
    {
        
 
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);  
        $email = $_POST['email'];
        $role = $_POST['role'];
        
        $sql = "INSERT INTO tbl_accounts SET 
            full_name='$full_name',
            username='$username',
            password='$password',
            email='$email',
            role='$role'
        ";
 
        $res = mysqli_query($conn, $sql) or die();
 
        if($res==TRUE)
        {
 
            $_SESSION['add'] = "<div class='success'>Admin Added Successfully.</div>";
  
            header("location:manage-user.php");
            ob_end_flush();
        }
        else
        {
 
            $_SESSION['add'] = "<div class='error'>Failed to Add Admin.</div>";
 
            header("location:manage-user.php");
        }

    }
    
?>
