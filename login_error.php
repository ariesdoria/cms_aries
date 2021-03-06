<!-- Start output buffering -->
<?php ob_start(); ?>
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
    include "includes/navigation.php";?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                
                        $per_page = 2;
                    
                    if(isset($_GET['page'])){
                        
                        $page = $_GET['page'];
                    }else{
                        $page = "";
                    }
                    
                    if($page == "" || $page == 1){
                        $page_1 = 0;
                    }else{
                        $page_1 = ($page * $per_page) -  $per_page;
                    }
                      if(isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'){
                            $post_query_count = "SELECT * FROM posts";
                        }
                    else{
                            $post_query_count = "SELECT * FROM posts WHERE post_status = 'Published'";
                        }
                    $find_count = mysqli_query($connection,$post_query_count);
                    $count = mysqli_num_rows($find_count);
                    
                    if($count < 1){
                        echo "<div>
                                <div class='alert alert-danger'>
                                    <span>&#10006;</span> Sorry but that user does not exist in our database. Please try again.
                                </div>
                              </div>";
                    }
                    else{
                        $count = ceil($count / $per_page);

                        $query = "SELECT * FROM posts LIMIT $page_1, $per_page";
                        $select_all_posts_query = mysqli_query($connection,$query);

                    while($row = mysqli_fetch_assoc($select_all_posts_query)){
                        $post_id = $row['post_id'];
                        $posts_title = $row['post_title'];
                        $posts_user = $row['post_user'];
                        $posts_date = $row['post_date'];
                        $posts_image = $row['post_image'];
                        $posts_content = substr($row['post_content'],0,100);
                        $post_status = $row['post_status'];
                ?>
                <!-- First Blog Post -->
                
                <h2 align="center">
                    <a href="post.php?p_id=<?php echo $post_id; ?>">
                    <?php
                        echo $posts_title;
                    ?>
                    </a>
                </h2>
                <p class="lead" align="center">
                    Posted by <a href="author_posts.php?author=<?php echo $posts_user; ?>&p_id=<?php echo $post_id;?>">
                    <?php
                        echo $posts_user;
                    ?>
                    </a>
                </p>
                <p align="center"><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $posts_date;?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id; ?>">
                <img class="img-responsive" src="images/<?php echo $posts_image;?>" alt="">
                </a>
                <hr>
                <p>
                    <?php
                        echo $posts_content;
                    ?>
                </p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id;?>">
                Read More <span class="glyphicon glyphicon-chevron-right"></span>
                </a>

                <hr>
				<?php
                        }
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
        <!--Pagination-->
        <ul class="pager">
            <?php
                for($i = 1; $i <= $count; $i++){
                    if($i == $page){
                        echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</li>";    
                    }else{
                        echo "<li><a href='index.php?page={$i}'>{$i}</li>";
                    }
                }
            ?>
        </ul>
<!--Footer-->
<?php
    include "includes/footer.php";
?>
