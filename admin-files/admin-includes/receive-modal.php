<!-- Modal  -->
<div class="modal fade text-start" id="ReceiveModal_<?= $row4['deliverID'] ?>" tabindex="-1" aria-labelledby="ReceiveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ReceiveModalLabel">Confirm to Receive Package</h5>
            </div>

            <?php
            $fromPostLocationID = $row4['fromPostLocationID'];
            $sql_fetchPostLocation = "SELECT * FROM tbl_postlocations WHERE postLocationID = $fromPostLocationID";
            $result_fetchPostLocation = $conn->query($sql_fetchPostLocation);
            while ($row2 = $result_fetchPostLocation->fetch_assoc()) { ?>
                
                <div class="modal-body text-center">
                    <h5>Click 'yes' to confirm you are about to receive <?= $row4['transactionNumber'] ?> from post location <span class="fw-bold"><?= $row2['postLocationName'] ?></span> ?</h5>
                    <form action="../config/package_received_ctrl.php" method="post">
                        <button class="btn btn-info rounded-pill text-white" name="btn_confirm_received" type="submit">Yes</button>
                        <input type="hidden" name="hidden_deliverID" value="<?= $row4['deliverID'] ?>" id="">
                    </form>
                    <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal" aria-label="Close">No</button>
                </div>
            <?php  } ?>
        </div>
    </div>
</div>