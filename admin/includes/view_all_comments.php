            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="bg-info">
                        <th>Comment Id</th>
                        <th>Author</th>
                        <th>Comments</th>
                         <th>Email</th>
                        <th>Status</th>
                        <th>In Response to</th>
                        <th>Date</th>
                        <th>Comment Image</th>
                        <th>Unapprove</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>

                <?php

                    $query = "SELECT * FROM comments";
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
                    $comment_image = $row['comment_image'];


                    echo "<tr>";
                    echo "<td>{$comment_id}</td>";
                    echo "<td>{$comment_author}</td>";
                    echo "<td>{$comment_content}</td>";

                    /*$query = "SELECT * FROM categories WHERE category_id = {$posts_category} ";

                    $select_categories_id = mysqli_query($connection,$query);

                    while($row = mysqli_fetch_assoc($select_categories_id)){
                    $cat_id = $row['category_id'];
                    $cat_title = $row['category_title'];

                    echo "<td>{$cat_title}</td>";

                    }*/

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
                    echo "<td><img width='64' class='img-responsive' src='../images/$comment_image'></td>";
                    echo "<td><a href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
                    echo "<td><a href='comments.php?delete=$comment_id'>Delete</a></td>";
                    echo "</tr>";
                    }
                ?>

                        </tbody>
                        </table>

                       <?php
                            //receive the data when the user clicks the unapprove link
                            if(isset($_GET['unapprove'])){

                                $the_comment_id = escape($_GET['unapprove']);

                                $stmt = mysqli_prepare($connection, "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = ? ");
                                mysqli_stmt_bind_param($stmt, "i", $the_comment_id);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_close($stmt);

                                header("Location: comments.php");
                                    } 
                            //receive the data when the user clicks the delete link
                            if(isset($_GET['delete'])){
                                        $the_comment_id = escape($_GET['delete']);

                                        $stmt = mysqli_prepare($connection, "DELETE FROM comments WHERE comment_id = ? ");
                                        mysqli_stmt_bind_param($stmt, "i", $the_comment_id);
                                        mysqli_stmt_execute($stmt);
                                        mysqli_stmt_close($stmt);
                                        header("Location: comments.php");
                                    }
                        ?>
                        
