<?php session_start();

?>

<?php $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="..\assets\fontawesome\css\all.css">
    <link rel="stylesheet" href="..\assets\fontawesome\css\regular.css">
    <link rel="stylesheet" href="..\assets\custom\style-custom.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm bg-light">
        <div class="container-fluid">
           
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= $page == 'home.php' ? 'active' : '' ?>" href="home.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $page == 'delivery.php' ? 'active' : '' ?>" href="delivery.php">Delivery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $page == 'transactions.php' ? 'active' : '' ?>" href="transactions.php">Transactions</a>
                    </li>
                </ul>

                <div class="d-flex ml-auto ">
                    <div class="dropdown mx-3">
                    <?php if(isset($_SESSION['auth'])){ ?>
                        <a class="nav-link row d-flex align-items-center dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="col px-1"> <span class="fas fa-user-circle fa-2x text-info"></span></div>
                            <div class="col px-0"><?php echo $_SESSION['auth_user']['Fullname']; ?></div>
                        </a>
                        <?php } ?>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#LogoutModal">Logout</a></li>
                        </ul>
                    </div>

                </div>

            </div>
        </div>
    </nav>

    <!-- Modal in logout-->
    <div class="modal fade text-start" id="LogoutModal" tabindex="-1" aria-labelledby="LogoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center py-5">
                    <h5>Are you sure to logout?</h5>
                    <a type="button" href="../config/sender_logout.php" class="btn btn-success rounded-pill">Yes</a>
                    <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal" aria-label="Close">No</button>
                </div>
            </div>
        </div>
    </div>