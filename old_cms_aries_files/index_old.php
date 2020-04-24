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
                    $query = "SELECT * FROM posts";
                    $select_all_posts_query = mysqli_query($connection,$query);

                    while($row = mysqli_fetch_assoc($select_all_posts_query)){
                        $post_id = $row['post_id'];
                        $posts_title = $row['post_title'];
                        $posts_author = $row['post_author'];
                        $posts_date = $row['post_date'];
                        $posts_image = $row['post_image'];
                        $posts_content = substr($row['post_content'],0,100);
                        $post_status = $row['post_status'];

                        if($post_status !== 'Published'){

                        }
                ?>
                        <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>">
                    <?php
                        echo $posts_title;
                    ?>
                    </a>
                </h2>
                <p class="lead">
                    Posted by <a href="author_posts.php?author=<?php echo $posts_author; ?>&p_id=<?php echo $post_id;?>">
                    <?php
                        echo $posts_author;
                    ?>
                    </a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $posts_date;?></p>
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
