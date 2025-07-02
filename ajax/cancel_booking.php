<?php 
require('../admin/inc/db_config.php');
require('../admin/inc/essentials.php');

date_default_timezone_set("Asia/Manila");
session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
    redirect('index.php');
}

if (isset($_POST['cancel_booking'])) {
    $frm_data = filteration($_POST);

    $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=? WHERE `booking_id`=? AND `user_id`=?";
    $values = ['cancelled', 0, $frm_data['booking_id'], $_SESSION['uId']];
    $types = 'siii';

    // Actually run the update
    $result = update($query, $values, $types);

    echo $result ? "1" : "0";
    exit;
}
?>