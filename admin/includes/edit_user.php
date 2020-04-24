<?php
        //Receive data from the url in the view all user
        if(isset($_GET['edit_user'])){
            $the_user_id = escape($_GET['edit_user']);

            $query = "SELECT * FROM users WHERE user_id = {$the_user_id} ";
            $select_users_query = mysqli_query($connection,$query);

            while($row = mysqli_fetch_assoc($select_users_query)){

            $user_id = $row['user_id'];
            $user_name = $row['user_name'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];
            $user_password = $row['user_password'];

        }
    }
?>

<?php
     //Edit user and also the password that is hashed    
     if(isset($_POST['edit_user'])){
        
        $user_firstname = escape($_POST['user_firstname']);
        $user_lastname = escape($_POST['user_lastname']);
        $user_email = escape($_POST['user_email']);
        //Profile Images
        $user_image = $_FILES['user_image']['name'];
        $user_temp_image = $_FILES['user_image']['tmp_name'];

        $user_role = escape($_POST['user_role']);
        $user_password = escape($_POST['user_password']);
        
            if(!empty($user_password)){
            
            $stmt = mysqli_prepare($connection, "SELECT user_password FROM users WHERE user_id = (?)");
            mysqli_stmt_bind_param($stmt, "i", $the_user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $the_user_id);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            confirm($stmt);
            
            $db_user_password = $row['user_password'];
            
            if($db_user_password != $user_password){
                editUsers($user_firstname, $user_lastname, $user_email, $user_image, $user_temp_image, $user_role, $user_password, $user_id);
            }

             echo "<div class='alert alert-success'>
                        <strong>Success!</strong> You have successfully updated one user!<a href='users.php'>View Users?</a>
                   </div>";
        }
    }
?>
   

   <form action="" method="post" enctype="multipart/form-data">

       <div class="form-group">
           <img src="../images/<?php echo $user_image; ?>" width="100" height="100" align="center" class="img-rounded" alt="">
       </div>

       <div class="form-group">
            <label for="username">Username</label>
            <p class="text text-info"><?php echo "@".$user_name; ?></p>
        </div>

        <div class="form-group">
            <label for="currentRole">Current Role</label>
            <p class="text text-info"><?php echo $user_role; ?></p>
        </div>
    
       <div class="form-group">
            <label for="user_firstname">Update Firstname</label>
            <input type="text" value="<?php echo $user_firstname; ?>" class="form-control" name="user_firstname" placeholder="John">
        </div>
        
         <div class="form-group">
           <label for="user_lastname">Update Lastname</label>
           <input type="text" value="<?php echo $user_lastname; ?>" class="form-control" name="user_lastname" placeholder="Bennet">
         </div>
         
        <div class="form-group">
            <label for="user_email">Update User Email</label>
            <input type="email" value="<?php echo $user_email; ?>" class="form-control" name="user_email" placeholder="example@example.com">
        </div>
        
        <div class="form-group">
           <label for="user_image">Update Profile Picture</label>
           <input type="file" name="user_image">
        </div>
        
        <div class="form-group">
            <label for="user_role">Update User Role</label>
            <select name="user_role" id="" class="form-control">
               <option value="<?php echo $user_role; ?>"></option>
               <?php
                
                    if($user_role == 'Admin'){
                        echo "<option value='Subscriber'>Subscriber</option>";      
                    }
                    else{
                        echo "<option value='Admin'>Admin</option>";
                    }
                ?>
            </select>
        </div>

        <div class="form-group centered_div">
            <label for="password">Update Password</label>
            <input type="password" class="form-control" autocomplete="off" name="user_password">
        </div>  
        
        <div class="form-group">
            <input type="submit" name="edit_user" value="Update User Profile" class="btn btn-info">
        </div>
</form>