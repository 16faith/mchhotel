<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

$output = [];
$q = "SELECT DISTINCT room_type FROM room_no ORDER BY room_type";
$types_result = mysqli_query($con, $q);

while ($type = mysqli_fetch_assoc($types_result)) {
    $room_type = $type['room_type'];
    $rooms_query = "SELECT room_number, status FROM room_no WHERE room_type = '$room_type'";
    $rooms_result = mysqli_query($con, $rooms_query);

    $rooms = [];
    while ($room = mysqli_fetch_assoc($rooms_result)) {
        $rooms[] = $room;
    }

    $output[] = [
        'room_type' => $room_type,
        'rooms' => $rooms
    ];
}

echo json_encode($output);
?>
