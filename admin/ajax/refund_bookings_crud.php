<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

if(isset($_POST['get_bookings']) || isset($_POST['search_rooms'])){
    $where = "WHERE bo.booking_status = 'cancelled'";
    $values = [];
    $types = '';

    if(isset($_POST['search_rooms'])) {
        $frm_data = filteration($_POST);
        if (!empty($frm_data['name'])) {
            $where = "WHERE 
            bo.booking_id LIKE ? OR 
            u.name LIKE ? OR 
            r.name LIKE ? OR 
            bo.trans_amount LIKE ? OR 
            u.phonenum LIKE ?";
        $search = "%{$frm_data['name']}%";
        $values = [$search, $search, $search, $search, $search];
        $types = 'sssss';
                }
    }

    $query = "SELECT bo.*, r.name AS room_name, r.price, u.name AS user_name, u.email, u.phonenum 
              FROM booking_order bo
              JOIN rooms r ON bo.room_id = r.id
              JOIN user_cred u ON bo.user_id = u.id
              $where
              ORDER BY bo.datentime ASC";

    if(!empty($values)) {
        $res = select($query, $values, $types);
    } else {
        $res = mysqli_query($con, $query);
    }

    $i=1;
    $table_data = "";

    if(mysqli_num_rows($res) == 0){
        echo "<b>No records found!</b>";
        exit;
    }

    while($data = mysqli_fetch_assoc($res)){
        $date = date("d-m-Y",strtotime($data['datentime']));
        $checkin = date("d-m-Y",strtotime($data['check_in']));
        $checkout = date("d-m-Y",strtotime($data['check_out']));

        $table_data .="
        <tr>
          <td>$i</td>
          <td>
            <span class ='badge bg-primary'>
              <b>Order ID:</b> {$data['booking_id']}
            </span><br>
            <b>Name:</b> {$data['user_name']}<br>
            <b>Phone:</b> {$data['phonenum']}
          </td>
          <td>
            <b>Room:</b> {$data['room_name']}<br>
            <b>Check-in:</b> $checkin<br>
            <b>Check-out:</b> $checkout<br>
            <b>Date:</b>{$data['datentime']}<br>
          </td>
          <td>
            ₱{$data['trans_amount']}  
          </td>
          <td>
            <button class='btn btn-outline-success btn-sm fw-bold shadow-none' onclick='refund_booking({$data['booking_id']})'><i class='bi bi-cash-stack me-1'></i>Refund</button>
          </td>
        </tr>
        ";
        $i++;
    }
    echo $table_data;
    exit;
}



if(isset($_POST['get_rooms'])){
  $query = "SELECT * FROM rooms WHERE status = 1";
  $res = select($query, [], '');
  $i=1;
  $table_data = "";

  while($data = mysqli_fetch_assoc($res)){
    $table_data .="
      <tr>
        <td>$i</td>
        <td>{$data['name']}</td>
        <td>{$data['price']}</td>
        <td>{$data['capacity']}</td>
        <td>{$data['description']}</td>
        <td>
          <button class='btn btn-sm btn-outline-danger shadow-none' onclick='remove_room({$data['id']})'><i class='bi bi-trash'></i></button>
        </td>
      </tr>
    ";
    $i++;
  }
  echo $table_data;
  exit;
}
if (isset($_POST['refund_booking'])) {
    $booking_id = filter_var($_POST['booking_id'], FILTER_SANITIZE_NUMBER_INT);

    // Update booking_status to refunded
    $update = mysqli_query($con, "UPDATE booking_order SET booking_status = 'refunded' WHERE booking_id = '$booking_id'");

    echo ($update) ? "1" : "0";
    exit;
}
?>