<?php

include("delete_modal.php");

if(isset($_POST['checkBoxArray'])){
    $checkBox = $_POST['checkBoxArray'];
  foreach ($checkBox as $checkBoxValue) {
      $bulk_options = escape($_POST['bulk_options']);

      switch($bulk_options){
            case 'Published':
              $stmt = mysqli_prepare($connection, "UPDATE posts SET post_status = (?) WHERE post_id = (?) ");
              mysqli_stmt_bind_param($stmt, "si", $bulk_options, $checkBoxValue);
              mysqli_stmt_execute($stmt);
              mysqli_stmt_close($stmt);

              confirm($update_to_published_status);
            break;

            case 'Clone':
              $query = "SELECT * FROM posts WHERE post_id = '{$checkBoxValue}' ";
              $select_post_query = mysqli_query($connection,$query);
              
              while($row = mysqli_fetch_array($select_post_query)){
                  $post_title = escape($row['post_title']);
                  $post_category_id = escape($row['post_category_id']);
                  $post_date = escape($row['post_date']);
                  $post_author = escape($row['post_author']);
                  $post_user = escape($row['post_user']);
                  $post_status = escape($row['post_status']);
                  $post_image = escape($row['post_image']);
                  $post_tags = escape($row['post_tag']);
                  $post_content = escape($row['post_content']);

                }

                $stmt = mysqli_prepare($connection, "INSERT INTO posts(post_title, post_category_id, post_date, post_author, post_user, post_status, post_image, post_tag, post_content VALUES (?), (?), (?), (?), (?), (?), (?), (?), (?) ");
                mysqli_stmt_bind_param($stmt, "sisssssss", $post_title, $post_category_id, now(), $post_author, $post_user, $post_status, $post_image, $post_tags, $post_content);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
              
              if(!$stmt){
                  die("<div class='alert alert-danger'>
                        <strong>Warning!</strong> Can't clone selected post(s)!
                        </div>".mysqli_error($connection));
              }
              break;

            case 'Draft':

              $stmt = mysqli_prepare($connection, "UPDATE posts SET post_status = (?) WHERE post_id = (?)");
              mysqli_stmt_bind_param($stmt, "si", $bulk_options, $checkBoxValue);
              mysqli_stmt_execute($stmt);
              mysqli_stmt_close($stmt);

              confirm($update_to_draft_status);
            break;

            case 'Reset View':

                  $stmt = mysqli_prepare($connection, "UPDATE posts SET post_views_count = 0 WHERE post_id = (?)");
                  mysqli_stmt_bind_param($stmt, "i", $checkBoxValue);
                  mysqli_stmt_execute($stmt);
                  mysqli_stmt_close($stmt);

                  confirm($reset_query);
            break;

            case 'Delete':

                  $stmt = mysqli_prepare($connection, "DELETE FROM posts WHERE post_id = (?)");
                  mysqli_stmt_bind_param($stmt, "i", $checkBoxValue);
                  mysqli_stmt_execute($stmt);
                  mysqli_stmt_close($stmt);
                  
                  confirm($delete_from_posts);
            break;
        }
      }
}

 ?>
<form action="" method="post">

           <table class="table table-bordered table-hover">
             <div class="row">
             <div id="bulkOptionsContainer" class="col-xs-4">
               <select class="form-control" name="bulk_options" id="">
                 <option value="">Select Options</option>
                 <option value="Published">Publish</option>
                 <option value="Clone">Clone</option>
                 <option value="Draft">Draft</option>
                 <option value="Reset View">Reset View</option>
                 <option value="Delete">Delete</option>
               </select>
             </div>
             <div class="col-xs-4">
               <input type="submit" name="submit" value="Apply" class="btn btn-success">
               <a class="btn btn-primary" href="posts.php?source=add_post">Add New Post</a>
             </div>
           </div>
                <thead>
                    <tr class="bg-info">
                        <th><input id="selectAllBoxes" type="checkbox"></th>
                        <th>Post Id</th>
                        <th>Users</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Tags</th>
                        <th>Comments</th>
                        <th>Date</th>
                        <th>View Post</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Views</th>
                    </tr>
                </thead>
                <tbody>

                <?php

                    //$query = "SELECT * FROM posts ORDER BY post_id DESC";

                    //Join posts table and category table
                    $query = "SELECT posts.post_id, posts.post_author, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, posts.post_tag, posts.post_comment_count, posts.post_date, posts.post_views_count, ";
                    $query .= "categories.category_id, categories.category_title ";
                    $query .= "FROM posts ";
                    $query .= "LEFT JOIN categories ON posts.post_category_id = categories.category_id ORDER BY posts.post_id DESC";
                    

                    $select_posts = mysqli_query($connection,$query);

                    if(!$select_posts){
                      die('Oops! Something went wrong'.mysqli_error($connection));
                    }

                    while($row = mysqli_fetch_assoc($select_posts)){

                    $posts_id = $row['post_id'];
                    $posts_author = $row['post_author'];
                    $posts_user = $row['post_user'];
                    $posts_title = $row['post_title'];
                    $posts_category = $row['post_category_id'];
                    $posts_status = $row['post_status'];
                    $posts_image = $row['post_image'];
                    $posts_tag = $row['post_tag'];
                    $posts_comments = $row['post_comment_count'];
                    $posts_date = $row['post_date'];
                    $post_views = $row['post_views_count'];
                    $cat_title = $row['category_title'];
                    $cat_id = $row['category_id']; 

                    echo "<tr>";
                ?>

                    <td><input type='checkbox' id='selectAllBoxes' name='checkBoxArray[]' class='checkBoxes' value='<?php echo $posts_id ?>'></td>
                
                <?php
                    echo "<td>{$posts_id}</td>";

                    if(isset($post_author) || !empty($post_author)){
                       echo "<td>{$posts_author}</td>";
                    }elseif(isset($posts_user) || !empty($posts_user)){
                       echo "<td>{$posts_user}</td>";
                    }

                    echo "<td>{$posts_title}</td>";

                   /* $query = "SELECT * FROM categories WHERE category_id = {$posts_category} ";

                    $select_categories_id = mysqli_query($connection,$query);

                    while($row = mysqli_fetch_assoc($select_categories_id)){
                    $cat_id = $row['category_id'];
                    $cat_title = $row['category_title'];*/

                    echo "<td>{$cat_title}</td>";
                    //}
                    echo "<td>{$posts_status}</td>";
                    echo "<td><img width='100' class='img-responsive' src='../images/$posts_image'></td>";
                    echo "<td>{$posts_tag}</td>";
                        
                    $query = "SELECT * FROM comments WHERE comment_post_id = $posts_id";    
                    $send_comment_query = mysqli_query($connection, $query);
                    
                    $row = mysqli_fetch_array($send_comment_query);
                    $comment_id = $row['comment_id'];
                        
                    $count_comments = mysqli_num_rows($send_comment_query);
                        
                    echo "<td><a href='post_comments.php?id=$posts_id'>{$count_comments}</a></td>";    
                    echo "<td>{$posts_date}</td>";
                    echo "<td><a href='../post.php?p_id={$posts_id}'>View Post</a></td>";
                    echo "<td><a href='posts.php?source=edit_post&p_id={$posts_id}'>Edit</a></td>";
                    echo "<td><a rel='$posts_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
                    //echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='posts.php?delete={$posts_id}'>Delete</a></td>";
                    echo "<td><a href='posts.php?reset={$posts_id}'>{$post_views}</a></td>";
                    echo "</tr>";
                    }
                ?>

                        </tbody>
                      </table>
                    </form>
                       <?php

                            //Needs code fix      
                            if(isset($_GET['delete'])){
                              if(isset($_SESSION['role']) && ($_SESSION['role']) == 'Admin'){
                                  $the_post_id = escape($_GET['delete']);

                                  $stmt = mysqli_prepare($connection, "DELETE FROM posts WHERE post_id = (?)");
                                  mysqli_stmt_bind_param($stmt, "i", $the_post_id);
                                  mysqli_stmt_execute($stmt);
                                  mysqli_stmt_close($stmt);
                                  header("Location: posts.php");
                                }
                              }
                              
                            if(isset($_GET['reset'])){
                              if(isset($_SESSION['role']) && ($_SESSION['role']) == 'Admin'){
                                    $the_post_id = escape($_GET['reset']);

                                    $stmt = mysqli_prepare($connection, "UPDATE posts SET post_views_count = 0 WHERE post_id = (?)");
                                    mysqli_stmt_bind_param($stmt, "i", $the_post_id);
                                    mysqli_stmt_execute($stmt);
                                    mysqli_stmt_close($stmt);
                                    header("Location: posts.php");
                                  }
                                }
                        ?>
              <script>
              $(document).ready(function(){
                $(".delete_link").on('click', function(){
                  var id = $(this).attr("rel");
                  var delete_url = "posts.php?delete="+ id +"";
                  $(".modal_delete_link").attr("href", delete_url);
                  $("#myModal").modal('show');  
                });
              });
              </script>
