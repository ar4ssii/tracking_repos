<!-- Modal  -->
<div class="modal fade text-start" id="OkayDeliveredModal_<?= $row6['deliverID'] ?>" tabindex="-1" aria-labelledby="OkayDeliveredModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="OkayDeliveredModalLabel">Confirm to set the Package Status to Delivered</h5>
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
                                    if ($row6['sender_payServiceFee'] == '1') {
                                        echo $row6['ItemValue'];
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
                            <form action="../config/okay_delivered_ctrl.php" method="post">
                                <tr class="bg-warning">
                                    <td class="text-end">Payment Status</td>
                                    <td>
                                        <select name="PaymentStatus" id="" required class="form-select">
                                            <option value="PAID" <?= ($row6['PaymentStatus'] == 'PAID') ? 'selected' : '' ?>>PAID</option>
                                            <option value="PENDING" <?= ($row6['PaymentStatus'] == 'PENDING') ? 'selected' : '' ?>>PENDING</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="bg-warning">
                                    <td class="text-end">Delivery Status</td>
                                    <td>
                                        <select name="DeliveryStatus" id="" required class="form-select">
                                            <option value="DELIVERED" <?= ($row6['DeliveryStatus'] == 'DELIVERED') ? 'selected' : '' ?>>DELIVERED</option>
                                            <option value="CANCELLED" <?= ($row6['DeliveryStatus'] == 'CANCELLED') ? 'selected' : '' ?>>CANCELLED</option>
                                        </select>
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

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col text-center">
                    <h5>Click 'yes' to confirm you are about to set <?= $row6['transactionNumber'] ?> Status to <span class="fw-bold">Delivered</span>.</h5>

                    <button class="btn btn-info rounded-pill text-white" name="btn_okay_delivered" type="submit">Yes</button>
                    <input type="hidden" name="hidden_deliverID" value="<?= $row6['deliverID'] ?>" id="">
                    <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal" aria-label="Close">No</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>