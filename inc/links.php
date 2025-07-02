<!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> -->
<link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="css/common.css">


<?php
    session_start();
    
        require('admin/inc/db_config.php');
        require('admin/inc/essentials.php');

        $contact_q = "SELECT * FROM `contact_details` WHERE `id` = ?";
        $settings_q = "SELECT * FROM `settings` WHERE `id` = ?";
        $values = [1];
        $contact_r = mysqli_fetch_assoc(select($contact_q, $values, 'i'));
        $settings_r = mysqli_fetch_assoc(select($settings_q, $values, 'i'));
     
        if($settings_r['shutdown']){
            echo<<<alertbar
                <div class='bg-danger text-center p-2 fw-bold'>
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    Bookings are temporarily closed!
                </div>
            alertbar;
        }
    ?>