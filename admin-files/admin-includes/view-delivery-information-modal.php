<!-- Modal  -->
<div class="modal fade text-start" id="ViewDeliveryInfoModal_<?= $row6['deliverID'] ?>" tabindex="-1" aria-labelledby="ViewDeliveryInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ViewDeliveryInfoModalLabel">Status: <?= $row6['DeliveryStatus'] ?></h5>
            </div>

            <?php
            $SenderFullName = $row6['senderFName'] . ' ' . $row6['senderMName'] . ' ' . $row6['senderLName'];
            $RecipientFullName = $row6['recipientFName'] . ' ' . $row6['recipientMName'] . ' ' . $row6['recipientLName'];

            // $fromPostLocationID = $row6['fromPostLocationID'];
            // $sql_fetchPostLocation = "SELECT * FROM tbl_postlocations WHERE postLocationID = $fromPostLocationID";
            // $result_fetchPostLocation = $conn->query($sql_fetchPostLocation);
            // while ($fetch = $result_fetchPostLocation->fetch_assoc()) { 
            ?>

            <div class="modal-body text-center">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="2" class="text-start fw-bold bg-secondary text-white">Delivery Information</td>
                            </tr>
                            <tr>
                                <td class="text-end">Delviery Status</td>
                                <td><?= $row6['DeliveryStatus'] ?></td>
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
                                <td><?= $row6['senderContactNumber'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Sender's Delivery Address</td>
                                <?php
                                $senderPostalID = $row6['senderPostalID'];
                                $sql_fetchPostal = "SELECT * FROM tbl_postal_codes WHERE postalID = $senderPostalID";
                                $result_fetchPostal = $conn->query($sql_fetchPostal);

                                if ($result_fetchPostal->num_rows > 0) {
                                    while ($fetch = $result_fetchPostal->fetch_assoc()) {

                                ?>
                                        <td><?= $row6['senderOtherLocationDetails'] . ', ' . $row6['senderStreet'] . ', ' . $row6['senderBarangay'] . ', ' . $fetch['City'] . ', ' . $fetch['Province'] ?>
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
                                <td><?= $row6['recipientContactNumber'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Recipient's Delivery Address</td>
                                <?php
                                $recipientPostalID = $row6['recipientPostalID'];
                                $sql_fetchPostal = "SELECT * FROM tbl_postal_codes WHERE postalID = $recipientPostalID";
                                $result_fetchPostal = $conn->query($sql_fetchPostal);

                                if ($result_fetchPostal->num_rows > 0) {
                                    while ($fetch = $result_fetchPostal->fetch_assoc()) {

                                ?>
                                        <td><?= $row6['recipientOtherLocationDetails'] . ', ' . $row6['recipientStreet'] . ', ' . $row6['recipientBarangay'] . ', ' . $fetch['City'] . ', ' . $fetch['Province'] ?> </td>
                                <?php }
                                } ?>

                            </tr>
                            <tr>
                                <td colspan="2" class="text-start fw-bold bg-secondary text-white">Item Information</td>
                            </tr>
                            <tr>
                                <td class="text-end">Item Name</td>
                                <td><?= $row6['ItemName'] ?></td>
                            </tr>

                            <tr>
                                <td class="text-end">Item Fragile?</td>
                                <td><?= ($row6['ItemFragile'] == '1') ? 'Yes' : 'No' ?>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-start fw-bold bg-secondary text-white">Fees and Breakdown</td>
                            </tr>
                            <tr>
                                <td class="text-end">Item Value</td>
                                <td><?= $row6['ItemValue'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Service Fee</td>
                                <td><?php
                                    echo $row6['ItemSize'];
                                    echo ($row6['sender_payServiceFee'] == '1') ? ' (PAID)' : '';
                                    ?></td>
                            </tr>

                            <tr class=" fw-bold">
                                <td class="text-end">Total Amount</td>
                                <td>
                                    <?php
                                    // Check if sender_payServiceFee is 1, then set Total Amount to ItemValue
                                    if ($row6['PaymentStatus'] == 'PAID') {
                                        echo $row6['PaymentStatus'];
                                    } else {
                                        // Calculate Total Amount as the sum of ItemValue and ItemSize
                                        $totalAmount = $row6['ItemValue'] + $row6['ItemSize'];
                                        echo $totalAmount;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end">Payment Type</td>
                                <td><?= ($row6['PaymentType'] == '1') ? 'Cash on Delivery' : '' ?></td>
                            </tr>


                            <tr class="<?php if ($row6['PaymentStatus'] == 'PAID') {
                                            echo 'bg-success';
                                        } ?> text-white">
                                <td class="text-end">Payment Status</td>
                                <td>
                                    <?= ($row6['PaymentStatus'] == 'PAID') ? 'PAID' : '' ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-start fw-bold bg-secondary text-white">Timestamps</td>
                            </tr>
                            <tr>
                                <td class="text-end">Booked Date</td>
                                <td><?= date('F j, Y g:i A', strtotime($row6['BookedDate'])) ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Approved Booking Date</td>
                                <td><?= date('F j, Y g:i A', strtotime($row6['DateApproved'])) ?></td>
                            </tr>
                            <?php if (isset($row6['DateReapproved'])) { ?>
                                <tr>
                                    <td class="text-end">Re-approved Booking Date</td>
                                    <td><?= date('F j, Y g:i A', strtotime($row6['DateReapproved'])) ?></td>
                                </tr>
                            <?php } ?>
                            <?php if (isset($row6['DateDeclined'])) { ?>
                                <tr>
                                    <td class="text-end">Booking Declined Date</td>
                                    <td><?= date('F j, Y g:i A', strtotime($row6['DateDeclined'])) ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td class="text-end">Item/Product Dropped Off Date</td>
                                <td><?= date('F j, Y g:i A', strtotime($row6['DateDroppedOff'])) ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Item/Product Shipped Out Date</td>
                                <td><?= date('F j, Y g:i A', strtotime($row6['DateShippedOut'])) ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Date Received from other post location</td>
                                <td><?= date('F j, Y g:i A', strtotime($row6['DateReceived'])) ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Item/Product Out for Delivery Date</td>
                                <td><?= date('F j, Y g:i A', strtotime($row6['DateOutForDelivery'])) ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Date Delivered</td>
                                <td><?= date('F j, Y g:i A', strtotime($row6['DateDelivered'])) ?></td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col text-end">

                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal" aria-label="Close">Close</button>

                </div>
            </div>

        </div>
    </div>
</div>