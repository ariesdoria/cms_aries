            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="bg-info">
                        <th>User Id</th>
                        <th>Username</th>
                        <th>Firstname</th>
                         <th>Lastname</th>
                        <th>Email</th>
                        <th>Image</th>
                        <th>Role</th>
                        <th>Change to Admin</th>
                        <th>Change to Subscriber</th>
                        <th>Edit User</th>
                        <th>Delete User</th>
                    </tr>
                </thead>
                <tbody>

                <?php

                    $query = "SELECT * FROM users";
                    $select_users = mysqli_query($connection,$query);

                    while($row = mysqli_fetch_assoc($select_users)){

                    $user_id = $row['user_id'];
                    $user_name = $row['user_name'];
                    $user_firstname = $row['user_firstname'];
                    $user_lastname = $row['user_lastname'];
                    $user_email = $row['user_email'];
                    $user_image = $row['user_image'];
                    $user_role = $row['user_role'];

                    echo "<tr>";
                    echo "<td>{$user_id}</td>";
                    echo "<td>{$user_name}</td>";
                    echo "<td>{$user_firstname}</td>";
                    
                    /*$query = "SELECT * FROM categories WHERE category_id = {$posts_category} ";
                        
                    $select_categories_id = mysqli_query($connection,$query);

                    while($row = mysqli_fetch_assoc($select_categories_id)){
                    $cat_id = $row['category_id'];
                    $cat_title = $row['category_title'];    
                        
                    echo "<td>{$cat_title}</td>";
                        
                    }*/
                        
                    echo "<td>{$user_lastname}</td>";
                    echo "<td>{$user_email}</td>";
                    echo "<td><img width='64' class='img-responsive' src='../images/$user_image'></td>";
                    echo "<td>{$user_role}</td>";
                        
                    /*$query = "SELECT * FROM users WHERE post_id = $comment_post_id ";    
                    $select_post_id_query = mysqli_query($connection,$query);
                        while($row = mysqli_fetch_assoc($select_post_id_query)){
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            
                            echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";
                        }
                    echo "<td>{$comment_date}</td>";*/
                    echo "<td><a href='users.php?make_admin={$user_id}'>Make Admin</a></td>";
                    echo "<td><a href='users.php?make_subscriber={$user_id}'>Make Subscriber</a></td>";
                    echo "<td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";
                    echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
                    echo "</tr>";
                    }
                ?>
                               
                        </tbody>
                        </table>
                        
                       <?php

                            if(isset($_GET['make_admin'])){
                                        $user_id = escape($_GET['make_admin']);

                                        $stmt = mysqli_prepare($connection, "UPDATE users SET user_role = 'Admin' WHERE user_id = (?)");
                                        mysqli_stmt_bind_param($stmt, "i", $user_id);
                                        mysqli_stmt_execute($stmt);
                                        mysqli_stmt_close($stmt);

                                        header("Location: users.php");
                                    }

                            if(isset($_GET['make_subscriber'])){
                                        $user_id = escape($_GET['make_subscriber']);

                                        $stmt = mysqli_prepare($connection, "UPDATE users SET user_role = 'Subscriber' WHERE user_id = (?)");
                                        mysqli_stmt_bind_param($stmt, "i", $user_id);
                                        mysqli_stmt_execute($stmt);
                                        mysqli_stmt_close($stmt);

                                        header("Location: users.php");
                                    }

                            if(isset($_GET['delete'])){
                                        $user_id = escape($_GET['delete']);

                                        $stmt = mysqli_prepare($connection, "DELETE FROM users WHERE user_id = (?)");
                                        mysqli_stmt_bind_param($stmt, "i", $user_id);
                                        mysqli_stmt_execute($stmt);
                                        mysqli_stmt_close($stmt);

                                        header("Location: users.php");
                                    }
                        ?>