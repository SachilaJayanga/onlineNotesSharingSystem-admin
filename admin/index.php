<?php 
session_start();
include_once('partials/navbar.php'); 

?>

<?php

        error_reporting(0);
        include('../config/constants.php');
        if (strlen($_SESSION['id']== 0)) {
        header('location:../login.php');
        } else{

        }

        ?>

<?php
 

$id = $_SESSION['id'];
$sql = "SELECT * FROM tbl_accounts WHERE id = '$id'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $username = htmlspecialchars($user['username']);
    $profile_image = !empty($user['image_profile']) ? "../images/icon/{$user['image_profile']}" : "../images/default-profile.png";
} else {
    echo "No user found.";
}
?>



<div style="text-align: right; margin: 20px;">
    <img src="<?php echo $profile_image; ?>" alt="Profile Image " class="profile-image">
    <p style="align-content:center"><?php echo $username; ?></p>
</div>


<br><br>

<div class="text-center">   
    <h2><font color=gray font-family=arial>Online Notes Sharing System</font></h2>
</div>

<br><br>

         <div class="main-content">
            <div class="wrapper">
            
                <h4>Admin Dashboard  </h4>
 
                <br><br>

            <div class="float-container">      
                <div class="col-4 text-center">

                    <?php 
                         
                        $sql = "SELECT * FROM tbl_subjects";
                        
                        $res = mysqli_query($conn, $sql);
                       
                        $count = mysqli_num_rows($res);
                    ?>

                    <h1><?php echo $count; ?></h1>
                    <br>
                    Subjects
                </div>

                <div class="col-4 text-center">

                    <?php 
                        
                        $sql2 = "SELECT * FROM tbl_notes";
                       
                        $res2 = mysqli_query($conn, $sql2);
                       
                        $count2 = mysqli_num_rows($res2);
                    ?>

                    <h1><?php echo $count2; ?></h1>
                    <br>
                    Uploads
                </div>

                <div class="col-4 text-center">
                    
                    <?php 
                        
                        $sql3 = "SELECT * FROM tbl_accounts";
                         
                        $res3 = mysqli_query($conn, $sql3);
                        
                        $count3 = mysqli_num_rows($res3);
                    ?>

                    <h1><?php echo $count3; ?></h1>
                    <br>
                    Total Users
                </div>
            </div>  
                

                <div class="clearfix"></div>

            </div>
            
        </div>
        
<section class="search text-center">
    <div class="container">
        
        <form action="search.php" method="POST">
        
            <input type="search" name="search" placeholder="Search Notes.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">  
        </form>
        
    </div>
</section>
 
<?php 
    if(isset($_SESSION['order']))
    {
        echo $_SESSION['order'];
        unset($_SESSION['order']);
    }
?>

 
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Notes</h2>

        <?php 
          
            $sql = "SELECT * FROM tbl_subjects WHERE active='Yes' LIMIT 6";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if($count > 0) {
                
                while($row = mysqli_fetch_assoc($res)) {
                    
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    ?> 
                        <div class="btn box-3 float-container">
                            <a href="category.php?subject_id=<?php echo $id; ?>">
                            <?php 
                                if ($image_name == "") {
                                     echo "<img src='../images/default.png' alt='notes' class='img-responsive img-curve' width='50px'>";
                                } else {
                                     ?>
                                    <img src="../images/category/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                                    <?php
                                }
                            ?>
                            <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </a>
                        </div> 
                    <?php
                }
            } else {
               
                echo "<div class='error'>Category not Added.</div>";
            }
        ?>
        <div class="clearfix"></div>
    </div>
</section>
 
 <section class="menu">
    <div class="container">
        <h2 class="text-center">Trending</h2>
            <hr>
        <?php 
        
         
       
        $sql2 = "SELECT * FROM tbl_notes WHERE active='Yes' ORDER BY likes DESC LIMIT 4";

         
        $res2 = mysqli_query($conn, $sql2);

       
        $count2 = mysqli_num_rows($res2);
 
        if($count2>0)
        {
             
            while($row=mysqli_fetch_assoc($res2))
            {
                
                $note_id = $row['note_id']; 
                $title = $row['title'];
                $image_name = $row['image_name'];
                ?>

                <div class="menu-box box-3 float-container">
                    <div class="menu-img">
                    <a href="note_page.php?note_id=<?php echo $note_id; ?>" class="btn-primary">
                        <?php 
                           
                            if($image_name=="")
                            {
                          
                                echo "<img src='../images/default.png' alt='notes' class='img-responsive img-curve' width='50px'>";
                            }
                            else
                            {
                               
                                ?>
                                <img src="../images/icon/<?php echo $image_name; ?>" alt="image" class="img-responsive img-curve">
                                <?php
                            }
                        ?>
                        </a>
                    </div>

                    <div class="menu-desc">
                        <h4 style="text-align: center;"><?php echo $title; ?></h4>
                        <br>
                    </div>
                </div>

                <?php
            }
        }
        else
        {
            
            echo "<div class='error'>Food not available.</div>";
        }
        
        ?>

        



        <div class="clearfix"></div>

        

    </div>
<hr>
    <p class="text-center">
        <a href="./notes.php">See All Documents</a>
    </p>
    
</section>




<?php include('partials/footer.php') ?>
