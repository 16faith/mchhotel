<?php

require('admin/inc/db_config.php');
require('admin/inc/essentials.php');

date_default_timezone_set("Asia/Manila");

session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
    redirect('index.php');
}

if(isset($_POST['pay_now'])){
    $ORDER_ID = 'ORD_'.$_SESSION['uId'].random_int(11111,9999999);
    $CUST_ID = $_SESSION['uId'];
    $TXN_AMOUNT =$_SESSION['room']['payment'];

    $paramList = array();
    $paramList["ORDER_ID"] = $ORDER_ID;
    $paramList["CUST_ID"] = $CUST_ID;
    $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;

    $frm_data = filteration($_POST);
    $query1 = "INSERT INTO `booking_order`(`user_id`,`user_id`,`user_id`,`user_id`) VALUES (?,?,?,?)";
    insert($query1,[$CUST_ID,$_SESSION['room']['id'],$frm_data['checkin'],$frm_data['checkout'],$ORDER_ID],'issss');

    $booking_id = mysqli_insert_id($con);
    $query2 = "INSERT INTO `booking_details`(`booking_id`,`room_name`,`price`,`total_pay`,`user_name`,`phonenum`,`address`) VALUES(?,?,?,?,?,?,?)";
    insert($query2,[$booking_id,$_SESSION['room']['name'],$_SESSION['room']['price'],$TXN_AMOUNT,$frm_data['name'],$frm_data['phonenum'],$frm_data['address']],'issssss');
}
?>

<html>
    <head>
        <title>Processing</title>
    </head>
    <body>
        <h1>Please do not refresh page</h1>
        <form method="post" action="#">
            <?php
            foreach($paramList as $name => $value){
                echo '<input type="hidden" name=""' . $name .'"value="' .$value .'">';
            } 
            ?>
            <input type="hidden" name="check" value="<?php echo $checkSum ?>">
        </form>

        <script type="text/javascript">
            document.f1.submit();
        </script>
    </body>
</html>