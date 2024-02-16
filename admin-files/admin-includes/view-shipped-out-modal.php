<!-- Modal  -->
<div class="modal fade text-start" id="ViewShippedOutModal_<?= $row3['deliverID'] ?>" tabindex="-1" aria-labelledby="ViewPackageDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ViewPackageDetailsModalLabel">View details of <?= $row3['transactionNumber'] ?></h5>
            </div>

            <?php
            $SenderFullName = $row3['senderFName'] . ' ' . $row3['senderMName'] . ' ' . $row3['senderLName'];
            $RecipientFullName = $row3['recipientFName'] . ' ' . $row3['recipientMName'] . ' ' . $row3['recipientLName'];

            // $fromPostLocationID = $row3['fromPostLocationID'];
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
                                <td><?= $row3['DeliveryStatus'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Item size</td>
                                <td><?php
                                    $itemSize;
                                    if ($row3['ItemSize'] == '80') {
                                        $itemSize = 'Small';
                                    } else if ($row3['ItemSize'] == '100') {
                                        $itemSize = 'Medium';
                                    } else if ($row3['ItemSize'] == '120') {
                                        $itemSize = 'Large';
                                    } else if ($row3['ItemSize'] == '200') {
                                        $itemSize = 'Box';
                                    }
                                    echo $itemSize;

                                    ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Item Fragile?</td>
                                <td><?= ($row3['ItemFragile'] == '1') ? 'Yes' : 'No' ?>

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
                                <td><?= $row3['senderContactNumber'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Sender's Delivery Address</td>
                                <?php
                                $senderPostalID = $row3['senderPostalID'];
                                $sql_fetchPostal = "SELECT * FROM tbl_postal_codes WHERE postalID = $senderPostalID";
                                $result_fetchPostal = $conn->query($sql_fetchPostal);

                                if ($result_fetchPostal->num_rows > 0) {
                                    while ($fetch = $result_fetchPostal->fetch_assoc()) {

                                ?>
                                        <td><?= $row3['senderOtherLocationDetails'] . ', ' . $row3['senderStreet'] . ', ' . $row3['senderBarangay'] . ', ' . $fetch['City'] . ', ' . $fetch['Province'] ?>
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
                                <td><?= $row3['recipientContactNumber'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Recipient's Delivery Address</td>
                                <?php
                                $recipientPostalID = $row3['recipientPostalID'];
                                $sql_fetchPostal = "SELECT * FROM tbl_postal_codes WHERE postalID = $recipientPostalID";
                                $result_fetchPostal = $conn->query($sql_fetchPostal);

                                if ($result_fetchPostal->num_rows > 0) {
                                    while ($fetch = $result_fetchPostal->fetch_assoc()) {

                                ?>
                                        <td><?= $row3['recipientOtherLocationDetails'] . ', ' . $row3['recipientStreet'] . ', ' . $row3['recipientBarangay'] . ', ' . $fetch['City'] . ', ' . $fetch['Province'] ?> </td>
                                <?php }
                                } ?>

                            </tr>
                            <tr>
                                <td colspan="2" class="text-start fw-bold bg-secondary text-white">Item Information</td>
                            </tr>
                            <tr>
                                <td class="text-end">Item Name</td>
                                <td><?= $row3['ItemName'] ?></td>
                            </tr>


                            <tr>
                                <td colspan="2" class="text-start fw-bold bg-secondary text-white">Fees and Breakdown</td>
                            </tr>
                            <tr>
                                <td class="text-end">Item Value</td>
                                <td><?= $row3['ItemValue'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-end">Service Fee</td>
                                <td><?php
                                    echo $row3['ItemSize'];
                                    echo ($row3['sender_payServiceFee'] == '1') ? ' (PAID)' : '';
                                    ?></td>
                            </tr>

                            <tr class=" fw-bold">
                                <td class="text-end">Total Amount</td>
                                <td>
                                    <?php
                                    // Check if sender_payServiceFee is 1, then set Total Amount to ItemValue
                                    if ($row3['sender_payServiceFee'] == '1') {
                                        echo $row3['ItemValue'];
                                    } else {
                                        // Calculate Total Amount as the sum of ItemValue and ItemSize
                                        $totalAmount = $row3['ItemValue'] + $row3['ItemSize'];
                                        echo $totalAmount;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end">Payment Type</td>
                                <td><?= ($row3['PaymentType'] == '1') ? 'Cash on Delivery' : '' ?></td>
                            </tr>

                            <tr>
                                <td class="text-end">Payment Status</td>
                                <td><?= $row3['PaymentStatus']?>
                                    
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col my-4 mx-2 text-end">
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal" aria-label="Close">Close</button>
            </div>

        </div>
    </div>
</div>