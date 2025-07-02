<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

if(isset($_POST['checkout_booking'])){
    $booking_id = filter_var($_POST['booking_id'], FILTER_SANITIZE_NUMBER_INT);

    // Get the room number for this booking
    $get_room = mysqli_query($con, "SELECT room_no FROM booking_order WHERE booking_id = '$booking_id'");
    $room = mysqli_fetch_assoc($get_room);

    // Set booking status to completed/checked_out
    $update_booking = mysqli_query($con, "UPDATE booking_order SET booking_status = 'completed' WHERE booking_id = '$booking_id'");

    // Set room status to Available if a room was assigned
    if($room && $room['room_no']) {
        mysqli_query($con, "UPDATE rooms SET status = 'Available' WHERE room_number = '{$room['room_no']}'");
    }

    echo ($update_booking) ? "1" : "0";
    exit;
}
?>