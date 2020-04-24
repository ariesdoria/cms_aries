<?php ob_start(); ?>
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

                    if(isset($_GET['p_id'])){

                        $the_post_id = $_GET['p_id'];
                        // Increment the number of post views when a user view a specific post
                        $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = {$the_post_id} ";
                        $send_query = mysqli_query($connection,$view_query);
                        
                        if(!$send_query){
                            die('Query failed'.mysqli_error($connection));
                        }
    
                        if (isset($_SESSION['role'])) {
                            if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'admin') {
                                $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
                            } else {
                                $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published'";
                            }
                        } else {
        
                            $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published'";
                        }
                            $select_all_posts_query = mysqli_query($connection,$query);

                            if (mysqli_num_rows($select_all_posts_query) < 1) {
                                echo "<h1 class='text-center'>No posts available</h1>";
                            }
                            else{
                                while($row = mysqli_fetch_assoc($select_all_posts_query)){
                                    $posts_title = $row['post_title'];
                                    $posts_user = $row['post_user'];
                                    $posts_date = $row['post_date'];
                                    $posts_image = $row['post_image'];
                                    $posts_content = $row['post_content'];
                    ?>
                <!-- First Blog Post -->
                <h2 align="center">
                    <a href="#">
                    <?php
                        echo $posts_title;
                    ?>
                    </a>
                </h2>
                <p class="lead" align="center">
                    by <a href="author_posts.php?author=<?php echo $posts_user;?>&p_id=<?php echo $the_post_id;?>">
                    <?php
                        echo $posts_user;
                    ?>
                    </a>
                </p>
                <p align="center"><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $posts_date;?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo imagePlaceHolder($posts_image);?>" alt="">
                <hr>
                <p>
                    <?php
                        echo $posts_content;
                    ?>
                </p>
                <?php if (isset($_SESSION['username'])): ?>
                <a class="btn btn-primary" href="/cms_aries/admin/posts.php?source=edit_post&p_id=<?php echo $the_post_id;?>">Edit Post</a>
                <?php else: ?>
                <?php endif; ?>
                <div class="clearfix">
                    
                </div>
                <br>
                <?php
                    }
                ?>

               <!--  If the user is logged in, display the add comment section. Otherwise, hide it to make the user read only the blog-->
               <?php if (isset($_SESSION['role'])): ?>
                <!-- Blog Comments -->
                <?php
                   
                   if (isset($_POST['create_comment'])) {
                       $the_post_id = $_GET['p_id'];
                       $comment_author = escape($_POST['comment_author']);
                       $comment_email = escape($_POST['comment_email']);
                       $comment_content = escape($_POST['comment_content']);
                       $comment_date = date('Y-m-d');
                       $comment_status = "Approved";
                       //Comment Images
                       $comment_image = $_FILES['comment_image']['name'];
                       $comment_temp_image = $_FILES['comment_image']['tmp_name'];
                       if (!empty($comment_author) || !empty($comment_email) || !empty($comment_content)) {
                           blog_add_comments($the_post_id, $comment_author, $comment_email, $comment_content, $comment_status, $comment_date, $comment_image) ;

                           echo "<div class='alert alert-success'>
                                    <strong>Success!</strong> You have successfully posted a comment regarding to the post!
                                </div>";
                       }else{
                            echo "<script>alert('Field(s) cannot be empty!)</script>";
                       }
                   }
                ?>
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                           <input type="file" name="comment_image">
                        </div>

                        <div class="form-group">
                            <input type="text" placeholder="Name" name="comment_author" class="form-control">
                        </div>

                        <div class="form-group">
                            <input type="email" placeholder="Email" name="comment_email" class="form-control">
                        </div>

                        <div class="form-group">
                            <textarea name="comment_content" class="form-control" placeholder="Your thoughts on the topic" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="create_comment">Comment</button>
                    </form>
                </div>
                <?php else: ?>
                <div class="well">
                    <h4 class="text-primary">Wanna leave your thoughts on the post?</h4>
                    <p class="text-info"><a href="registration.php">Sign up</a> now or <a href="login.php">login</a> to your account, and never miss a discussion.</p>
                </div>
                <?php endif; ?>
                <hr>
                
                <!-- Posted Comments -->
               <?php

                $select_comment_query = postedComments($the_post_id);

                if(!$select_comment_query){
                    die('Query failed'.mysqli_error($connection));
                }
                    while($row = mysqli_fetch_array($select_comment_query)){
                        $comment_image = $row['comment_image'];
                        $comment_date = $row['comment_date'];
                        $comment_content = $row['comment_content'];
                        $comment_author = $row['comment_author'];

                ?>
                <!-- If the user is logged in, display the posted comments seciton. Otherwise, hide it -->
                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" width="64" height="64" src="images/<?php echo $comment_image; ?>" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">
                            <?php
                                echo $comment_author;
                            ?>
                            <small>
                            <?php
                                echo $comment_date;
                            ?>
                            </small>
                        </h4>
                        <?php
                            echo $comment_content;
                        ?>
                    </div>
                </div>
            <?php
            }
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
