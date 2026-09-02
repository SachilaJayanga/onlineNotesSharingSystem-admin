<?php 
session_start();
include_once('partials/navbar.php'); 

?>

<body>
<section class="menu">
    <div class="container">
        <h2 class="text-center">Explore</h2>
        <hr>
        <br>
        
        <?php 
             $sql = "SELECT * FROM tbl_subjects WHERE active='Yes'";
             $res = mysqli_query($conn, $sql);
             $count = mysqli_num_rows($res);

            if($count>0)
            {
                 while($row=mysqli_fetch_assoc($res))
                {
                     $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    ?>
                    
                    <a href="category.php?subject_id=<?php echo $id; ?>">
                        
                        <div class="box-3 float-container">
                            <?php 
                                 if($image_name=="")
                                {
                                     echo "<div class='error'>Image not Available</div>";
                                }
                                else
                                {
                                     ?>
                                    <img src="../images/category/<?php echo $image_name; ?>" alt="search-bg" class="img-responsive img-curve">
                                    <?php
                                }
                            ?>
                            

                            <h3 class="float-text text-white"><?php echo $title; ?></h3>
                        </div>
                    </a>

                    <?php
                }
            }
            else
            {
                 echo "<div class='error'>Category not Added.</div>";
            }
        ?>


        <div class="clearfix"></div>
    </div>
</section>
 </body>




<?php include('partials/footer.php') ?>
