<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();


if(isset($_POST['booking_analytics'])){
  $frm_data = filteration($_POST);

  $condition="";

  if($frm_data['period']==1){
    $condition="WHERE datentime BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
  }
  else if($frm_data['period']==2){
    $condition="WHERE datentime BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
  }
  else if($frm_data['period']==3){
    $condition="WHERE datentime BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
  }

  $result = mysqli_fetch_assoc(mysqli_query($con,"SELECT 
  COUNT(CASE WHEN booking_status!='pending' THEN 1 END) AS `total_bookings`, 
  SUM(CASE WHEN booking_status!='pending' THEN `trans_amount` END) AS `total_amount`, 

  COUNT(CASE WHEN booking_status='booked' THEN 1 END) AS `active_bookings`, 
  SUM(CASE WHEN booking_status='booked' THEN `trans_amount` END) AS `active_amount`, 

  COUNT(CASE WHEN booking_status='cancelled' AND refund=1 then 1 END) AS `cancelled_bookings`, 
  SUM(CASE WHEN booking_status='cancelled' THEN `trans_amount` END) AS `cancelled_amount` FROM `booking_order`"));

  $output = json_encode($result);

  echo $output;
}

if(isset($_POST['user_analytics'])){
  $frm_data = filteration($_POST);

  $condition="";

  if($frm_data['period']==1){
    $condition="WHERE datentime BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
  }
  else if($frm_data['period']==2){
    $condition="WHERE datentime BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
  }
  else if($frm_data['period']==3){
    $condition="WHERE datentime BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
  }

  $total_queries = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(id) AS `count` FROM `user_queries` $condition"));

  $total_new_reg = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(id) AS `count` FROM `user_cred` $condition"));

  $output = ['total_queries' => $total_queries['count'], 'total_new_reg' => $total_new_reg['count']];

  $output = json_encode($output);

  echo $output;
}

?>
