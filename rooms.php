<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCH Hotel - ROOMS</title>
    <?php require('inc/links.php'); ?>
    
</head>
<body class="bg-light">
    
    <?php require('inc/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">OUR ROOMS</h2>
        <div class="h-line bg-dark"></div>
    </div>

    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <h4 class="mt-2">FILTERS</h4>
                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
                            <!-- check availability filter -->
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                    <span>CHECK AVAILABILITY</span>
                                    <button id="check_avail_btn" onclick="check_avail_clear()" class="btn shadow-none btn-sm text-secondary d-none">Reset</button>
                                </h5>
                                <label class="form-label">Check-in</label>
                                <input type="date" class="form-control shadow-none mb-3" id="checkin" onchange="check_avail_filter()">
                                <label class="form-label">Check-out</label>
                                <input type="date" class="form-control shadow-none" id="checkout" onchange="check_avail_filter()">
                            </div>

                            <!-- facilities filter -->
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="mb-3" style="font-size: 18px;">FACILITIES</h5>
                                <div class="mb-2">
                                    <input type="checkbox" id="f1" class="form-check-input shadow-none me-1">
                                <label class="form-check-label" for="f1">Facility one</label>
                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" id="f2" class="form-check-input shadow-none me-1">
                                <label class="form-check-label" for="f2">Facility two</label>
                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" id="f3" class="form-check-input shadow-none me-1">
                                <label class="form-check-label" for="f3">Facility three</label>
                                </div>
                            </div>

                            <!-- guest filter -->
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                    <span>GUESTS</span>
                                    <button id="guests_btn" class="btn shadow-none btn-sm text-secondary d-none">Reset</button>
                                </h5>
                                <div class="d-flex">
                                    <div class="me-3">
                                        <label class="form-label">Adults</label>
                                        <input type="number" min="1" id="adults" class="form-control shadow-none">
                                    </div>
                                    <div>
                                        <label class="form-label">Children</label>
                                        <input type="number" min="1" id="children" class="form-control shadow-none">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </nav>                
            </div>

            <div class="col-lg-9 col-md-12 px-4" id="rooms-data">
               
            </div>
            
        </div>
    </div>
    
    <script>
        let rooms_data = document.getElementById('rooms-data');

        let checkin = document.getElementById('checkin');
        let checkout = document.getElementById('checkout');
        let check_avail_btn = document.getElementById('check_avail_btn');
        
        function fetch_rooms(){
            let check_avail = JSON.stringify({
                checkin: checkin.value,
                checkout: checkout.value
            });

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms.php?fetch_rooms&check_avail="+check_avail, true);

            xhr.onprogress = function(){
                rooms_data.innerHTML = `
                    <div class="spinner-border text-info mb-3 d-block mx-auto" id="iloader" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                `;
            }

            xhr.onload = function(){
                rooms_data.innerHTML = this.responseText;
            }

            xhr.send();
        }

        function check_avail_filter(){
            if(checkin.value!='' && checkout.value!=''){
                fetch_rooms();
                check_avail_btn.classList.remove('d-none');
            }
        }

        function check_avail_clear(){
            checkin.value != '';
            checkout.value != '';
            check_avail_btn.classList.add('d-none');
            fetch_rooms();

            
        }

        fetch_rooms();
    </script>
 
    <?php require('inc/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>