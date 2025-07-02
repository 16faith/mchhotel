<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

if (isset($_POST['room_no'], $_POST['booking_id'])) {
    $room_no = $_POST['room_no'];
    $booking_id = (int)$_POST['booking_id'];

    // Check if room is available
    $check_q = "SELECT * FROM room_no WHERE room_number=? AND status='available'";
    $stmt = $con->prepare($check_q);
    $stmt->bind_param("s", $room_no);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        ob_clean();
        echo "not_available";
        exit;
    }

    // Assign room to booking
    $update_booking = $con->prepare("UPDATE booking_order SET room_no=?, booking_status='booked' WHERE booking_id=?");
    $update_booking->bind_param("si", $room_no, $booking_id);
    $update_booking->execute();

    if ($update_booking->affected_rows > 0) {
        $update_room = $con->prepare("UPDATE room_no SET status='occupied' WHERE room_number=?");
        $update_room->bind_param("s", $room_no);
        $update_room->execute();
        ob_clean();
        echo "success";
    } else {
        ob_clean();
        echo "update_failed";
    }
} else {
    ob_clean();
    echo "invalid_data";
}
?>
