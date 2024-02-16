<?php
session_start();
include 'dbcon.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array();

// Retrieve the selected postal ID from the GET parameters
if (isset($_GET['postalID'])) {
    $selectedPostalID = $_GET['postalID'];

    // Fetch drop-off points based on the selected postal ID (replace with your SQL query)
    $sql_fetchDropOffPoints = "SELECT *
                                FROM tbl_postal_codes
                                LEFT JOIN tbl_postlocations ON tbl_postal_codes.postalID = tbl_postlocations.postalID
                                WHERE tbl_postlocations.postalID = $selectedPostalID";
    $result_fetchDropOffPoints = $conn->query($sql_fetchDropOffPoints);

    if ($result_fetchDropOffPoints->num_rows > 0) {
        // Display drop-off points
        $row = $result_fetchDropOffPoints->fetch_assoc();
        $response['nearest_dropoff_point'] = $row['OtherLocationDetails'] . ', ' . $row['Barangay'] . ', ' . $row['City'] . ', ' . $row['Province'];
    } else {
        // No drop-off points found
        $response['error'] = 'No drop-off points available for the selected location';
    }
} else {
    // No postal ID provided
    $response['error'] = "Invalid request. Postal ID is missing.";
}

// Close the database connection
$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
