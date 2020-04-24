<?php

    require __DIR__ . '/../../vendor/autoload.php';

    $dotenv = new Dotenv\Dotenv(__DIR__);
    if (file_exists(".env")) {
        $dotenv->load();    
    }
    
    $options = array('cluster' => 'ap1', 'encrypted' => false);

    $pusher = new Pusher\Pusher(getenv('APP_KEY'), getenv('APP_SECRET'), getenv('APP_ID'), $options);

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }

    if(isset($_POST['create_post'])){
        $post_title = escape($_POST['title']);
        $post_category = escape($_POST['category']);
        $post_user = $username;
        $post_status = escape($_POST['status_post']);

        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];

        $post_tags = escape($_POST['post_tags']);
        $post_content = escape($_POST['post_content']);

        $post_date = date('Y-m-d');

        $error = ['post_title' => '', 'post_category_id' => '', 'post_user' => '', 'post_status' => '', 'post_image' => '', 'post_tag' => '', 'post_content' => '', 'post_date' => ''];

        if ($post_title == '') {
            $error['post_title'] = 'You need to put on some title on the post!';
        }if ($post_category == '') {
            $error['post_category_id'] = 'You need to select a category for the post!';
        }if ($post_user == '') {
            $error['post_user'] = 'You need to select a user for the post!';
        }if ($post_status == '') {
            $error['post_status'] = 'You need to select a status for the post!';
        }if ($post_image == '') {
            $error['post_image'] = 'You need to select an image for the post!';
        }if ($post_tags == '') {
            $error['post_tag'] = 'You need to put on some tags on the post!';
        }if ($post_content == '') {
            $error['post_content'] = 'You need to put on some content on the post!';
        }
        //loop
        foreach ($error as $key => $value) {
            if (empty($value)) {
                unset($error[$key]);
            }
        }
        //pusher
        if (empty($error)) {
            add_post($post_title, $post_category, $post_user, $post_status, $post_image, $post_image_temp, $post_tags, $post_content, $post_date);
            $data['message'] = $post_title;
            $pusher->trigger('notifications', 'new_post', $data);
        }

       

		/*echo   "<div class='alert alert-success'>
                    <strong>Success!</strong> You have successfully posted a new blog!.
                    <a href='../post.php?p_id={$the_post_id}'>View Post</a>
                </div>";
*/
    }
?>
   

   <form action="" method="post" enctype="multipart/form-data">
       <div class="form-group">
            <label for="title">Post Title</label>
            <input type="text" class="form-control" name="title" placeholder="Some title...">
        </div>

         <div class="form-group">
           <label for="post_category">Post Category</label>
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
           <label for="post_status">Post Status</label>
           <br>
		   <select name="status_post" id="" class="form-control">
				<?php

					$draft_post = "Draft";
					$published_post = "Published";

					echo "<option value=''>Select Status</option>";
					echo "<option value='$draft_post'>$draft_post</option>";
					echo "<option value='$published_post'>$published_post</option>";

				?>
		   </select>
        </div>

        <div class="form-group">
            <label for="post_image">Post Image</label>
            <input type="file" name="image">
        </div>

        <div class="form-group">
            <label for="post_tags">Post Tags</label>
            <input type="text" class="form-control" name="post_tags" placeholder="Add important topics...">
        </div>

        <div class="form-group">
            <label for="post_content">Post Content</label>
            <textarea name="post_content" id="" cols="30" rows="10" class="form-control" placeholder="Let's hear your side thoughts..."></textarea>
        </div>

        <div class="form-group">
            <input type="submit" name="create_post" value="Publish Blog" class="btn btn-primary">
        </div>
</form>
<!--Push notification-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://js.pusher.com/4.3/pusher.min.js"></script>
        <script>
            $(document).ready(function(){
               var pusher =  new Pusher('c758d2f62f8e37a3b3cf', {
                cluster: 'ap1',
                encrypted: true
               });
               var notificationChannel = pusher.subscribe('notifications');
                    notificationChannel.bind('new_post',function(notification){
                        var message = notification.message;
                    //toaster
                    toastr.success(`${message} has been posted`);
               });
            });
        </script>
