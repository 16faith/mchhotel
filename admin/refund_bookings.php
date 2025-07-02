<?php 
    require('inc/essentials.php');
    require('inc/db_config.php');
    adminLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Refund Bookings</title>
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">
    
    <?php require('inc/header.php'); ?>
    <div id="alert-container"></div>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Refund Bookings</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <input type="text" oninput="search_room(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Type here to search">
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover border" style="min-width: 1200px;">
                                <thead >
                                    <tr>
                                        <th class="bg-dark text-light">#</th>
                                        <th class="bg-dark text-light">User Details</th>
                                        <th class="bg-dark text-light">Room Details</th>
                                        <th class="bg-dark text-light">Refund Amount</th>
                                        <th class="bg-dark text-light">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">
                                    
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>
    <script src="scripts/refund_bookings.js"></script>

</body>
</html>