<?php
include 'index-template/header.php';
?>


<div class="container-fluid bg-gradient-custom align-items-center py-5">
    <div class="container mt-1">
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
    <div class="container mb-5 py-4">
        <div class="card shadow py-4">
            <div class="card-body py-4">
                <h5>Create an Account</h5>
                <form class="row g-3" method="post" action="config/register.php">
                    <div class="col-md-6">
                        <small class="text-muted mb-0">First Name</small>
                        <input type="text" required class="form-control" placeholder="Enter your First Name." name="FName" id="">
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted mb-0">Last Name</small>
                        <input type="text" required class="form-control" placeholder="Enter your Last Name." name="LName" id="">
                    </div>
                    <div class="col-12">
                        <small class="text-muted mb-0">Email Address</small>
                        <input type="email" required class="form-control" id="" placeholder="name@example.com" name="Username">
                    </div>
                    <div class="col-12">
                        <small class="text-muted mb-0">Mobile Number</small>
                        <div class="input-group">
                            <span class="input-group-text" id="contact-number">+63</span>
                            <input type="number" required class="form-control" aria-describedby="contact-number" name="ContactNumber">
                        </div>
                    </div>
                    <div class="col-12">
                        <small class="text-muted mb-0">Password</small>
                        <input type="password" required class="form-control" id="" placeholder="Create your Password" name="Password">
                    </div>
                    <div class="col-12 d-grid gap-2">
                        <button type="submit" name="btn_register" class="btn btn-primary rounded-pill text-uppercase">Register</button>
                    </div>
                </form>
            </div>
        </div>
        <p class="text-center mt-2">Already have an acount? <a href="index.php" class="text-decoration-none">Login instead.</a></p>

    </div>


</div>

<?php
include 'index-template/footer.php';
?>