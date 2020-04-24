<?php
    include "includes/admin_header.php";
?>

    <div id="wrapper">
        

        <!--Navigation-->
        <?php 
            include "includes/admin_navigation.php"
        ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                       
                        <h1 class="page-header">
                            Welcome to Admin
                            <small>Author</small>
                        </h1>
                        
                        <div class="col-xs-6">
                        
                        <!--Add category-->
                        <form action="" method="post">
                            <div class="form-group">
                               <label for="cat_title">Add Category</label>
                                <input type="text" name="category_title" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" value="Add Category" class="btn btn-primary">
                            </div>
                        </form><!--Add category-->
                        <!--Add category function-->
                        <?php insert_categories();?>
                        <!--Add category function-->
                        
                        <!--Update Categories-->                
                        <?php
                            
                            if(isset($_GET['edit'])){
                                $cat_id = $_GET['edit'];
                                include "includes/update_categories.php";    
                            }
                            
                        ?><!--Update Categories-->
                        
                        </div>
                        
                        <div class="col-xs-6">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="bg-info">
                                        <th>ID</th>
                                        <th>Category Title</th>
                                        <th>Delete</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php   //Find all categories query
                                        findAllCategories();
                                    ?>
                                    
                                    <?php  //delete query
                                        delete_categories();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <?php 
        include "includes/admin_footer.php";
    ?>