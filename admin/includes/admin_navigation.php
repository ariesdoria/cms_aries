<!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">CMS Admin</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
               <li>
                   <a href="">Online Users:<span class="usersonline"></span></a>
               </li>
               <li><a href="../index">Home</a></li>
               <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                     <!--Displaying user's profile picture using PREPARED statements-->
                    <?php 
                        if (isset($_SESSION['username'])) {
                            $username = $_SESSION['username'];    
                            
                            $stmt = mysqli_prepare($connection, "SELECT user_image FROM users WHERE user_name = ?");
                            mysqli_stmt_bind_param($stmt, "s", $username);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $username);
                            mysqli_stmt_fetch($stmt);
                            mysqli_stmt_close($stmt);
                        }
                     ?>
                    <img width='30' class='img-responsive; img-circle' src='../images/<?php echo $username; ?>'>

					 <?php
                        if(isset($_SESSION['username'])){
                          $username = $_SESSION['username'];

                        echo "@".$username;
                        }
					 ?>
					<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-list-alt"></i> My Posts</a>
                        </li>
                        <li>
                            <a href="./profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>


            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                   <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i>Posts<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="posts_dropdown" class="collapse">
                            <li>
                                <a href="posts.php">View All Posts</a>
                            </li>
                            <li>
                                <a href="posts.php?source=add_post">Add Post</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="categories"><i class="fa fa-fw fa-wrench"></i> Categories</a>
                    </li>
                    <li class="">
                        <a href="comments"><i class="fa fa-fw fa-file"></i> Comments</a>
                    </li>
                     <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Users<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="users.php">View All Users</a>
                            </li>
                            <li>
                                <a href="users.php?source=add_user">Add User</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="profile"><i class="fa fa-fw fa-user"></i> My Profile</a>
                    </li>
                </ul>
            </div>


            <!-- /.navbar-collapse -->
        </nav>