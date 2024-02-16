<!-- Modal  -->
<div class="modal fade text-start" id="ShippedOutModal_<?= $row3['deliverID'] ?>" tabindex="-1" aria-labelledby="DroppedOffModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="DroppedOffModalLabel">Confirm Ship Out Package</h5>
            </div>
            <div class="modal-body text-center">
                <form action="../config/package_shipped_out_ctrl.php" method="post">
                    <h5>Click 'yes' to confirm you are about to ship out <?= $row3['transactionNumber'] ?> from <?= $_SESSION['auth_user']['postLocationName'] ?></h5>

                    <button class="btn btn-info rounded-pill text-white" name="btn_confirm_shipped_out" type="submit">Yes</button>
                    <input type="hidden" name="hidden_deliverID" value="<?= $row3['deliverID'] ?>" id="">
                    <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal" aria-label="Close">No</button>
                </form>
            </div>
        </div>
    </div>
</div>