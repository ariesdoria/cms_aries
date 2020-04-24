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
                    if(isset($_POST['submit'])){
                        $search = $_POST['search'];
                    }
                    $query = "SELECT * FROM posts WHERE post_tag LIKE '%$search%' ";
                    $search_query = mysqli_query($connection,$query);
                
                    if(!$search_query){
                        die("Query failed".mysqli_error($connection));
                    }
                
                    $count = mysqli_num_rows($search_query);
                
                    if($count == 0){
                        echo "  <hr>
                                    <div class='alert alert-danger'>
                                        <strong>Sorry,</strong> but we couldn't find any results matching ".$search.";
                                    </div>
                                <hr>";
                    }
                    else{
                        
                            while($row = mysqli_fetch_assoc($search_query)){
                            $posts_title = $row['post_title'];
                            $posts_author = $row['post_author'];
                            $posts_date = $row['post_date'];
                            $posts_image = $row['post_image'];
                            $posts_content = $row['post_content'];    
                        
                            ?>
                            <h1 class="page-header">
                                Page Heading
                                <small>Secondary Text</small>
                            </h1>

                            <!-- First Blog Post -->
                            <h2>
                                <a href="#">
                                <?php 
                                    echo $posts_title;
                                ?>
                            </a>
                            </h2>
                            <p class="lead">
                            by <a href="index.php">
                                <?php
                                    echo $posts_author;
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
                            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                            <hr>
                            <?php } 
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
