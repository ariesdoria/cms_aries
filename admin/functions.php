<?php    
//show the users that are online 
function users_online(){
    
    if(isset($_GET['onlineusers'])){
    
    global $connection;
        
        if(!$connection){
            session_start();
            
            include("../includes/db.php");
            
            $session = session_id();
            $time = time();
            $time_out_in_secs = 05;
            $time_out = $time - $time_out_in_secs;

            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);

            if($count == NULL){
            mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session','$time')");
            }else{
            mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
            }
            //display other online users who is not logged out
            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
            echo $count_user = mysqli_num_rows($users_online_query);    
        }
    }//get request isset()
}
users_online();

//Confirm the database query result
function confirm($result){
    
    global $connection;
    
    if(!$result){
            die('Query failed' . mysqli_error($connection));
        }
}

//Add Categories in the CMS Admin
function insert_categories()
{
    
    global $connection;
    
    if(isset($_POST['submit'])){
   $category_title = $_POST['category_title'];

    if($category_title == "" || empty($category_title)){
        echo "<div class='alert alert-danger'>
                <strong>Warning!</strong> Add Category field should not be empty!
              </div>";
    }
    else{
        $query = "INSERT INTO categories(category_title) ";
        $query .= "VALUES('{$category_title}') ";

            $create_category_query = mysqli_query($connection,$query);

            if(!$create_category_query){
                die('Query Failed'.mysqli_error($connection));
            }
            else{
                echo "<div class='alert alert-success'>
                        <strong>Success!</strong> You have successfully added a new category!
                      </div>";
            }
        }
    }           
}

//Display All Categories
function findAllCategories(){
    
    global $connection;
    
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection,$query);

    while($row = mysqli_fetch_assoc($select_categories)){
        $cat_id = $row['category_id'];
        $cat_title = $row['category_title'];

        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "<tr>";
        }
}

//delete categories
function delete_categories(){
    
    global $connection;
    
    if(isset($_GET['delete'])){
    $the_cat_id = $_GET['delete'];
    $query = "DELETE FROM categories WHERE category_id = {$the_cat_id} ";
    $delete_query = mysqli_query($connection,$query);
    }
}
//Display the username of the user in the admin page
function welcome_user(){
    
    global $connection;
    
    echo $_SESSION['username'];
}
//Trim the database connection queries
function escape($string){
    
    global $connection;

    return mysqli_real_escape_string($connection, trim($string));
}

//Code for counting records in tables
function recordCount($tablename){

    global $connection;

    $query = "SELECT * FROM ".$tablename;
    $select_all_active_posts = mysqli_query($connection, $query);
    $result = mysqli_num_rows($select_all_active_posts);

    confirm($result);

    return $result;
}

//Check the column status to display in the graph
function checkColumnStatus($table, $column, $status){

    global $connection;

    $query = "SELECT * FROM $table WHERE $column = '$status' ";
    $result = mysqli_query($connection, $query);
    
    return mysqli_num_rows($result);

}

//Check the table status to display in the graph
function checkAllStatus($table){

    global $connection;

    $query = "SELECT * FROM $table";
    $result = mysqli_query($connection, $query);

    return mysqli_num_rows($result);
}



//check to see if whether the user that is currently logged in is an Admin
function is_admin($username){
    global $connection;

    $query = "SELECT user_role FROM users WHERE user_name = '{$username}'";
    $result = mysqli_query($connection, $query);

    $row = mysqli_fetch_array($result);

    if(($row['user_role'] == 'Admin') || ($row['user_role' == 'admin'])){
        return true;
    }else{
        return false;
    }
}

//check to see if the given username exists in the database while registering a new user
function username_exists($username){
    global $connection;

    $query = "SELECT user_name FROM users WHERE user_name = '{$username}'";
    $result = mysqli_query($connection, $query);
    confirm($result);

    //if the username column name already has a value that is given by the user when registering
    if (mysqli_num_rows($result) > 0) {
        return true;
    }else{
        return false;
    }
}

//check to see if the given email exists in the database while registering a new user
function user_email_exists($email){
    global $connection;

    $query = "SELECT user_email FROM users WHERE user_email = '{$email}'";
    $result = mysqli_query($connection, $query);
    confirm($result);

    //if the user_email column name already has a value that is given by the user when registering
    if (mysqli_num_rows($result) > 0) {
        return true;
    }else{
        return false;
    }
}

//redirect location
function redirect($location){
    
    global $connection;

     header("Location: " . $location);
     exit;
}

//register a new user
function register_user($username, $email, $password){
    global $connection;

    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

    $query = "INSERT INTO users(user_name, user_email, user_password, user_role) ";
    $query .= "VALUES('{$username}', '{$email}', '{$password}', 'Subscriber') ";
    $register_query = mysqli_query($connection, $query);

    confirm($register_query);
}

//login user function
function login_user($username, $password){
    global $connection;

    $username = mysqli_real_escape_string($connection, trim($_POST["username"]));
    $password = mysqli_real_escape_string($connection, trim($_POST["password"]));

    $query = "SELECT * FROM users WHERE user_name = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);

    if (!$select_user_query) {
        die('Query failed'.mysqli_error($connection));
    }while ($row = mysqli_fetch_array($select_user_query)) {
        $db_user_id = $row['user_id'];
        $db_username = $row['user_name'];
        $db_password = $row['user_password'];
        $db_user_fname = $row['user_firstname'];
        $db_user_lname = $row['user_lastname'];
        $db_user_role = $row['user_role'];

         //check if the user credentials is the same in the database
        if (password_verify($password, $db_password)) {
            
            $_SESSION['username'] = $db_username;
            $_SESSION['firstname'] = $db_user_fname;
            $_SESSION['lastname'] = $db_user_lname;
            $_SESSION['role'] = $db_user_role;

            //if the user is new redirect to admin page
            redirect("/cms_aries/admin");
        }else{
            //if the user is old redirect to index
            return false;
        }
    }
    return true;
}

//check for form method i.e for POST and GET 
function ifItIsMethod($method=null){
    if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        return true;
    }
    return false;
}

//if the user is logged in
function isLoggedIn(){
    if (isset($_SESSION['user_role'])) {
        return true;
    }
    return false;
}

//check if the user is logged in after that redirect to a location
function checkIfUserIsLoggedInAndRedirect($redirectLocation = null){
    if(isLoggedIn()){
        redirect($redirectLocation);
    }
}

//check if the user is the current user
function currentUser(){
    if (isset($_SESSION['username'])) {
        return $_SESSION['username'];
    }
    return false;
}

//display a default image on a post when a user did not add an image while adding a post
function imagePlaceHolder($image = null){
    if(!$image){
        return 'Desert.jpg';
    }else{
        return $image;
    }
}

//If the user's id is logged in 
function loggedInUserId(){
    if (isLoggedIn()) {
        $result = query("SELECT * FROM users WHERE user_name = '".$_SESSION['username']."' ");
        confirm($result);
        $user = mysqli_fetch_array($result);
        //check if there is an existing user
        return mysqli_num_rows($result) >= 1 ? $user['user_id'] : false;
    }
    return false;
}

//Post likes
function userLikedThisPost($post_id = ''){
    $result = query("SELECT * FROM likes WHERE user_id = '.loggedInUserId().' AND post_id = {$post_id} ");
    return mysqli_num_rows($result) >= 1 ? true : false;
}

//Connection to database
function query($query){
    global $connection;
    return mysqli_query($connection, $query);
}

//get post likes
function getPostLikes($post_id){
    $result = query("SELECT * FROM likes WHERE post_id = $post_id");
    confirm($result);
    echo mysqli_num_rows($result);
}

//add a new user in the database in admin page
function add_user($user_fname, $user_lname, $user_email, $user_image, $user_temp_image, $user_role, $user_name, $user_password){

    global $connection;

    copy($user_temp_image, "../images/$user_image");

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

    $query = "INSERT INTO users(user_firstname, user_lastname, user_email, user_image, user_role, user_name, user_password) ";
    $query .= "VALUES(?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "sssssss", $user_fname, $user_lname, $user_email, $user_image, $user_role, $user_name, $user_password);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt); 
}

//add a new post in the database in admin page
function add_post($post_title, $post_category, $post_user, $post_status, $post_image, $post_image_temp, $post_tags, $post_content, $post_date){

    global $connection;

    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "INSERT INTO posts(post_title, post_category_id, post_user, post_status, post_image, post_tag, post_content, post_date) ";
    $query .= "VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "sissssss", $post_title, $post_category, $post_user, $post_status, $post_image, $post_tags, $post_content, $post_date);
    mysqli_stmt_execute($stmt);
    $the_post_id = mysqli_insert_id($connection);
    mysqli_stmt_close($stmt);

}

//Add blog comments
function blog_add_comments($the_post_id, $comment_author, $comment_email, $comment_content, $comment_status, $comment_date, $comment_image){

    global $connection;

    $stmt = mysqli_prepare($connection, "INSERT INTO comments(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date, comment_image) VALUES (?), (?), (?), (?), (?), (?), (?)");
    mysqli_stmt_bind_param($stmt, "issssss", $the_post_id, $comment_author, $comment_email, $comment_content, $comment_status, $comment_date, $comment_image);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    confirm($stmt);
}

//Display all posted comments
function postedComments($the_post_id){
    global $connection;

    $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} ";
    $query .= "AND comment_status = 'approved' ";
    $query .= "ORDER BY comment_id DESC ";

    return $select_comment_query = mysqli_query($connection,$query);
}

//Edit the users in the admin page
function editUsers($user_firstname, $user_lastname, $user_email, $user_image, $user_temp_image, $user_role, $user_password, $user_id){
    
    global $connection;

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

    $query = "UPDATE users SET user_firstname = (?), user_lastname = (?), user_email = (?), user_image = (?), user_role = (?), user_password = (?) ";
    $query .= "WHERE user_id = (?)";

    $stmt = mysqli_prepare($connection,$query);
    mysqli_stmt_bind_param($stmt, "ssssssi", $user_firstname, $user_lastname, $user_email, $user_image, $user_role, $user_password, $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

}

?>