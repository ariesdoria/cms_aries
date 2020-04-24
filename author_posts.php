<!--Output buffering-->
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
                        $the_post_author = $_GET['author'];
                    }

                    $query = "SELECT * FROM posts WHERE post_user = '{$the_post_author}'";
                    $select_all_posts_query = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $posts_author = $row['post_user'];
                    }
                    
                 ?>

                  <h1>All Posts by
                    <small><?php echo $posts_author; ?></small>
                  </h1>

                <?php

                    if(isset($_GET['p_id'])){

                        $the_post_id = $_GET['p_id'];
                        $the_post_author = $_GET['author'];

                    }

                    $query = "SELECT * FROM posts WHERE post_user = '{$the_post_author}'";
                    $select_all_posts_query = mysqli_query($connection,$query);

                    while($row = mysqli_fetch_assoc($select_all_posts_query)){
                        $posts_title = $row['post_title'];
                        $posts_author = $row['post_user'];
                        $posts_date = $row['post_date'];
                        $posts_image = $row['post_image'];
                        $posts_content = $row['post_content'];

                ?>
                
                <!-- First Blog Post -->
                <h2>
                    <a href="#">
                    <?php
                        echo $posts_title;
                    ?>
                    </a>
                </h2>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $posts_date;?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $posts_image;?>" alt="">
                <hr>
                <p>
                    <?php
                        echo $posts_content;
                    ?>
                </p>
                <hr>
                <?php
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
