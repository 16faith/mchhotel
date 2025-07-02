<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

if(isset($_POST['update_status'])) {
    $booking_id = $_POST['booking_id'];
    $status = 'pending';

    $query = "UPDATE booking_order SET booking_status=? WHERE booking_id=?";
    $stmt = $con->prepare($query);
    
    if (!$stmt) {
        echo 0; // SQL error
        exit;
    }

    $stmt->bind_param('si', $status, $booking_id);

    if ($stmt->execute()) {
        echo 1; // success
    } else {
        echo 0; // failure
    }
}
?>
