<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> - BOOKINGS</title>
</head>
<body class="bg-light">
    
    <?php 
        require('inc/header.php'); 
        if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
            redirect('index.php');
        }
    ?>  

    <div class="container">
        <div class="row">
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">BOOKINGS</h2>
                <div style="font-size: 15px;">
                    <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                    <span class="text-secondary">></span>
                    <a href="#" class="text-secondary text-decoration-none">BOOKINGS</a>
                </div>
            </div>

            <?php
              $query = "SELECT bo.*, r.name AS room_name, r.price, u.name AS user_name, u.email, u.phonenum 
                FROM booking_order bo
                JOIN rooms r ON bo.room_id = r.id
                JOIN user_cred u ON bo.user_id = u.id
                WHERE bo.user_id = ?
                ORDER BY bo.datentime DESC";

              $result =select($query,[$_SESSION['uId']],'i');

              while($data = mysqli_fetch_assoc($result)) {
                $date = date("d-m-Y",strtotime($data['datentime']));
                $checkin = date("d-m-Y",strtotime($data['check_in']));
                $checkout = date("d-m-Y",strtotime($data['check_out']));

                $status_bg="";
                $btn="";

                if($data['booking_status'] == 'booked')
                {
                    $status_bg = "bg-success";
                    if($data['arrival'] == 0){
                        $btn = "<a href='generate_pdf.php?gen_pdf&id={$data['booking_id']}' class='btn btn-dark btn-sm shadow-none'>Download PDF</a>
                        <button type='button' class='btn btn-dark btn-sm shadow-none mt-1'>Rate & Review</button>";
                    } else {
                        $btn = "<button type='button' onclick='cancel_booking({$data['booking_id']})' class='btn btn-danger btn-sm shadow-none'>Cancel</button>";
                    }
                }
                else if($data['booking_status'] == 'pending')
                {
                    $status_bg = "bg-warning";
                    $btn = "<button type='button' onclick='cancel_booking({$data['booking_id']})' class='btn btn-danger btn-sm shadow-none'>Cancel</button>";
                }
                else if($data['booking_status'] == 'cancelled')
                {
                    $status_bg = "bg-danger";
                    if($data['refund']==0){
                        $btn = "<span class='badge bg-primary'>Refund in process!</span>";
                    } else{
                        $btn = "<a href='generate_pdf.php?gen_pdf&id={$data['booking_id']}' class='btn btn-dark btn-sm shadow-none'>Download PDF</a>";
                    }
                }
                else{
                    $status_bg = "bg-warning";
                    $btn = "<a href='generate_pdf.php?gen_pdf&id={$data['booking_id']}' class='btn btn-dark btn-sm shadow-none'>Download PDF</a>";
                }

                echo<<<bookings

                    <div class="col-md-4 px-4 mb-4">
                        <div class="bg-white p-3 rounded shadow-sm">
                            <h5 class="fw-bold">$data[room_name]</h5>
                            <p>$$data[price] per night </p>
                            <p>
                                <b>Check-in:</b> $checkin<br>
                                <b>Check-out:</b> $checkout
                            </p>
                            <p>
                                <b>Amount:</b> $$data[price]<br>
                                <b>Order ID:</b> $data[booking_id]<br>
                                <b>Date:</b> $date
                            </p>
                            <p>
                                <span class='badge $status_bg'>$data[booking_status]</span>
                            </p>
                            <p> $btn </p>
                        </div>

                    </div>

                bookings;
              }
            ?>
            
        </div>
    </div>
    
 
    <?php require('inc/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
        function cancel_booking(id) {
            if(confirm("Are you sure you want to cancel this booking?")) {
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/cancel_booking.php", true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if(this.responseText == 1) {
                        alert('Booking cancelled successfully!');
                        window.location.href="bookings.php?cancel_status=true";
                    } else {
                        alert('danger',"Failed to cancel booking. Please try again.");
                    }
                }

                xhr.send('cancel_booking=1&booking_id='+id);
            }
        }
    </script>

</body>
</html>