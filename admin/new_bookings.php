<?php 
    require('inc/essentials.php');
    require('inc/db_config.php');
    adminLogin();

    $types_query = "SELECT DISTINCT room_type FROM room_no ORDER BY room_type";
    $types_result = mysqli_query($con, $types_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - New Bookings</title>
    <?php require('inc/links.php'); ?>

    <style>
    .scroll-row {
        display: flex;
        overflow-x: auto;
        gap: 0.5rem;
        padding-bottom: 0.5rem;
    }

    .scroll-row .btn {
        min-width: 100px;
        flex: 0 0 auto;
    }

    .scroll-row::-webkit-scrollbar {
        height: 6px;
    }

    .scroll-row::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 4px;
    }

    .modal-dialog {
        max-height: 100vh; /* 90% of the viewport height */
    }

    .modal-content {
        max-height: 90vh; /* 85% of the viewport height */
        overflow-y: auto;
    }

    .dropdown-menu {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        }
  </style>
</head>
<body class="bg-light">
    
    <?php require('inc/header.php'); ?>
    <div id="alert-container"></div>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">New Bookings</h3>

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
                                        <th class="bg-dark text-light">Booking Details</th>
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

    <!-- assign room no. modal -->
    <div class="modal fade" id="assign-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <form id="assign_room_form">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-light">
                        <h1 class="modal-title fs-5">Assign Room</h1>
                    </div>
                    <div class="modal-body">

                        <h5 class="text-muted mb-2">Select Room:</h5>
                        <div id="room-selection-container">
                        <div class="text-muted">Loading rooms...</div>
                        </div>
                        <br>
                            <input type="hidden" name="booking_id" id="assign_booking_id">
                        <img src="../images/pexels-olly-3771110.jpg" style="width: 100%; height: 350px; object-fit: cover;"><br>
                        <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
                            Note: Please ensure that the room number you are assigning is available and not already occupied. Only assign a room when guest have arrrived.
                        </span>
                        
                    </div>
                    <div class="modal-footer bg-dark text-light">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">ASSIGN</button>
                    </div>
                </div> 
            </form>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>
    <script src="scripts/new_bookings.js"></script>
</body>
</html>