<!-- start output buffering -->
<?php ob_start();?>
<!-- start session -->
<?php
    session_start();
?>
<!-- Set session values to null -->
<?php

$_SESSION['username'] = null;
$_SESSION['firstname'] = null;
$_SESSION['lastname'] = null;
$_SESSION['role'] = null;

// Redirect the user to logout.php once logged out 
header("Location: ../logout.php");

?>