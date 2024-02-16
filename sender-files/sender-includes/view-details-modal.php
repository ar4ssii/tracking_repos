<!-- Modal  -->
<div class="modal fade text-start" id="ViewDetailsModal_<?= $row['deliverID'] ?>" tabindex="-1" aria-labelledby="ViewDetailsModal_Label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ViewDetailsModal_Label">View details of <?= $row['transactionNumber'] ?></h5>
            </div>

            <?php
            $SenderFullName = $row['senderFName'] . ' ' . $row['senderMName'] . ' ' . $row['senderLName'];
            $RecipientFullName = $row['recipientFName'] . ' ' . $row['recipientMName'] . ' ' . $row['recipientLName'];

            // $fromPostLocationID = $row['fromPostLocationID'];
            // $sql_fetchPostLocation = "SELECT * FROM tbl_postlocations WHERE postLocationID = $fromPostLocationID";
            // $result_fetchPostLocation = $conn->query($sql_fetchPostLocation);
            // while ($fetch = $result_fetchPostLocation->fetch_assoc()) { 
            ?>

            <div class="modal-body text-center">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="2" class="text-start fw-bold bg-secondary text-white">Package Information</td>
                            </tr>
                            <tr>
                                <td class="text-end">Package Status</td>
                                <td><?= $row['DeliveryStatus'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Item size</td>
                                <td><?php
                                    $itemSize;
                                    if ($row['ItemSize'] == '80') {
                                        $itemSize = 'Small';
                                    } else if ($row['ItemSize'] == '100') {
                                        $itemSize = 'Medium';
                                    } else if ($row['ItemSize'] == '120') {
                                        $itemSize = 'Large';
                                    } else if ($row['ItemSize'] == '200') {
                                        $itemSize = 'Box';
                                    }
                                    echo $itemSize;

                                    ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Item Fragile?</td>
                                <td><?= ($row['ItemFragile'] == '1') ? 'Yes' : 'No' ?>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-start fw-bold bg-secondary text-white">Sender Information</td>
                            </tr>
                            <tr>
                                <td class="text-end">Sender Name</td>
                                <td><?= $SenderFullName ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Sender Contact Information</td>
                                <td><?= $row['senderContactNumber'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Sender's Delivery Address</td>
                                <?php
                                $senderPostalID = $row['senderPostalID'];
                                $sql_fetchPostal = "SELECT * FROM tbl_postal_codes WHERE postalID = $senderPostalID";
                                $result_fetchPostal = $conn->query($sql_fetchPostal);

                                if ($result_fetchPostal->num_rows > 0) {
                                    while ($fetch = $result_fetchPostal->fetch_assoc()) {

                                ?>
                                        <td><?= $row['senderOtherLocationDetails'] . ', ' . $row['senderStreet'] . ', ' . $row['senderBarangay'] . ', ' . $fetch['City'] . ', ' . $fetch['Province'] ?>
                                    <?php }
                                } ?>

                            </tr>
                            <tr>
                                <td colspan="2" class="text-start fw-bold bg-secondary text-white">Recipient Information</td>
                            </tr>
                            <tr>
                                <td class="text-end">Recipient's Name</td>
                                <td><?= $RecipientFullName ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end">Recipient's Contact Information</td>
                                <td><?= $row['recipientContactNumber'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Recipient's Delivery Address</td>
                                <?php
                                $recipientPostalID = $row['recipientPostalID'];
                                $sql_fetchPostal = "SELECT * FROM tbl_postal_codes WHERE postalID = $recipientPostalID";
                                $result_fetchPostal = $conn->query($sql_fetchPostal);

                                if ($result_fetchPostal->num_rows > 0) {
                                    while ($fetch = $result_fetchPostal->fetch_assoc()) {

                                ?>
                                        <td><?= $row['recipientOtherLocationDetails'] . ', ' . $row['recipientStreet'] . ', ' . $row['recipientBarangay'] . ', ' . $fetch['City'] . ', ' . $fetch['Province'] ?> </td>
                                <?php }
                                } ?>

                            </tr>
                            <tr>
                                <td colspan="2" class="text-start fw-bold bg-secondary text-white">Item Information</td>
                            </tr>
                            <tr>
                                <td class="text-end">Item Name</td>
                                <td><?= $row['ItemName'] ?></td>
                            </tr>


                            <tr>
                                <td colspan="2" class="text-start fw-bold bg-secondary text-white">Fees and Breakdown</td>
                            </tr>
                            <tr>
                                <td class="text-end">Item Value</td>
                                <td><?= $row['ItemValue'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Service Fee</td>
                                <td><?php
                                    echo $row['ItemSize'];
                                    echo ($row['sender_payServiceFee'] == '1') ? ' (PAID)' : '';
                                    ?></td>
                            </tr>

                            <tr class=" fw-bold">
                                <td class="text-end">Total Amount</td>
                                <td>
                                    <?php
                                    // Check if sender_payServiceFee is 1, then set Total Amount to ItemValue
                                    if ($row['sender_payServiceFee'] == '1') {
                                        echo $row['ItemValue'];
                                    } else {
                                        // Calculate Total Amount as the sum of ItemValue and ItemSize
                                        $totalAmount = $row['ItemValue'] + $row['ItemSize'];
                                        echo $totalAmount;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end">Payment Type</td>
                                <td><?= ($row['PaymentType'] == '1') ? 'Cash on Delivery' : '' ?></td>
                            </tr>

                            <tr>
                                <td class="text-end">Payment Status</td>
                                <td><?= $row['PaymentStatus'] ?>

                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-12 border-top py-2">
                <div class="col px-3 text-center">
                    <?php
                    $footerMessage;
                    if ($row['DeliveryStatus'] == "PENDING") {
                        $footerMessage = 'Your booking status is waiting to be approved.';
                    } else if ($row['DeliveryStatus'] == "BOOKED") {
                        $footerMessage = 'Your booking status is now approved. You can now drop your product/item at your nearest drop-off point ' . $row['postLocOtherLocationDetails'] . ', ' . $row['postLocBarangay'] . ' ' . $row['postLocCity'] . ', ' . $row['postLocProvince'] . ' (' . $row['postLocationName'] . ')';
                    } else if ($row['DeliveryStatus'] == "COLLECTED") {
                        $footerMessage = 'You have dropped off your product/item. It will be prepared to ship out.';
                    } else if ($row['DeliveryStatus'] == "IN TRANSIT") {
                        $footerMessage = 'The product/item is shipped out.';
                    } else if ($row['DeliveryStatus'] == "RECEIVED") {
                        $footerMessage = 'The product/item is received by '.$row['receivedByPostLocationName'];
                    } else if ($row['DeliveryStatus'] == "OUT FOR DELIVERY") {
                        $footerMessage = 'The product/item is out for delivery';
                    } else if ($row['DeliveryStatus'] == "DELIVERED") {
                        $footerMessage = 'The product/item is delivered';
                    } else if ($row['DeliveryStatus'] == "CANCELLED") {
                        $footerMessage = 'The product/item delivery is cancelled';
                    } else if ($row['DeliveryStatus'] == "DECLINED") {
                        $footerMessage = 'The product/item approval is declined. Kindly visit ' . $row['postLocOtherLocationDetails'] . ', ' . $row['postLocBarangay'] . ' ' . $row['postLocCity'] . ', ' . $row['postLocProvince'] . ' (' . $row['postLocationName'] . ') to request re-approval.';
                    }
                    ?>
                    <p><?= $footerMessage; ?></p>
                </div>
                <div class="col  mx-3 text-end">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>