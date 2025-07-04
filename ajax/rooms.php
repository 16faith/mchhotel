<?php 
require('../admin/inc/db_config.php');
require('../admin/inc/essentials.php');

date_default_timezone_set("Asia/Manila");
session_start();

if(isset($_GET['fetch_rooms'])){

    //check availability data 
    $check_avail = json_decode($_GET['check_avail'],true);

    //checkin and checkout filter validations
    if($check_avail['checkin'] != '' || $check_avail['checkout'] != ''){
        $today_date = new DateTime(date('Y-m-d'));
        $checkin_date = new DateTime($check_avail['checkin']);
        $checkout_date = new DateTime($check_avail['checkout']);

        if($checkin_date == $checkout_date){
           echo"<h3 class='text-center text-danger mt-5'>Invalid dates entered!</h3>";
           exit();
        }
        else if($checkout_date < $checkin_date){
            echo"<h3 class='text-center text-danger mt-5'>Invalid dates entered!</h3>";
           exit();
        }
        else if($checkin_date < $today_date){
            echo"<h3 class='text-center text-danger mt-5'>Invalid dates entered!</h3>";
           exit();
        }
    }


    //count  no of rooms
    $count_rooms = 0;
    $output = "";

    //fetching settings table to check if website is in shutdown or not
    $settings_q = "SELECT * FROM `settings` WHERE `id` = 1";
    $settings_r = mysqli_fetch_assoc(mysqli_query($con, $settings_q));

    //query for room cards
    $room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=?", [1,0], 'ii');

        while($room_data = mysqli_fetch_assoc($room_res))
        {
            //check availability filter
            if($check_avail['checkin'] != '' || $check_avail['checkout'] != ''){
                $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order` 
                     WHERE `booking_status` = ? AND `room_id` = ? AND  
                      `check_out` > ? AND `check_out` < ?";

                $values = ['booked',$room_data['id'], $check_avail['checkin'], $check_avail['checkout']];
                $tb_fetch = mysqli_fetch_assoc((select($tb_query, $values, 'siss')));

                if(($room_data['quantity']-$tb_fetch['total_bookings'])==0){
                    continue; // Skip this room if no availability
                }
            }

         // Get features for this room
            $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f INNER JOIN `room_features` rfea ON f.id = rfea.features_id WHERE rfea.room_id = '{$room_data['id']}'");
            $features = [];
            while($fea_row = mysqli_fetch_assoc($fea_q)){
                $features[] = "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'> " . htmlspecialchars($fea_row['name']) . " </span>";
            }
            $features_data = implode(' ', $features);

            // Get facilities for this room
            $fac_q = mysqli_query($con, "SELECT fa.name FROM `facilities` fa INNER JOIN `room_facilities` rfac ON fa.id = rfac.facilities_id WHERE rfac.room_id = '{$room_data['id']}'");
            $facilities_data = "";
            while($fac_row = mysqli_fetch_assoc($fac_q)){
                $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'> $fac_row[name] </span>";
            }

            // Get thumbnail of image
            $room_thumb = ROOMS_IMG_PATH."thumbnail.jpg";
            $thumb_q = mysqli_query($con, "SELECT * FROM `room_images` WHERE `room_id` = '$room_data[id]' AND `thumb`='1' ");

            if(mysqli_num_rows($thumb_q)>0){
                $thumb_res = mysqli_fetch_assoc($thumb_q);
                $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];
            }

            $book_btn = "";

            if(!$settings_r['shutdown']){
                $login=0;
                if(isset($_SESSION['login']) && $_SESSION['login']==true){
                    $login=1;
                }
                        
                $book_btn ="<button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm w-100 text-white custom-bg shadow-none mb-2'>Book Now</button>";
            }

            //print room card

            $output .="
                 <div class='card mb-4 border-0 shadow'>
                    <div class='row g-0 p-3 align-items-center'>
                        <div class='col-md-5 mb-lg-0 mb-md-0 mb-3'>
                            <img src='$room_thumb' class='img-fluid rounded start'>
                        </div>
                        <div class='col-md-5 px-lg-3 px-md-3 px-0'>
                            <h5 class='mb-3'>$room_data[price]</h5>
                            <div class='features mb-3'>
                                <h6 class='mb-1'>Features</h6>
                                $features_data
                            </div>
                            <div class='facilities mb-3'>
                                <h6 class='mb-1'>Facilities</h6>
                                $facilities_data
                            </div>
                            <div class='guests'>
                                <h6 class='mb-1'>Guests</h6>
                                <span class='badge rounded-pill bg-light text-dark text-wrap'>
                                    $room_data[adult] Adults
                                </span>
                                <span class='badge rounded-pill bg-light text-dark text-wrap'>
                                    $room_data[children] Children
                                </span>
                            </div>                            
                        </div>
                        <div class='col-md-2 mt-lg-0 mt-md-0 mt-4 text-center'>
                            <h6 class='mb-4'>$$room_data[price] per night</h6>
                            $book_btn
                            <a href='rooms_details.php?id=$room_data[id]' class='btn btn-sm w-100 btn-outline-dark shadow-none'>More Details</a>
                        </div>
                    </div>
                </div>
            ";

            $count_rooms++;

        }

        if($count_rooms>0){
            echo $output;
        }
        else{
            echo "<h3 class='text-center text-danger mt-5'>No Rooms to Show</h3>";
        }
}



?>