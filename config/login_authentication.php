<?php

session_start();

if (isset($_POST['btn_login'])) {

    include 'dbcon.php';

    $username = $conn->real_escape_string($_POST['username']); // Sanitize the input.
    $password = $conn->real_escape_string($_POST['password']); // Sanitize the input.

    if (strpos($username, "@staff") !== false) {

        $userSql = "SELECT * FROM `tbl_staff` WHERE Username = '{$username}' AND Password = '{$password}'";
        $result = $conn->query($userSql);

        if ($result->num_rows > 0) {
            // activate auth
            $_SESSION['auth'] = true;


            while ($row = $result->fetch_assoc()) {


                $_SESSION['staffID'] = $row['staffID'];
                $staffID = $row['staffID'];
                $username = $row['Username'];
                $fName = $row['FName'];
                $mName = $row['MName'];
                $lName = $row['LName'];
                $position = $row['Role'];
                $postLocationID = $row['postLocationID'];

                $sqlFetchPostDetails = "SELECT * FROM tbl_postlocations WHERE postLocationID = $postLocationID";
                $result_sqlFetchPostDetails = $conn->query($sqlFetchPostDetails);

                if ($result_sqlFetchPostDetails->num_rows > 0) {


                    $row2 = $result_sqlFetchPostDetails->fetch_assoc();
                    $tbl_postlocation_postLocationID = $row2['postLocationID'];
                    $tbl_postlocation_OtherLocationDetails = $row2['OtherLocationDetails'];
                    $tbl_postlocation_Barangay = $row2['Barangay'];
                    $tbl_postlocation_City = $row2['City'];
                    $tbl_postlocation_Province = $row2['Province'];
                    $tbl_postlocation_postalID = $row2['postalID'];
                    $tbl_postlocation_FullAddress = $row2['OtherLocationDetails'] . ', ' . $row2['Barangay'] . ', ' . $row2['City'] . ', ' . $row2['Province'];
                    $tbl_postlocation_postLocationName = $row2['postLocationName'];
                }
                $_SESSION['auth_user'] = [
                    'staffID' => $staffID,
                    'Fname' => $fName,
                    'Lname' => $lName,
                    'Fullname' => $fName . " " . $mName . " " . $lName,
                    'username' => $username,
                    'position' => $position,
                    'postLocationID' => $tbl_postlocation_postLocationID,
                    'postalID' => $tbl_postlocation_postalID,
                    'OtherLocationDetails' => $tbl_postlocation_OtherLocationDetails,
                    'Barangay' => $tbl_postlocation_Barangay,
                    'postLocationName' => $tbl_postlocation_postLocationName

                ];
                // echo 'success login';
                header("location: ../admin-files/dashboard.php");
            }
        } else {
            // echo 'incorrect login';
            $_SESSION['message'] = 'Incorrect Username or Password.';
            $_SESSION['alert-color'] = 'danger';
            header('location: ../index.php');
        }
    } else {

        $sqlLogin = "select * from tbl_sender where Username = '{$username}' and Password = '{$password}'";
        $result = $conn->query($sqlLogin);

        if ($result->num_rows > 0) {
            $_SESSION['auth'] = true;

            while ($rowLogin = $result->fetch_assoc()) {
                $senderID = $rowLogin['senderID'];
                $username = $rowLogin['Username'];
                $fName = $rowLogin['FName'];
                $mName = $rowLogin['MName'];
                $lName = $rowLogin['LName'];





                $_SESSION['auth_user'] = [
                    'senderID' => $senderID,
                    'Fname' => $fName,
                    'Lname' => $lName,
                    'Fullname' => $fName . " " . $mName . " " . $lName,
                    'username' => $username,
                    'post_location' => $post_location,

                ];
                header('location: ../sender-files/home.php');
            }
        } else {
            $_SESSION['message'] = 'Incorrect Username or Password';
            $_SESSION['alert-color'] = 'danger';
            header('location: ../index.php');
        }
    }
}
// }else {
//     $_SESSION['LoginMSG'] = "Invalid Username or Password";
  
// }

// // Redirect back to the login page
// header('location: ../index.php');