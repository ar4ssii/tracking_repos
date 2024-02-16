<!-- Modal  -->
<div class="modal fade text-start" id="DeliverModal_<?= $row5['deliverID'] ?>" tabindex="-1" aria-labelledby="DeliverModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="DeliverModalLabel">Confirm to set the Package Out for Delivery</h5>
            </div>

            <?php
            $SenderFullName = $row5['senderFName'] . ' ' . $row5['senderMName'] . ' ' . $row5['senderLName'];
            $RecipientFullName = $row5['recipientFName'] . ' ' . $row5['recipientMName'] . ' ' . $row5['recipientLName'];

            // $fromPostLocationID = $row5['fromPostLocationID'];
            // $sql_fetchPostLocation = "SELECT * FROM tbl_postlocations WHERE postLocationID = $fromPostLocationID";
            // $result_fetchPostLocation = $conn->query($sql_fetchPostLocation);
            // while ($fetch = $result_fetchPostLocation->fetch_assoc()) { 
            ?>

            <div class="modal-body text-center">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="2" class="text-start fw-bold bg-secondary text-white">Sender Information</td>
                            </tr>
                            <tr>
                                <td class="text-end">Sender Name</td>
                                <td><?= $SenderFullName ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Sender Contact Information</td>
                                <td><?= $row5['senderContactNumber'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Sender's Delivery Address</td>
                                <?php
                                $senderPostalID = $row5['senderPostalID'];
                                $sql_fetchPostal = "SELECT * FROM tbl_postal_codes WHERE postalID = $senderPostalID";
                                $result_fetchPostal = $conn->query($sql_fetchPostal);

                                if ($result_fetchPostal->num_rows > 0) {
                                    while ($fetch = $result_fetchPostal->fetch_assoc()) {

                                ?>
                                        <td><?= $row5['senderOtherLocationDetails'] . ', ' . $row5['senderStreet'] . ', ' . $row5['senderBarangay'] . ', ' . $fetch['City'] . ', ' . $fetch['Province'] ?>
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
                                <td><?= $row5['recipientContactNumber'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Recipient's Delivery Address</td>
                                <?php
                                $recipientPostalID = $row5['recipientPostalID'];
                                $sql_fetchPostal = "SELECT * FROM tbl_postal_codes WHERE postalID = $recipientPostalID";
                                $result_fetchPostal = $conn->query($sql_fetchPostal);

                                if ($result_fetchPostal->num_rows > 0) {
                                    while ($fetch = $result_fetchPostal->fetch_assoc()) {

                                ?>
                                        <td><?= $row5['recipientOtherLocationDetails'] . ', ' . $row5['recipientStreet'] . ', ' . $row5['recipientBarangay'] . ', ' . $fetch['City'] . ', ' . $fetch['Province'] ?> </td>
                                <?php }
                                } ?>

                            </tr>
                            <tr>
                                <td colspan="2" class="text-start fw-bold bg-secondary text-white">Item Information</td>
                            </tr>
                            <tr>
                                <td class="text-end">Item Name</td>
                                <td><?= $row5['ItemName'] ?></td>
                            </tr>

                            <tr>
                                <td class="text-end">Item Fragile?</td>
                                <td><?= ($row5['ItemFragile'] == '1') ? 'Yes' : 'No' ?>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-start fw-bold bg-secondary text-white">Fees and Breakdown</td>
                            </tr>
                            <tr>
                                <td class="text-end">Item Value</td>
                                <td><?= $row5['ItemValue'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Service Fee</td>
                                <td><?php
                                    echo $row5['ItemSize'];
                                    echo ($row5['sender_payServiceFee'] == '1') ? ' (PAID)' : '';
                                    ?></td>
                            </tr>

                            <tr class=" fw-bold">
                                <td class="text-end">Total Amount</td>
                                <td>
                                    <?php
                                    // Check if sender_payServiceFee is 1, then set Total Amount to ItemValue
                                    if ($row5['sender_payServiceFee'] == '1') {
                                        echo $row5['ItemValue'];
                                    } else {
                                        // Calculate Total Amount as the sum of ItemValue and ItemSize
                                        $totalAmount = $row5['ItemValue'] + $row5['ItemSize'];
                                        echo $totalAmount;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end">Payment Type</td>
                                <td><?= ($row5['PaymentType'] == '1') ? 'Cash on Delivery' : '' ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Payment Status</td>
                                <td><?= ($row5['PaymentStatus'] == 'PAID') ? 'PAID' : 'PENDING' ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col text-center">
                    <h5>Click 'yes' to confirm you are about to set <?= $row5['transactionNumber'] ?> Out for Delivery.</h5>
                    <form action="../config/out_for_delivery_ctrl.php" method="post">
                        <button class="btn btn-info rounded-pill text-white" name="btn_out_for_delivery" type="submit">Yes</button>
                        <input type="hidden" name="hidden_deliverID" value="<?= $row5['deliverID'] ?>" id="">
                        <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal" aria-label="Close">No</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>