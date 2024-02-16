<?php
// Check if the current page is not 'contactUs.php'
$current_page = basename($_SERVER['PHP_SELF']);
if ($current_page != 'register.php') {
?>

    <footer class="bg-dark text-light p-2 sticky-bottom">
        <div class="container-fluid pt-3">
            
            <hr>
            <div class="row text-center">
                <p>
                    © 2024 Copyright: Tracking System
                </p>
            </div>
        </div>
    </footer>

<?php
}
?>

</body>

</html>