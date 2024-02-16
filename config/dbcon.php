<?php
$servername="localhost";
$username="root";
$password="";
$dbname="tracking";

//create a db connection
$conn =new mysqli($servername, $username, $password, $dbname);

//test the db connection
if ($conn->connect_error){
    die("connection failed : ".$conn->connect_error);
}else{
     echo""; 	
}

?>