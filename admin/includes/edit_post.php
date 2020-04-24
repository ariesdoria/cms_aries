<?php

    //Receive data from the url in the view all post
    if(isset($_GET['p_id'])){

    $the_post_id = $_GET['p_id'];

    }

        $query = "SELECT * FROM posts WHERE post_id = {$the_post_id} ";
        $select_posts_by_id = mysqli_query($connection,$query);

        while($row = mysqli_fetch_assoc($select_posts_by_id)){

        $post_id = $row['post_id'];
        $post_user = $row['post_user'];
        $post_title = $row['post_title'];
        $post_category = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tag = $row['post_tag'];
        $post_comments = $row['post_comment_count'];
        $post_date = $row['post_date'];
        $post_content = $row['post_content'];

        }

    if(isset($_POST['update_post'])){

        $the_post_title = escape($_POST['title']);
        $the_post_category = escape($_POST['category']);
        $the_post_user = escape($_POST['post_user']);
        $the_post_status = escape($_POST['post_status']);
        $the_post_tag = escape($_POST['tags']);
        $the_post_content = escape($_POST['content']);
        $the_post_image = $_FILES['image']['name'];
        $the_post_image_temp = $_FILES['image']['tmp_name'];
        $the_post_date = date('Y-m-d');

        move_uploaded_file($the_post_image_temp, "../images/$the_post_image");

        if(empty($the_post_image)){

            $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
            $select_image = mysqli_query($connection,$query);

            while($row = mysqli_fetch_array($select_image)){
                $post_image = $row['post_image'];
            }

        }

        $query = "UPDATE posts SET ";
        $query .= "post_title = (?), ";
        $query .= "post_category_id = (?), ";
        $query .= "post_user = (?), ";
        $query .= "post_status = (?), ";
        $query .= "post_tag = (?), ";
        $query .= "post_content = (?), ";
        $query .= "post_image = (?), ";
        $query .= "post_date = (?) ";
        $query .= "WHERE post_id = (?) ";

        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "sissssssi", $the_post_title, $the_post_category, $the_post_user, $the_post_status, $the_post_tag, $the_post_content, $the_post_image, $the_post_date);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);


		echo "<div class='alert alert-info'>
				<strong>Success!</strong> You have successfully updated one of your posts!.
                <a href='../post.php?p_id={$the_post_id}'>View your post</a>
			  </div>";

    }

?>

   <form action="" method="post" enctype="multipart/form-data">

       <div class="form-group">
            <label for="title">Edit Post Title</label>
            <input value="<?php echo $post_title; ?>" name="title" type="text" class="form-control" placeholder="Some title...">
        </div>

        <div class="form-group">
           <label for="post_category">Edit Post Category</label>
           <br>
            <select name="category" id="" class="form-control">
                <?php
                    $query = "SELECT * FROM categories";
                    $select_categories = mysqli_query($connection,$query);

                    confirm($select_categories);

                    while($row = mysqli_fetch_assoc($select_categories)){
                        $cat_id = $row['category_id'];
                        $cat_title = $row['category_title'];

                        echo "<option value='$cat_id'>{$cat_title}</option>";
                    }
                ?>
            </select>
        </div>

         <div class="form-group">
           <label for="post_category">Users</label>
           <br>
            <select name="post_user" id="" class="form-control">
                
                <?php echo "<option value='{$post_user}'>{$post_user}</option>"; ?>

                <?php
                    $query = "SELECT * FROM users";
                    $select_users = mysqli_query($connection,$query);

                    confirm($select_users);

                    while($row = mysqli_fetch_assoc($select_users)){
                        $user_id = $row['user_id'];
                        $user_name = $row['user_name'];

                        echo "<option value='{$user_name}'>{$user_name}</option>";
                    }
                ?>
            </select>
        </div>


        <div class="form-group">
           <label for="post_status">Edit Post Status</label>
           <select name="post_status" id="" class="form-control">
				<option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>
					<?php
						if($post_status == 'Draft'){
							echo "<option value='Published'>Published</option>";
						}
						else{
							echo "<option value='Draft'>Draft</option>";
						}
					?>
		   </select>
        </div>

        <div class="form-group">
            <label for="post_image">Edit Post Image</label>
            <img width="100" src="../images/<?php echo $post_image; ?>" name="image" alt="">
            <input type="file" name="image" alt="">
        </div>

        <div class="form-group">
            <label for="post_tags">Edit Post Tags</label>
            <input value="<?php echo $post_tag; ?>" type="text" class="form-control" name="tags" placeholder="Add important topics...">
        </div>

        <div class="form-group">
            <label for="post_content">Edit Post Content</label>
            <textarea name="content" id="" cols="30" rows="10" class="form-control" placeholder="Let's hear your side thoughts...">
            <?php echo $post_content; ?>
            </textarea>

        </div>

        <div class="form-group">
            <input type="submit" name="update_post" value="Update Blog" class="btn btn-primary">
        </div>
</form>
