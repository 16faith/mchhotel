<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

if (isset($_POST['booking_id'])) {
    $booking_id = (int)$_POST['booking_id'];

    // Get the room number from the booking
    $get_room = $con->prepare("SELECT room_no FROM booking_order WHERE booking_id=?");
    $get_room->bind_param("i", $booking_id);
    $get_room->execute();
    $res = $get_room->get_result();

    if ($res->num_rows == 1) {
        $row = $res->fetch_assoc();
        $room_no = $row['room_no'];

        // Update booking status to 'checked_out'
        $update_booking = $con->prepare("UPDATE booking_order SET booking_status='checked_out' WHERE booking_id=?");
        $update_booking->bind_param("i", $booking_id);
        $update_booking->execute();

        // Set room status back to available
        $update_room = $con->prepare("UPDATE room_no SET status='available' WHERE room_number=?");
        $update_room->bind_param("s", $room_no);
        $update_room->execute();

        echo 'success';
    } else {
        echo 'booking_not_found';
    }
} else {
    echo 'invalid_data';
}
?>
