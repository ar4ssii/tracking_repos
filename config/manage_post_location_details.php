<?php 
session_start();
include 'dbcon.php';

if(isset($_POST['btn_save_post'])){
    $postLocationName = $_POST['postLocationName'];
    $OtherLocationDetails = $_POST['OtherLocationDetails'];
    $Barangay = $_POST['Barangay'];
    $postLocationID = $_POST['postLocationID'];

    $sql_check = "SELECT * FROM tbl_postlocations WHERE postLocationID = $postLocationID";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        $sql_update = "UPDATE tbl_postlocations SET postLocationName = '$postLocationName',
                                                   OtherLocationDetails = '$OtherLocationDetails', 
                                                   Barangay = '$Barangay'
                                                WHERE postLocationID = $postLocationID";
        $result_update = $conn->query($sql_update);
    
        if ($result_update) {
            $_SESSION['message'] = 'Update of Post Location Details success.';
            $_SESSION['alert-color'] = 'success';
            header('location: ../admin-files/managePostLoc.php');
            
        }

    }
}