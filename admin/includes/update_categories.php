<?php //Select Category query
    if(isset($_GET['edit'])){
        $cat_id = $_GET['edit'];
        $query = "SELECT * FROM categories WHERE category_id = {$cat_id} ";
        $select_categories_id = mysqli_query($connection,$query);

        while($row = mysqli_fetch_assoc($select_categories_id)){
            $cat_id = $row['category_id'];
            $cat_title = $row['category_title'];
        ?>
        <label for="category">Category Name:</label>
        <input value="
        <?php if(isset($cat_title)){
            echo $cat_title;
            }
        ?>" class="form-control" type="text" name="cat_title">

    <?php 
        }
            } 
    ?>

<?php //Update Category query
        if(isset($_POST['update_category'])){
            $edit_cat_title = escape($_POST['category_title']);
            $update_query = "UPDATE categories SET category_title = '{$edit_cat_title}' ";
            $update_query .= "WHERE category_id = {$cat_id} ";

            $edit_query = mysqli_query($connection,$update_query);

            if(!$update_query){
                die("Update query failed".mysqli_error($connection));
            }
        }
?>
<br>
 <form action="" method="post"><!--Edit Category-->
    <div class="form-group">
       <label for="cat_title">Edit Category</label>
        <input type="text" name="category_title" class="form-control">
    </div>
    <div class="form-group">
        <input type="submit" name="update_category" value="Update Category" class="btn btn-primary">
    </div>
</form><!--Edit Category Form-->