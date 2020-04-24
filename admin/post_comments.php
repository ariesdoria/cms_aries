<?php
    include "includes/admin_header.php";
?>

    <div id="wrapper">
        

        <!--Navigation-->
        <?php 
            include "includes/admin_navigation.php"
        ?>

        <?php
            if(isset($_POST['checkBoxArray'])){
                $checkBox = $_POST['checkBoxArray'];
                foreach ($checkBox as $checkBoxValue) {
                    $bulk_options = $_POST['bulk_options'];

                    switch ($bulk_options) {
                        case 'Approve':
                            $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$checkBoxValue}";
                            $update_to_approve_status = mysqli_query($connection, $query);
                            confirm($update_to_approve_status);
                            break;
                        case 'Unapprove':
                            $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$checkBoxValue}";
                            $update_to_unapprove_status = mysqli_query($connection, $query);
                            confirm($update_to_unapprove_status);
                            break;
                        case 'Unapprove':
                            $query = "DELETE FROM comments WHERE comment_id = {$checkBoxValue}";
                            $delete_comment = mysqli_query($connection, $query);
                            confirm($delete_comment);
                            break;
                    }
                }
            }
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
            <form action="" method="post">
            <table class="table table-bordered table-hover">
                <div class="row">
                    <div id="bulkOptionsContainer" class="col-xs-4">
                        <select name="bulk_options" id="" class="form-control">
                            <option value="">Select Options</option>
                            <option value="Approve">Approve</option>
                            <option value="Unapprove">Unapprove</option>
                            <option value="Delete">Delete</option>
                        </select>
                    </div>
                     <div class="col-xs-4">
                        <input type="submit" name="submit" value="Apply" class="btn btn-success">
                    </div>
                </div>
                <thead>
                    <tr class="bg-info">
                        <th><input id="selectAllBoxes" type="checkbox"></th>
                        <th>Comment Id</th>
                        <th>Author</th>
                        <th>Comments</th>
                         <th>Email</th>
                        <th>Status</th>
                        <th>In Response to</th>
                        <th>Date</th>
                        <th>Approve</th>
                        <th>Unapprove</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                        if (isset($_GET['id'])) {
                            $comment_id = $_GET['id'];
                        
                            $query = "SELECT * FROM comments WHERE comment_post_id = $comment_id ";
                            $select_comments = mysqli_query($connection,$query);

                            while($row = mysqli_fetch_assoc($select_comments)){

                                $comment_id = $row['comment_id'];
                                $comment_post_id = $row['comment_post_id'];
                                $comment_author = $row['comment_author'];
                                $comment_email = $row['comment_email'];
                                $comment_content = $row['comment_content'];
                                $comment_status = $row['comment_status'];
                                $comment_content = $row['comment_content'];
                                $comment_date = $row['comment_date'];

                        echo "<tr>";
                    ?>
                    <td><input type='checkbox' id='selectAllBoxes' name='checkBoxArray[]' class='checkBoxes' value='<?php echo $comment_id;?>'></td>
                    <?php
                        echo "<td>{$comment_id}</td>";
                        echo "<td>{$comment_author}</td>";
                        echo "<td>{$comment_content}</td>";
                        echo "<td>{$comment_email}</td>";
                        echo "<td>{$comment_status}</td>";
                            
                        $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
                        $select_post_id_query = mysqli_query($connection,$query);
                            while($row = mysqli_fetch_assoc($select_post_id_query)){
                                $post_id = $row['post_id'];
                                $post_title = $row['post_title'];

                                echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";
                            }
                            
                        echo "<td>{$comment_date}</td>";
                        echo "<td><a href='comments.php?approve={$comment_id}&id=".$_GET['id']."' class='btn btn-info'>Approve</a></td>";
                        echo "<td><a href='post_comments.php?unapprove={$comment_id}&id=".$_GET['id']."' class='btn btn-warning'>Unapprove</a></td>";
                        echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?');\" href='post_comments.php?delete={$comment_id}&id=".$_GET['id']."' class='btn btn-danger'>Delete</a></td>";
                        echo "</tr>";
                    }
                }
                ?>
                        </tbody>
                        </table>
                        </form>
                       <?php

                            if(isset($_GET['approve'])){

                                if(isset($_SESSION['user_role'])){
                                    if($_SESSION['user_role'] == 'Admin'){
                                        $the_comment_id = escape($_GET['approve']);
                                        $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$the_comment_id} ";
                                        $approve_comment_query = mysqli_query($connection,$query);
                                        header("Location: post_comments.php".$_GET['id']." ");
                                    }
                                }

                               
                            }

                            if(isset($_GET['unapprove'])){

                                if(isset($_SESSION['user_role'])){
                                    if($_SESSION['user_role'] == 'Admin'){
                                        $the_comment_id = escape($_GET['unapprove']);
                                        $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$the_comment_id} ";
                                        $unapprove_comment_query = mysqli_query($connection,$query);
                                        header("Location: post_comments.php?id=".$_GET['id']." ");
                                    }
                                }
                            }

                            if(isset($_GET['delete'])){

                                if(isset($_SESSION['user_role'])){
                                    if($_SESSION['user_role'] == 'Admin'){
                                        $the_comment_id = escape($_GET['delete']);
                                        $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
                                        $delete_query = mysqli_query($connection,$query);
                                        header("Location: post_comments.php?id=".$_GET['id']." ");
                                    }
                                }    
                            }
                        ?>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <?php 
        include "includes/admin_footer.php";
    ?>
