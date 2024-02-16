<?php
include 'index-template/header.php';
?>

<div class="container mt-2">
    <?php
    if (isset($_SESSION['message'])) {
    ?>
        <div class="alert alert-<?= $_SESSION['alert-color'] ?> alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>
                <?= $_SESSION['message'] ?>
            </strong>
        </div>
    <?php
        unset($_SESSION['message']);
    }
    ?>
</div>


<div class="container-fluid bg-gradient-custom d-flex justify-content-center align-items-center text-center py-5">
    <div class="row">
        <div class="container bg-white p-5 cs-rounded-5 shadow">
            <h1 class="text-uppercase">Tracking System</h1>
            <a type="button" href="tracking-details.php" class="btn btn-outline-primary rounded-pill px-4" style="margin-right:10px;">
                Track Now
            </a>
        </div>
        <h6 class="mt-2">A product sender? <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a> to manage your account and transactions.</h6>
    </div>
</div>



<?php
include 'index-template/footer.php';
?>