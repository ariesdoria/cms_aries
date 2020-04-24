<?php ob_start(); ?>
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php 

echo loggedInUserId();

if (userLikedThisPost(71)) {
	echo "User liked";
}else{
	echo "Did not";
}

 ?>