<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();


if(isset($_POST['get_bookings']) || isset($_POST['search_rooms'])){
    $where = "WHERE bo.booking_status IN ('booked', 'refunded')";
    $values = [];
    $types = '';

    // Pagination setup
    $limit = 4;
    $frm_data = filteration($_POST);
    $page = isset($frm_data['page']) && is_numeric($frm_data['page']) && $frm_data['page'] > 0 ? (int)$frm_data['page'] : 1;
    $start = ($page - 1) * $limit;

    if(isset($_POST['search_rooms']) && !empty($frm_data['name'])) {
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

    // Count total records for pagination
    $count_query = "SELECT COUNT(*) as total 
                    FROM booking_order bo
                    JOIN rooms r ON bo.room_id = r.id
                    JOIN user_cred u ON bo.user_id = u.id
                    $where";
    if(!empty($values)) {
        $count_res = select($count_query, $values, $types);
        $total_rows = mysqli_fetch_assoc($count_res)['total'];
    } else {
        $count_res = mysqli_query($con, $count_query);
        $total_rows = mysqli_fetch_assoc($count_res)['total'];
    }
    $total_pages = ceil($total_rows / $limit);

    $query = "SELECT bo.*, r.name AS room_name, r.price, u.name AS user_name, u.email, u.phonenum 
              FROM booking_order bo
              JOIN rooms r ON bo.room_id = r.id
              JOIN user_cred u ON bo.user_id = u.id
              $where
              ORDER BY bo.datentime DESC
              LIMIT $start, $limit";

    if(!empty($values)) {
        $limit_res = select($query, $values, $types);
    } else {
        $limit_res = mysqli_query($con, $query);
    }
    $i=1 + $start;
    $table_data = "";

    if(mysqli_num_rows($limit_res) == 0){
        $output = json_encode(["table_data" => "<b>No records found!</b>", "pagination" => ""]);
        echo $output;
        exit;
    }

    while($data = mysqli_fetch_assoc($limit_res)){
        $date = date("d-m-Y",strtotime($data['datentime']));
        $checkin = date("d-m-Y",strtotime($data['check_in']));
        $checkout = date("d-m-Y",strtotime($data['check_out']));

        $status_bg = ($data['booking_status'] == 'booked') ? 'bg-success' : (($data['booking_status'] == 'cancelled') ? 'bg-danger' : 'bg-warning text-dark');

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
              <span class='badge $status_bg'>
                {$data['booking_status']}
              </span>
            </td>
            <td class='text-center'>
              <button type='button' class='btn btn-outline-success btn-sm fw-bold shadow-none'><i class='bi bi-file-earmark-arrow-down-fill'></i></button>
              <button class='btn btn-success btn-sm' onclick='checkout_booking(\"{$data['booking_id']}\")'>Checkout</button>

            </td>
          </tr>
        ";
        $i++;
    }

    // Pagination HTML
    $pagination = "";
    if($total_pages > 1){
        $pagination .= ($page > 1) ? "<li class='page-item'><button class='page-link' onclick='change_page(".($page-1).")'>Prev</button></li>" : "";
        for($p=1; $p<=$total_pages; $p++){
            $active = ($p == $page) ? "active" : "";
            $pagination .= "<li class='page-item $active'><button class='page-link' onclick='change_page($p)'>$p</button></li>";
        }
        $pagination .= ($page < $total_pages) ? "<li class='page-item'><button class='page-link' onclick='change_page(".($page+1).")'>Next</button></li>" : "";
    }

    $output = json_encode(["table_data"=>$table_data, "pagination" => $pagination]);
    echo $output;
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

if (isset($_POST['checkout_booking'])) {
    $booking_id = filter_var($_POST['booking_id'], FILTER_SANITIZE_NUMBER_INT);

    // Get the room number for this booking
    $get_room = mysqli_query($con, "SELECT room_no FROM booking_order WHERE booking_id = '$booking_id'");
    $room = mysqli_fetch_assoc($get_room);

    // Only update if booking exists
    if ($room && isset($room['room_no'])) {

        // Set booking status to completed
        $update_booking = mysqli_query($con, "UPDATE booking_order SET booking_status = 'completed' WHERE booking_id = '$booking_id'");

        // Update room status to available
        $room_no = $room['room_no'];
        if (!empty($room_no)) {
            mysqli_query($con, "UPDATE room_no SET status = 'available' WHERE room_number = '$room_no'");
        }

        echo ($update_booking) ? "1" : "0";
    } else {
        echo "0"; // Booking or room not found
    }

    exit;
}

if (isset($_POST['refund_booking'])) {
    $booking_id = filter_var($_POST['booking_id'], FILTER_SANITIZE_NUMBER_INT);

    // Set booking_status to 'refunded'
    $update = mysqli_query($con, "UPDATE booking_order SET booking_status = 'refunded' WHERE booking_id = '$booking_id'");

    echo ($update) ? '1' : '0';
    exit;
}

?>
