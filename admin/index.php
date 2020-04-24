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
                            Welcome to CMS Admin
                            <small>
                              <?php
                                    echo $_SESSION['username'];
                                ?>
                            </small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
				
				<!--Admin widgets-->
				
				<!-- /.row -->
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

							<div class='huge'><?php echo $post_count = recordCount('posts'); ?></div>
					
                        <div>Total Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
							<div class='huge'><?php echo $comment_count = recordCount('comments');?></div>
                      <div>Total Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">						
						<div class='huge'><?php echo $user_count = recordCount('users');?></div>
                        <div>Total Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

						<div class='huge'><?php echo $category_count = recordCount('categories');?></div>

                         <div>Total Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <!--Add Users Online Function-->
</div>
                <!-- /.row -->
				<!--/Admin widgets-->
				<br>
				<br>
				<br>
				<!--Read data from the database to display in chart-->
					<?php
						//Call the functions on column and table status
						$post_count = checkAllStatus('posts');
						
						$post_active_count = checkColumnStatus('posts','post_status','Published');
							
						$post_draft_count = checkColumnStatus('posts', 'post_status', 'Draft');

						$comment_count = checkAllStatus('comments');

						$pending_comments = checkColumnStatus('comments', 'comment_status', 'Approved');

						$approved_comments = checkColumnStatus('comments','comment_status','Unapproved');

						$user_count = checkAllStatus('users');
							
						$subscriber_role = checkColumnStatus('users','user_role','subscribers');

						$category_count = checkAllStatus('categories');
					?>
				<div class="row">
					 <script type="text/javascript">
					  google.charts.load('current', {'packages':['bar']});
					  google.charts.setOnLoadCallback(drawChart);

					  function drawChart() {
						var data = google.visualization.arrayToDataTable([
						  ['Data','Total Data'],
						  //Displaying data from the database using chart
							  <?php
								$element_text = ['All Posts', 'Active Posts', 'Draft Posts', 'Comments', 'Pending Comments', 'Approved Comments', 'Users', 'Subscribers', 'Categories'];
								$element_count = [$post_count, $post_active_count, $post_draft_count, $comment_count, $pending_comments, $approved_comments, $user_count, $subscriber_role, $category_count];
								
								
									for($i = 0; $i < 7; $i++){
										echo "['{$element_text[$i]}'" . ",". "{$element_count[$i]}],";
									}
							  ?>
						]);

						var options = {
						  chart: {
							title: '',
							subtitle: '',
						  }
						};

						var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

						chart.draw(data, google.charts.Bar.convertOptions(options));
					  }
					</script>
				<div id="columnchart_material" style="width: 'auto'; height: 500px; margin-left: 100px"></div>
				</div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <?php 
        include "includes/admin_footer.php";
    ?>
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
                    notificationChannel.bind('new_user',function(notification){
                    var message = notification.message;
                    //toaster
                    toastr.success(`${message} has been registered to the system`);
               });
            });
        </script>

