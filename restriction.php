<?php
if (!isset($_SESSION['auth'])) {
    $_SESSION['message'] = 'Error: You are not logged in.';
    $_SESSION['alert-color'] = 'danger';
    header('location: index.php');
}
?>