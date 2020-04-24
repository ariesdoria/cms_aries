<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>

    <?php
        //Need to modify SMTP
        if(isset($_POST['sendmail'])){
            $recipient = mysqli_real_escape_string($connection, $_POST['email']);
            $subject = mysqli_real_escape_string($connection, $_POST['subject']);
            $message = mysqli_real_escape_string($connection, $_POST['message']);

            if(mail($recipient, $subject, $message)){
                echo "<div class='alert alert-success'>
                        <strong>Success!</strong> You have successfully send an email.
                      </div>";
            }
            else{
                echo "<div class='alert alert-danger'>
                        <strong>Sorry,</strong> You haven't send the email yet. Please try again.
                      </div>"; 
            }
        }
    ?>
    
    

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact</h1>
                    <form role="form" action="" enctype="multipart/form-data" method="post" id="login-form" autocomplete="off">
                       <h6></h6>
                       <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label for="username" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Subject">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Content</label>
                            <textarea name="message" id="body" cols="50" rows="10" class='form-control' placeholder="What'on your mind?"></textarea>
                        </div>
                        <input type="submit" name="sendmail" id="btn-login" class="btn btn-success btn-lg btn-block" value="Send Email">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
