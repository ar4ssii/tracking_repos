<?php include 'admin-includes/header.php'; ?>

<!-- Page content -->
<div class="main">

    <div class="container-fluid border">
        <div class="container">
            <h1>Inbox</h1>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sender</th>
                            <th>Email Address</th>
                            <th>Date and Time</th>
                            <th style="width:170px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <button class="btn btn-primary rounded-pill my-1" data-bs-toggle="modal" data-bs-target="#OpenInboxModal">
                                    Open
                                </button>
                                <button class="btn btn-danger rounded-pill my-1" data-bs-toggle="modal" data-bs-target="#DeleteInboxModal">
                                    Delete
                                </button>
                                <?php include 'admin-includes/cms-openInbox-modal.php'; ?>
                                <?php include 'admin-includes/deletes-modal.php'; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include 'admin-includes/footer.php'; ?>