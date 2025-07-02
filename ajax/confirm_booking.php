<?php 
require('../admin/inc/db_config.php');
require('../admin/inc/essentials.php');

date_default_timezone_set("Asia/Manila");

if (isset($_POST['fake_payment'])) {
    session_start();

    $user_id  = $_SESSION['uId'];
    $room_id  = $_SESSION['room']['id'];
    $checkin  = $_SESSION['room']['checkin'];
    $checkout = $_SESSION['room']['checkout'];
    $amount   = $_SESSION['room']['payment'];
    $trans_id = 'FAKEPAY-' . uniqid();
    $status   = 'pending';

    $query  = "INSERT INTO booking_order (user_id, room_id, check_in, check_out, trans_id, trans_amount, booking_status)
               VALUES (?, ?, ?, ?, ?, ?, ?)";
    $values = [$user_id, $room_id, $checkin, $checkout, $trans_id, $amount, $status];

    if (insert($query, $values, 'iisssis')) {
        echo json_encode(['status' => 'success', 'trans_id' => $trans_id]);
    } else {
        echo json_encode(['status' => 'db_error']);
    }

    exit;
}


if(isset($_POST['check_availability']))
{
    $frm_data = filteration($_POST);
    $status = "";
    $result = "";

    //check-in and check-out validations

    $today_date = new DateTime(date('Y-m-d'));
    $checkin_date = new DateTime($frm_data['check_in']);
    $checkout_date = new DateTime($frm_data['check_out']);

    if($checkin_date == $checkout_date){
        $status = 'check_in_out_equal';
        $result = json_encode(["status"=>$status]);
    }
    else if($checkout_date < $checkin_date){
        $status = 'check_out_earlier';
        $result = json_encode(["status"=>$status]);
    }
    else if($checkin_date < $today_date){
        $status = 'check_in_earlier';
        $result = json_encode(["status"=>$status]);
    }

    //check booking availability if status is blank else return the error

    if($status!=''){
        echo $result;
    }
    else{
        session_start();

        $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order` 
                     WHERE `booking_status` = ? AND `room_id` = ? AND  
                      `check_out` > ? AND `check_out` < ?";

        $values = ['booked',$_SESSION['room']['id'], $frm_data['check_in'], $frm_data['check_out']];
        $tb_fetch = mysqli_fetch_assoc((select($tb_query, $values, 'siss')));

        $rq_result = select("SELECT `quantity` FROM `rooms` WHERE `id` = ?",[$_SESSION['room']['id']],'i');
        $rq_fetch = mysqli_fetch_assoc($rq_result);

        if(($rq_fetch['quantity']-$tb_fetch['total_bookings'])==0){
            $status = 'unavailable';
            $result = json_encode(["status"=>$status]);
            echo $result;
            exit;
        }

        // Check if price is set
        if (!isset($_SESSION['room']['price'])) {
            echo json_encode(['status' => 'error', 'msg' => 'Room price not set in session.']);
            exit;
        }

        $count_days = date_diff($checkin_date,$checkout_date)->days;
        $payment = $_SESSION['room']['price'] * $count_days;

        $_SESSION['room']['payment'] = $payment;
        $_SESSION['room']['available'] = true;
        $_SESSION['room']['checkin'] = $frm_data['check_in'];
        $_SESSION['room']['checkout'] = $frm_data['check_out'];

        $result = json_encode(["status"=>'available', "days"=>$count_days, "payment"=>$payment]);
        echo $result;
    }
    exit;
}

// If nothing matched, always return JSON
echo json_encode(['status' => 'invalid']);
exit;

?>