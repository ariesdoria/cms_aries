<?php
    include "includes/admin_header.php";
?>
<?php

	if(isset($_SESSION['username'])){
		
		$username = $_SESSION['username'];

		$query = "SELECT * FROM users WHERE user_name = '{$username}' ";
		
		$select_user_profile_query = mysqli_query($connection, $query);
		
		while($row = mysqli_fetch_assoc($select_user_profile_query)){
			$user_name = $row['user_name'];
			$user_firstname = $row['user_firstname'];
			$user_lastname = $row['user_lastname'];
			$user_email = $row['user_email'];
			$user_role = $row['user_role'];
			$user_image = $row['user_image'];
			$user_password = $row['user_password'];

			confirm($select_user_profile_query);
		}
	}
?>
<?php
	if(isset($_POST['edit_user'])){
        
        $the_user_firstname = escape($_POST['user_firstname']);
        $the_user_lastname = escape($_POST['user_lastname']);
        $the_user_email = escape($_POST['user_email']);
        //Profile Images
        $the_user_temp_image = $_FILES['user_image']['name'];
        $the_user_image = $_FILES['user_image']['tmp_name'];

        $the_user_name = escape($_POST['user_name']);
        $the_user_password = escape($_POST['user_password']);

        copy($the_user_temp_image, "../images/$the_user_image");

        if (!empty($the_user_password)) {

        	$stmt = mysqli_prepare($connection, "SELECT user_password FROM users WHERE user_name = (?)");
        	mysqli_stmt_bind_param($stmt, "s", $username);
        	mysqli_stmt_execute($stmt);
        	//Bind the results to the username
        	mysqli_stmt_bind_result($stmt, $username);
        	//Fetch the results of the query to pass in to the username
        	mysqli_stmt_fetch($stmt);
        	//close the prepared statement
        	mysqli_stmt_close($stmt);

 			confirm($get_user_query);

 			$row = mysqli_fetch_array($get_user_query);
 			$db_user_password = $row['user_password'];

 			if ($db_user_password != $the_user_password) {
 				$hashed_password = password_hash($the_user_password, PASSWORD_BCRYPT, array('cost' => 10));
 			}

 			$stmt = mysqli_prepare($connection, "UPDATE users SET user_firstname = (?), user_lastname = (?), user_email = (?), user_image = (?), user_password = (?) WHERE user_name = (?) ");
 			mysqli_stmt_bind_param($stmt, "ssssss", $the_user_firstname, $the_user_lastname, $the_user_email, $the_user_temp_image, $hashed_password, $the_user_name);
 			mysqli_stmt_execute($stmt);
 			mysqli_stmt_close($stmt);

	        $update_user = mysqli_query($connection,$query);
	        header("Location: profile.php");
    		}
        }
?>

    <div id="wrapper">
        
        <!--Navigation-->
        <?php 
            include "includes/admin_navigation.php";
        ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                       
                        <h1 class="page-header">
                            Welcome to CMS Admin
                            <small>
                                <?php
                                    welcome_user();
                                ?>
                            </small>
                        </h1>
	<!--This is for the add profile-->
	<form action="" method="post" enctype="multipart/form-data">

		<div class="form-group">
			<img src='../images/<?php echo $user_image; ?>' width='100px' class='img-rounded' alt="">
		</div>

		<div class="form-group">
		<label for="username">Username</label>
		<p class="text text-info"><?php echo "@".$user_name; ?></p>
		</div>

		<div class="form-group">
			<label for="userRole">Current Role</label>
			<p class="text text-info"><?php echo $user_role; ?></p>
		</div>

		<div class="form-group">
		<label for="user_image">User Image</label>
		<input type="file" name="user_image">
		</div>

		<div class="form-group">
		<label for="user_firstname">Firstname</label>
		<input type="text" value="<?php echo $user_firstname; ?>" class="form-control" name="user_firstname" placeholder="John">
		</div>

		<div class="form-group">
		<label for="user_lastname">Lastname</label>
		<input type="text" value="<?php echo $user_lastname; ?>" class="form-control" name="user_lastname" placeholder="Bennet">
		</div>

		<div class="form-group">
		<label for="user_email">Email Address</label>
		<input type="email" value="<?php echo $user_email; ?>" class="form-control" name="user_email" placeholder="example@example.com">
		</div>

		<div class="form-group">
		<label for="password">Password</label>
		<input type="password" class="form-control" autocomplete="off" name="user_password">
		</div>  

		<div class="form-group">
		<input type="submit" name="edit_user" value="Update Profile" class="btn btn-primary">
		</div>
	</form>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <?php 
        include "includes/admin_footer.php";
    ?>
