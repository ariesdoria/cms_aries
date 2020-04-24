<?php 

    if (ifItIsMethod('post')) {

        if (isset($_POST['login'])) {
           
        if (isset($_POST['username']) && isset($_POST['password'])) {
            login_user($_POST['username'], $_POST['password']);
        }else{
            redirect(htmlspecialchars($_SERVER["PHP_SELF"]));
        }
    }
}

 ?>           

            <div class="col-md-4">
                <!--If the user is not logged in, don't display the search blog-->
                <!-- Blog Search Well -->
                <?php if (isset($_SESSION['role'])):?>
                <div class="well">
                    <h4 class="text-primary">Search Blog</h4>
                    <form action="search.php" method="post">
                    <div class="input-group">
                        <input name="search" type="text" class="form-control">
                        <span class="input-group-btn">
                            <button name="submit" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    </form><!--search form-->
                    <!-- /.input-group -->
                </div>
            <?php else: ?>
            <?php endif; ?>
                
                <!-- Login -->
                <div class="well">
                    <!-- Check if the user is logged in -->
                    <?php if (isset($_SESSION['role'])): ?>
                    
                    <?php 
                        if (isset($_SESSION['username'])) {
                            $username = $_SESSION['username'];


                            $query = "SELECT user_image, user_firstname, user_lastname FROM users WHERE user_name = '{$username}'";
                            $select_user = mysqli_query($connection, $query);

                            if (!$select_user) {
                                die('Error loading profile'.mysqli_error($connection));
                            }
                            while ($row = mysqli_fetch_assoc($select_user)) {
                                $profile_picture = $row['user_image'];
                                $user_fname = $row['user_firstname'];
                                $user_lname = $row['user_lastname'];
                            }
                        }
                     ?>
                    <img width='45' class='img-responsive; img-circle' src='images/<?php echo $profile_picture; ?>'>
                    <h4 style="margin-top:-40px;margin-left:50px;"><a href="/cms_aries/admin/index">
                    <?php echo $user_fname." ".$user_lname; ?></a></h4>
                    <h5 style="margin-left:50px;"><a href="/cms_aries/admin/index"><?php echo "@".$username; ?></a></h5>
                    <h4 style="margin-left:3px;" class='text text-info'>Posts</h4>
                    <?php 
                        if (isset($_SESSION['username'])) {
                            $username = $_SESSION['username'];

                            $stmt = mysqli_prepare($connection, "SELECT COUNT(post_id) AS post_id FROM posts WHERE post_user = (?)");
                            mysqli_stmt_bind_param($stmt, "s", $username);
                            mysqli_stmt_execute($stmt);
                            if (!$stmt) {
                                die('Failed to count total posts'.mysqli_error($connection));
                            }
                            mysqli_stmt_bind_result($stmt, $username);
                            mysqli_stmt_fetch($stmt);
                            mysqli_stmt_close($stmt);
                        }
                     ?>
                     <h4 style="margin-left:10px;" class='text text-info'><?php echo $username; ?></h4>

                     <h4 style="margin-left:95px;margin-top:-58px;" class='text text-info'>Categories</h4>
                      <?php 
                        if (isset($_SESSION['username'])) {
                            $username = $_SESSION['username'];

                            $query = "SELECT COUNT(category_id) AS category_id FROM categories";
                            $count_total_categories_from_logged_in_user = mysqli_query($connection, $query);

                            if (!$count_total_categories_from_logged_in_user) {
                                die('Failed to count total categories'.mysqli_error($connection));
                            }
                            while ($row = mysqli_fetch_assoc($count_total_categories_from_logged_in_user)) {
                                $total_categories = $row['category_id'];
                            }
                        }
                     ?>
                    <h4 style="margin-left:95px;" class='text text-info'><?php echo $total_categories; ?></h4>
                    <h4 style="margin-left:230px;margin-top:-58px;" class='text text-info'>Comments</h4>
                      <?php 
                        if (isset($_SESSION['username'])) {
                            $username = $_SESSION['username'];

                            $query = "SELECT COUNT(comment_id) AS comment_id FROM comments";
                            $count_total_comments_from_logged_in_user = mysqli_query($connection, $query);

                            if (!$count_total_comments_from_logged_in_user) {
                                die('Failed to count total comments'.mysqli_error($connection));
                            }
                            while ($row = mysqli_fetch_assoc($count_total_comments_from_logged_in_user)) {
                                $total_comments = $row['comment_id'];
                            }
                        }
                     ?>
                    <h4 style="margin-left:230px;" class='text text-info'><?php echo $total_comments; ?></h4>
                    <?php else: ?>

                    <h4>Sign in to CMS</h4>

                    <form  method="post">
                    <div class="form-group">
                        <input name="username" type="text" class="form-control" placeholder="Enter Username">
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" placeholder="Enter Password">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" name="login" type="submit">
                                Sign in
                            </button>
                        </span>
                    </div>
                        <div class="form-group">
                            <a href="forgot_password.php?forgot=<?php echo uniqid(true); ?>">Forgot password?</a>
                        </div>
                    </form>

                    <?php endif; ?>

                    <!--search form-->
                    <!-- /.input-group -->
                </div>

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4 class="text-primary">Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-group">
                            <!--Check if the user is logged in-->
                            <?php if (isset($_SESSION['role'])): ?>
                            <!--Display blog categories if the user is logged in-->   
                            <?php

                           $query = "SELECT * FROM categories";
                           $select_categories_sidebar = mysqli_query($connection,$query);

                            while($row = mysqli_fetch_assoc($select_categories_sidebar)){
                                $cat_id = $row['category_id'];
                                $cat_title = $row['category_title'];
                    
                            echo "<li class='list-group-item'><a href='category.php?category={$cat_id}'>{$cat_title}</a></li>";
                            }
                            ?>
                            <!--If the user is logged out display message-->
                            <?php else: ?>
                            <p class="text-info">We have some of the popular blog categories to watch out for and also a good read, based on your preference.</p>
                            <p class="text-info"><a href="registration.php">Sign up</a> now or <a href="login.php">login</a> to your account, and never miss an update.</p>

                            <?php endif; ?>
                            </ul>
                        </div>
                        
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <?php include "widget.php";?>

                <!--Recommendations Well-->
                <?php include "contact.php"; ?>

            </div>