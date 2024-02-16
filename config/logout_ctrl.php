<?php
session_start();

// Unset the authentication session variable
unset($_SESSION['auth']);

// Perform any other logout-related tasks if needed

// Redirect to the home page or login page
header("Location: ../index.php");
exit;
?>
