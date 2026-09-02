<?php 
session_start();
include('partials/navbar.php'); 
?>


        
        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Accounts.</h1>
            <hr>
                <br/>

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
                    
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }

                    if(isset($_SESSION['user-not-found']))
                    {
                        echo $_SESSION['user-not-found'];
                        unset($_SESSION['user-not-found']);
                    }

                    if(isset($_SESSION['pwd-not-match']))
                    {
                        echo $_SESSION['pwd-not-match'];
                        unset($_SESSION['pwd-not-match']);
                    }

                    if(isset($_SESSION['change-pwd']))
                    {
                        echo $_SESSION['change-pwd'];
                        unset($_SESSION['change-pwd']);
                    }

                ?>
                <br><br><br>

                 
                <a href="add-user.php" class="btn btn-primary">Add New Account</a>

                <br /><br /><br />

                <table class="tbl-full">
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>User Type</th>
                        <th>Actions</th>
                    </tr>

                    
                    <?php 
                         
                        $sql = "SELECT * FROM tbl_accounts";
                        
                        $res = mysqli_query($conn, $sql);
 
                        if($res==TRUE)
                        {
                            
                            $count = mysqli_num_rows($res);  

                            $sn=1;  
 
                            if($count>0)
                            {
                                
                                while($rows=mysqli_fetch_assoc($res))
                                {
                                   
                                   
                                    $id=$rows['id'];
                                    $full_name=$rows['full_name'];
                                    $email=$rows['email'];
                                    $username=$rows['username'];
                                    $role=$rows['role'];

                                    ?>
                                    
                                    <tr>
                                        <td><?php echo $sn++; ?>. </td>
                                        <td><?php echo $full_name; ?></td>
                                        <td><?php echo $email; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td><?php echo $role; ?></td>
                                        <td>
                                            <a href="update-password.php?id=<?php echo $id; ?>" class="btn btn-primary">Change Password</a>
                                            <a href="update-user.php?id=<?php echo $id; ?>" class="btn btn-primary">Update</a>
                                            <a href="delete-user.php?id=<?php echo $id; ?>" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>

                                    <?php

                                }
                            }
                            else
                            {
                                 echo "No data found!";
                            }
                        }

                    ?>


                    
                </table>

            </div>
        </div>
        

<?php include('partials/footer.php'); ?>
