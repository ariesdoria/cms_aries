<!--Database Connection-->
<?php
    include "includes/db.php";
?>
<!--Header-->
<?php 
    include "includes/header.php";
?>

<!-- Navigation -->
<?php
    include "includes/navigation.php";
?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                
                    if(isset($_GET['category'])){
                        
                    $post_category_id = $_GET['category'];

                      /*if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
                            $query = "SELECT * FROM posts WHERE post_id = $post_category_id";
                        }
                        else{*/
                            $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id AND post_status = 'Published'";
                        //}
                    $select_all_posts_query = mysqli_query($connection,$query);
                    
                    //If there is no post regarding the category
                    if(mysqli_num_rows($select_all_posts_query) < 1){

                        echo "<h1>There's currently no post regarding this category</h1>";
                    }
                    else{

                    while($row = mysqli_fetch_assoc($select_all_posts_query)){
                        $post_id = $row['post_id'];
                        $posts_title = $row['post_title'];
                        $posts_user = $row['post_user'];
                        $posts_date = $row['post_date'];
                        $posts_image = $row['post_image'];
                        $posts_content = substr($row['post_content'],0,100);    
                        
                ?>
                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>">
                    <?php 
                        echo $posts_title;
                    ?>
                    </a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $posts_user; ?>&p_id=<?php echo $post_id;?>">
                    <?php
                        echo $posts_user;
                    ?>
                    </a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $posts_date;?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $posts_image;?>" alt="">
                <hr>
                <p>
                    <?php
                        echo $posts_content;
                    ?>
                </p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id;?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
                <?php }
                        }
                          }
                        else{
                                header("Location: index.php");  
                            }
                 ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php 
                include "includes/sidebar.php";
            ?>

        </div>
        <!-- /.row -->

        <hr>
<!--Footer-->
<?php
    include "includes/footer.php";        
?>
