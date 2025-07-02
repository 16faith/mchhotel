<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

if(isset($_POST['get_bookings']) || isset($_POST['search_rooms'])){
    $where = "WHERE bo.booking_status ='pending'";
    $values = [];
    $types = '';

    if(isset($_POST['search_rooms'])) {
        $frm_data = filteration($_POST);
        if (!empty($frm_data['name'])) {
            $where .= " AND (
                bo.booking_id LIKE ? OR 
                u.name LIKE ? OR 
                r.name LIKE ? OR 
                u.phonenum LIKE ?
            )";
            $search = "%{$frm_data['name']}%";
            $values = [$search, $search, $search, $search];
            $types = 'ssss';
        }
    }

    $query = "SELECT bo.*, r.name AS room_name, r.price, u.name AS user_name, u.email, u.phonenum 
          FROM booking_order bo
          LEFT JOIN rooms r ON bo.room_id = r.id
          LEFT JOIN user_cred u ON bo.user_id = u.id
          $where
          ORDER BY bo.datentime DESC";

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
       error_log("Assign room: booking_id = " . $data['booking_id']);
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
            <b>Price:</b> ₱{$data['price']}
          </td>
          <td>
            <b>Check-in:</b> $checkin<br>
            <b>Check-out:</b> $checkout<br>
            <b>Paid:</b> ₱{$data['trans_amount']}<br>
            <b>Date:</b>{$data['datentime']}<br>
          </td>
          <td>
            <button type='button' class='btn btn-sm custom-bg text-white shadow-none'
                  data-bs-toggle='modal'
                  data-bs-target='#assign-room' data-booking-id=" . $data['booking_id'] . ">
              <i class='bi bi-check2-square me-1'></i>Assign Room
          </button> <br>
            <button class='mt-2 btn btn-outline-danger btn-sm fw-bold shadow-none' onclick='cancel_booking({$data['booking_id']})', 'cancelled')'><i class='bi bi-trash me-1'></i>Cancel Booking</button>
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


if(isset($_POST['cancel_booking'])){
  $frm_data = filteration($_POST);

  // Get the room number for this booking
  $get_room = mysqli_query($con, "SELECT room_no FROM booking_order WHERE booking_id = '{$frm_data['booking_id']}'");
  $room = mysqli_fetch_assoc($get_room);

  // Set booking status to cancelled
  $query = "UPDATE booking_order SET booking_status = 'cancelled' WHERE booking_id = ?";
  $values = [$frm_data['booking_id']];
  $res = update($query, $values, 'i');

  // Set room status to Available if a room was assigned
  if($room && $room['room_no']) {
    mysqli_query($con, "UPDATE room_no SET status = 'Available' WHERE room_number = '{$room['room_no']}'");
  }

  echo $res ? "1" : "0";
  exit;
}
?>
