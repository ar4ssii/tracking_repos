<!-- Modal  -->
<div class="modal fade text-start" id="DeclinePendingModal_<?= $row['deliverID'] ?>" tabindex="-1" aria-labelledby="DeclinePendingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="DeclinePendingModalLabel">Confirm Refusal of Pending Booking</h5>
            </div>
            <div class="modal-body ">
                <h5>Are you sure to decline <?= $row['transactionNumber'] ?>?</h5>
                <div class="col">
                    <h6>Details</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>

                                <tr>
                                    <td class="text-end">Item Name:</td>
                                    <td>
                                        <?= $row['ItemName'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">Item Size:</td>
                                    <td>
                                        <?php
                                        // echo $row['ItemSize'];
                                        $ItemSizeName;
                                        if ($row['ItemSize'] == '80') {
                                            $ItemSizeName = 'Small';
                                        } else if ($row['ItemSize'] == '100') {
                                            $ItemSizeName = 'Medium';
                                        } else if ($row['ItemSize'] == '120') {
                                            $ItemSizeName = 'Large';
                                        } else if ($row['ItemSize'] == '200') {
                                            $ItemSizeName = 'Box';
                                        }
                                        echo $ItemSizeName;
                                        ?> </td>
                                </tr>
                                <tr>
                                    <td class="text-end">Item Fragile?</td>
                                    <td>
                                        <?php
                                        $ItemFragile;
                                        if ($row['ItemFragile'] == '1') {
                                            $ItemFragile = 'Yes';
                                        } else if ($row['ItemFragile'] == '0') {
                                            $ItemFragile = 'No';
                                        }
                                        echo $ItemFragile;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">Total Amount:</td>
                                    <td>
                                        <?php
                                        $totalAmount = $row['ItemSize'] + $row['ItemValue'];
                                        echo $totalAmount;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">Payment Type:</td>
                                    <td>
                                        <?php
                                        $PaymentType;
                                        if ($row['PaymentType'] == '1') {
                                            $PaymentType = 'Cash on Delivery';
                                        } else if ($row['PaymentType'] == '0') {
                                            $PaymentType = 'N/A';
                                        }
                                        echo $PaymentType;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">Payment Status:</td>
                                    <td>
                                        <?= $row['PaymentStatus'] ?>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <form action="../config/decline_pending_ctrl.php" method="post">
                    <div class="row my-3">
                        <div class="col">
                            <label for="">Drop off Post Location</label>
                            <?php
                            $senderPostalID = $row['senderPostalID'];
                            $sql_fetchPostLocation = "SELECT * FROM tbl_postlocations WHERE postLocationID = $senderPostalID";
                            $result_fetchPostLocation = $conn->query($sql_fetchPostLocation);
                            while ($row2 = $result_fetchPostLocation->fetch_assoc()) { ?>
                                <input type="text" class="form-control" readonly value="<?= $row2['postLocationName'] ?>">
                            <?php  } ?>

                        </div>

                        <div class="col">
                            <label for="">Destination Post Location</label>
                            <?php
                            $recipientPostalID = $row['recipientPostalID'];
                            $sql_fetchPostLocation = "SELECT * FROM tbl_postlocations WHERE postLocationID = $recipientPostalID";
                            $result_fetchPostLocation = $conn->query($sql_fetchPostLocation);
                            while ($row2 = $result_fetchPostLocation->fetch_assoc()) { ?>
                                <input type="text" class="form-control" readonly value="<?= $row2['postLocationName'] ?>">

                            <?php  } ?>

                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <label for="">Reason of refusal to approve:</label>
                            <textarea name="ReasonDecline" class="form-control" id="" cols="30" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="col text-center">
                        <button class="btn btn-info rounded-pill text-white" name="btn_decline_pending" type="submit">Yes</button>
                        <input type="hidden" name="hidden_deliverID" value="<?= $row['deliverID'] ?>" id="">
                        <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal" aria-label="Close">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>