<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> - CONFIRM BOOKING</title>
</head>
<body class="bg-light">
    
    <?php require('inc/header.php'); ?>

    <?php 

        /*
        check room id from url is present / not
        shutdown mode is active / not
        useris logged in or not
         */
        if(!isset($_GET['id']) || $settings_r['shutdown']==true){
            redirect('rooms.php');
        }
        else if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
            redirect('rooms.php');
        }

        // filter and get room and user data       

        $data = filteration($_GET);

        $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?",[$data['id'],1,0],'iii');

        if(mysqli_num_rows($room_res)==0){
            redirect('rooms.php');
        }

        $room_data = mysqli_fetch_assoc($room_res);

        $_SESSION['room'] = [
            "id" => $room_data['id'],
            "name" => $room_data['name'],
            "price" => $room_data['price'],
            "payment" => null,
            "available" => false,
        ];

        $user_res = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION['uId']],"i");
        $user_data = mysqli_fetch_assoc($user_res);
    ?>   

    <div class="container">
        <div class="row">
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">CONFIRM BOOKING</h2>
                <div style="font-size: 15px;">
                    <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                    <span class="text-secondary">></span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
                    <span class="text-secondary">></span>
                    <a href="#" class="text-secondary text-decoration-none">CONFIRM</a>
                </div>
            </div>

            <div class="col-lg-7 col-md-12 px-4">
                <?php
                    $room_thumb = ROOMS_IMG_PATH."thumbnail.jpg";
                    $thumb_q = mysqli_query($con, "SELECT * FROM `room_images` WHERE `room_id` = '$room_data[id]' AND `thumb`='1'");

                    if(mysqli_num_rows($thumb_q)>0){
                       $thumb_res = mysqli_fetch_assoc($thumb_q);
                       $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];
                    }

                        echo<<<data
                            <div class='card p-3 shadow-sm rounded'>
                                <img src='$room_thumb' class='img-fluid rounded mb-3'>
                                <h5>$room_data[name]</h5>
                                <h6>$room_data[price] per night</h6>
                            </div>
                        data;
                    
                ?>
            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <form action="pay_now.php" id="booking_form" name="booking_form">
                            <h6 class="mb-3">BOOKING DETAILS</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name</label>
                                    <input name="name" type="text" value="<?php echo $user_data['name'] ?>" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone No.</label>
                                    <input name="phonenum" type="number" value="<?php echo $user_data['phonenum'] ?>" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Address</label>
                                    <input name="address" type="text" value="<?php echo $user_data['address'] ?>" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Check-in</label>
                                    <input name="checkin" onchange="check_availability()" type="date" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Check-out</label>
                                    <input name="checkout" onchange="check_availability()" type="date" class="form-control shadow-none" required>
                                </div>
                                <div class="col-12">
                                    <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <h6 class="mb-3 text-danger" id="pay_info">Provide check-in & check-out date!</h6>
                                    <div id="fake-payment-container" class="mb-1">
                                        <button id="fake_pay_btn" class="btn w-100 text-white custom-bg shadow-none mb-1">Pay Now</button>
                                    </div>
                                        
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
 
    <?php require('inc/footer.php'); ?>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <script>
        let booking_form = document.getElementById('booking_form');
        let info_loader = document.getElementById('info_loader');
        let pay_info = document.getElementById('pay_info');
        let fake_pay_btn = document.getElementById('fake_pay_btn');

        function check_availability(){
            let checkin_val = booking_form.elements['checkin'].value;
            let checkout_val = booking_form.elements['checkout'].value;

            if(checkin_val!='' && checkout_val!=''){

                pay_info.classList.add('d-none');
                pay_info.classList.replace('text-dark','text-danger');
                info_loader.classList.remove('d-none');

                let data = new FormData();

                data.append('check_availability','');
                data.append('check_in',checkin_val);
                data.append('check_out',checkout_val);

                let xhr = new XMLHttpRequest();
                    xhr.open("POST","ajax/confirm_booking.php",true);

                    xhr.onload = function(){
                        let data = JSON.parse(this.responseText);

                        if(data.status == 'check_in_out_equal'){
                            pay_info.innerText = "You cannot check-out on the same day!";
                        }
                        else if(data.status == 'check_out_earlier'){
                            pay_info.innerText = "Check-out date is earlier than check-in date!";
                        }
                        else if(data.status == 'check_in_earlier'){
                            pay_info.innerText = "Check-in date is earlier than today's date!";
                        }
                        else if(data.status == 'unavailable'){
                            pay_info.innerText = "Room is not available for this check-iin date!";
                        }
                        else{
                            pay_info.innerHTML = "No. of Days: "+data.days+"<br>Total Amount to Pay: $"+data.payment;
                            pay_info.classList.replace('text-danger','text-dark');
                        }

                        pay_info.classList.remove('d-none');
                        info_loader.classList.add('d-none');
                    }

                    xhr.send(data);
            }
        }

        // Fake payment handler
        fake_pay_btn.onclick = function(e) {
            e.preventDefault();
                let name = booking_form.elements['name'].value.trim();
                let phonenum = booking_form.elements['phonenum'].value.trim();
                let address = booking_form.elements['address'].value.trim();
                let checkin = booking_form.elements['checkin'].value.trim();
                let checkout = booking_form.elements['checkout'].value.trim();

                if(!name || !phonenum || !address || !checkin || !checkout) {
                    alert('danger','Please fill out all booking details before proceeding.');
                    return;
                }
                alert('success','All fields filled!');

            // Simulate payment and booking confirmation
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/confirm_booking.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                let data = JSON.parse(this.responseText);
                if(data.status === 'success'){
                    alert('success','Payment successful! Booking confirmed.');
                    setTimeout(function() {
                        window.location = 'my_bookings.php';
                    }, 1500); // 1.5 seconds
                } else {
                    alert('danger','Booking failed!');
                }
            };
            xhr.send("fake_payment=1");
        };

    </script>

</body>
</html>