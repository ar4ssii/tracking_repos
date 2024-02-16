<?php 
session_start();
include '../dbcon.php';

if(isset($_GET['approval_search']) || isset($_GET['btn_approval_search'])){
    $postLocationID = $_SESSION['auth_user']['postLocationID'];
    $searchTerm = $_GET['approval_search'];

    // Adjust the SQL statement for search
    $sql_search = "SELECT DISTINCT
                        tbl_deliver.deliverID,
                        tbl_deliver.transactionNumber,
                        tbl_deliver.BookedDate,
                        tbl_deliver.EstimatedDeliveryDate,
                        tbl_deliver.ItemName,
                        tbl_deliver.ItemSize,
                        tbl_deliver.ItemValue,
                        tbl_deliver.PaymentType,
                        tbl_deliver.PaymentStatus,
                        tbl_deliver.ItemFragile,
                        tbl_sender.FName AS senderFName,
                        tbl_sender.MName AS senderMName,
                        tbl_sender.LName AS senderLName,
                        tbl_sender.postalID AS senderPostalID,
                        tbl_sender.Street AS senderStreet,
                        tbl_sender.Barangay AS senderBarangay,
                        tbl_postal_codes_sender.City AS senderCity,
                        tbl_postal_codes_sender.Province AS senderProvince,
                        tbl_sender.ContactNumber AS senderContactNumber,
                        tbl_recipient.postalID AS recipientPostalID,
                        tbl_recipient.Street AS recipientStreet,
                        tbl_recipient.Barangay AS recipientBarangay,
                        tbl_postal_codes_recipient.City AS recipientCity,
                        tbl_postal_codes_recipient.Province AS recipientProvince,
                        tbl_recipient.ContactNumber AS recipientContactNumber
                    FROM
                        tbl_deliver
                    LEFT JOIN
                        tbl_recipient ON tbl_deliver.recipientID = tbl_recipient.recipientID
                    LEFT JOIN
                        tbl_sender ON tbl_deliver.senderID = tbl_sender.senderID
                    LEFT JOIN
                        tbl_postal_codes AS tbl_postal_codes_sender ON tbl_sender.postalID = tbl_postal_codes_sender.postalID
                    LEFT JOIN
                        tbl_postal_codes AS tbl_postal_codes_recipient ON tbl_recipient.postalID = tbl_postal_codes_recipient.postalID
                    INNER JOIN
                        tbl_staff ON tbl_staff.postLocationID = tbl_sender.postalID
                    WHERE
                        (tbl_sender.postalID = $postLocationID AND tbl_deliver.DeliveryStatus = 'PENDING') AND
                        (
                            tbl_deliver.transactionNumber LIKE '%$searchTerm%' OR
                            tbl_sender.FName LIKE '%$searchTerm%' OR
                            tbl_sender.LName LIKE '%$searchTerm%' OR
                            tbl_sender.ContactNumber LIKE '%$searchTerm%' OR
                            tbl_recipient.Street LIKE '%$searchTerm%' OR
                            tbl_recipient.Barangay LIKE '%$searchTerm%' OR
                            tbl_recipient.ContactNumber LIKE '%$searchTerm%'
                        )
                    ORDER BY tbl_deliver.BookedDate DESC";

    $result_search = $conn->query($sql_search);

    // Redirect to forApproval.php with search results as URL parameters
    header("Location: ../../admin-files/forApproval.php?approval_search_result=".urlencode(json_encode($result_search->fetch_all(MYSQLI_ASSOC))));
    exit();
}
?>
