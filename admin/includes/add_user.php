<?php
    if(isset($_POST['add_user'])){
        $user_fname = escape($_POST['user_firstname']);
        $user_lname = escape($_POST['user_lastname']);
        $user_email = escape($_POST['user_email']);
        //Images
        $user_image = $_FILES['user_image']['name'];
        $user_temp_image = $_FILES['user_image']['tmp_name'];

        $user_role = escape($_POST['user_role']);
        $user_name = escape($_POST['user_name']);
        $user_password = escape($_POST['user_password']);

        //Call Function
        add_user($user_fname, $user_lname, $user_email, $user_image, $user_temp_image, $user_role, $user_name, $user_password);
		
		echo "<div class='alert alert-success'>
				<strong>Success!</strong> You have successfully added a new user.
		     </div>";

    }

?>

   <form action="" method="post" enctype="multipart/form-data">
   
       <div class="form-group">
            <label for="user_firstname">Firstname</label>
            <input type="text" class="form-control" name="user_firstname" placeholder="John">
        </div>
        
         <div class="form-group">
           <label for="user_lastname">Lastname</label>
           <input type="text" class="form-control" name="user_lastname" placeholder="Bennet">
         </div>
         
        <div class="form-group">
            <label for="user_email">User Email</label>
            <input type="email" class="form-control" name="user_email" placeholder="example@example.com">
        </div>
        
        <div class="form-group">
           <label for="user_image">User Image</label>
           <input type="file" name="user_image">
        </div>
        
        <div class="form-group">
            <label for="user_role">User Role</label>
            <select name="user_role" id="" class="form-control">
                <option value="subscriber">Select Options</option>
                <option value="admin">Admin</option>
                <option value="subscriber">Subscriber</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="user_name" placeholder="Username">
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="user_password">
        </div>  
        
        <div class="form-group">
            <input type="submit" name="add_user" value="Add User" class="btn btn-success">
        </div>
</form>