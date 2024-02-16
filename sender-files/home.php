<?php
include 'sender-includes/header.php';
?>
<div class="container">
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
    unset($_SESSION['message']);} 
    ?>
</div>
<div class="container-fluid py-3">

    <h1 class="text-center">Welcome to sender page</h1>

    <div class="container d-flex justify-content-center">
        <a type="button" href="delivery.php" class="btn btn-outline-primary">
            Pa-deliver na
        </a>
    </div>

</div>

<?php
include 'sender-includes/footer.php';
?>