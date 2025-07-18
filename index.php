<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <?php require('inc/links.php'); ?>
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
    <title><?php echo $settings_r['site_title'] ?> - HOME</title>
    <style>
        .availability-form{
            margin-top: -75px;
            z-index: 2;
            position: relative;
        }

        @media screen and (max-width: 575px)  {
            .availability-form{
                margin: 25px;
                padding: 0 35px;
            }
        }

         .swiper-button-next,
        .swiper-button-prev {
            color: #000 !important;
            background: rgba(255,255,255,0.7);
            border-radius: 50%;
            border: 1px solid #000;
            width: 40px;
            height: 40px;
            top: 40%;
        }
        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 20px;
            font-weight: bold;
        }
        .swiper-pagination-bullet {
            background: #000 !important;
            opacity: 1;
        }
        .swiper-pagination-bullet-active {
            background: #000 !important;
            opacity: 1;
        }
    </style>
</head>
<body class="bg-light">
    
    <?php require('inc/header.php'); ?>

    <!-- carousel -->
    <div class="container-fluid p-0 m-0">
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                <?php 
                    $res = selectAll('carousel');

                    while($row = mysqli_fetch_assoc($res)){
                        $path = CAROUSEL_IMG_PATH;
                        echo <<<data
                         <div class="swiper-slide">
                            <img src="$path$row[image]" class="w-100 d-block"/>
                        </div>             
                        data;
                    }
                ?>
            </div>
        </div>
    </div>
        <div class="bg-overlay"></div>
        <div class="content">
            <!-- check availability form -->
            <div class="container availability-form">
                <div class="row">
                    <div class="col-lg-12 bg-dark text-white shadow p-4 rounded">
                        <h5 class="mb-4">Check Booking Availability</h5>
                        <form>
                            <div class="row align-items-end">
                                <div class="col-lg-3 mb-3">
                                        <label class="form-label text-white" style="font-weight: 500;">Check-in</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark text-white border-secondary">
                                            <i class="bi bi-calendar-date"></i>
                                            </span>
                                            <input type="date" class="form-control shadow-none bg-dark text-white border-secondary">
                                        </div>   
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label text-white" style="font-weight: 500;">Check-out</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark text-white border-secondary">
                                            <i class="bi bi-calendar-date"></i>
                                            </span>
                                            <input type="date" class="form-control shadow-none bg-dark text-white border-secondary">
                                        </div>
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label text-white" style="font-weight: 500;">Adult</label>
                                    <select class="form-select shadow-none bg-dark text-white border-secondary">
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 mb-3">
                                    <label class="form-label text-white" style="font-weight: 500;">Children</label>
                                    <select class="form-select shadow-none bg-dark text-white border-secondary">
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="col-lg-1 mb-lg-3 mt-2">
                                    <button type="submit" class="btn text-white shadow-none custom-bg">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>         

            <!-- our rooms -->
            <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR ROOMS</h2>
            <div class="container">
                <div class="swiper carousel-rooms">
                    <div class="swiper-wrapper">
                        <?php 
                                $room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC LIMIT 4", [1,0], 'ii');

                                while($room_data = mysqli_fetch_assoc($room_res))
                                {
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

                                    if(!$settings_r['shutdown']){
                                        $login=0;
                                        if(isset($_SESSION['login']) && $_SESSION['login']==true){
                                            $login=1;
                                        }
                                        $book_btn = "<button type='button' onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-lg w-100 text-white custom-bg shadow-none mb-2'>Book Now</button> <br>";
                                    }
                                    else {
                                        $book_btn = '';
                                    }
                                    
                                    //print room card

                                echo<<<data
                                    <div class="swiper-slide">
                                        <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                                            <img src="$room_thumb" class="card-img-top" alt="">
                                            <div class="card-body">
                                                <h5>$room_data[name]</h5>
                                                <h6 class="mb-3">$$room_data[price]</h6>
                                                <div class="features mb-3">
                                                    <h6 class="mb-1">Features</h6>
                                                    $features_data
                                                </div>
                                                <div class="facilities mb-3">
                                                    <h6 class="mb-1">Facilities</h6>
                                                    $facilities_data
                                                </div>
                                                <div class="guests mb-3">
                                                    <h6 class="mb-1">Guests</h6>
                                                    <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                        $room_data[adult] Adults
                                                    </span>
                                                    <span class="badge rounded-pill bg-light text-dark text-wrap">
                                                        $room_data[children] Children
                                                    </span>
                                                </div>
                                                <div class="rating mb-3">
                                                    <h6 class="mb-1">Rating</h6>
                                                    <span class="badge rounded-pill bg-light">
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>   
                                                    </span>
                                                </div>
                                                <div class="justify-content-center">
                                                    $book_btn
                                                    <a href="rooms_details.php?id=$room_data[id]" class="btn btn-sm btn-outline-dark w-100 shadow-none">More Details</a> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    data;
                                }
                            ?>
                        </div>
                        <!-- Swiper navigation buttons -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                    <div class="col-lg-12 text-center mt-5">
                        <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Rooms >>></a>
                    </div>
                </div>
            </div>
            
            <!-- our facilities -->
            <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR FACILITIES</h2>
            <div class="container">
                <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">

                    <?php
                        $res = mysqli_query($con,"SELECT * FROM `facilities` ORDER BY `id` DESC LIMIT 5");
                        $path = FACILITIES_IMG_PATH;

                        while($row = mysqli_fetch_assoc($res)){
                            echo<<<data
                                <div class="col-lg-2 col-md-2 text-center bg-dark text-white rounded shadow py-4 my-3">
                                    <img src="$path$row[icon]" width="60px" class="contrast-white p-2">
                                    <h5 class="mt-3 text-white">$row[name]</h5>
                                </div>
                            data;
                        }
                    ?>

            <div class="col-lg-12 text-center mt-5">
                <a href="facilities.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Facilities >>></a>
            </div>
        </div>
    </div>
      
    <!-- testimonials -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">TESTIMONIALS</h2>
    <div class="container mt-5">
        <div class="swiper swiper-testimonials">
            <div class="swiper-wrapper mb-5">
                <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="#" width="30px">
                        <h6 class="m-0 ms-2">Random user1</h6>
                    </div>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Asperiores nobis dolore adipisci modi! Similique ea soluta hic sapiente illo sequi.</p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>
                <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="#" width="30px">
                        <h6 class="m-0 ms-2">Random user1</h6>
                    </div>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Asperiores nobis dolore adipisci modi! Similique ea soluta hic sapiente illo sequi.</p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>
                <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="#" width="30px">
                        <h6 class="m-0 ms-2">Random user1</h6>
                    </div>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Asperiores nobis dolore adipisci modi! Similique ea soluta hic sapiente illo sequi.</p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="col-lg-12 text-center mt-5">
                <a href="#" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">Know More >>></a>
            </div>
    </div>   

            <!-- reach us -->
            
            <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">REACH US</h2>
            <div class="container">
                <div class="row align-items-stretch">
                    <div class="col-lg-8 col-md-8 d-flex">
                        <div class="bg-dark text-white p-4 rounded mb-4 w-100 h-250px d-flex align-items-stretch">
                            <iframe class="w-100 rounded" height="250px" style="min-height:340px; border:0; flex:1;" src="<?php echo $contact_r['iframe'] ?>"></iframe>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 d-flex flex-column">
                    <div class="bg-dark text-white p-4 rounded mb-4 flex-fill">
                        <h5>Call us</h5>
                        <a href="tel: +<?php echo $contact_r['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-white">
                        <i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['pn1'] ?>
                        </a>
                        <br>
                        <?php 
                        if($contact_r['pn2'] != ''){
                        echo<<<data
                        <a href="tel: +$contact_r[pn2]" class="d-inline-block text-decoration-none text-white">
                            <i class="bi bi-telephone-fill"></i> +$contact_r[pn2]
                        </a>
                        data;
                        } 
                        ?>                
                    </div>
                    <div class="bg-dark text-white p-4 rounded mb-4 flex-fill">
                        <h5>Follow us</h5>
                        <?php
                        if($contact_r['tw'] != ''){
                        echo<<<data
                        <a href="$contact_r[tw]" class="d-inline-block mb-3 text-decoration-none">
                            <span class="badge bg-dark text-white fs-6 p-2">
                            <i class="bi bi-twitter me-1"></i>Twitter
                            </span>
                        </a>
                        <br>
                        data;
                        }
                        ?>
                        <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block mb-3">
                        <span class="badge bg-dark text-white fs-6 p-2">
                            <i class="bi bi-facebook me-1"></i>Facebook
                        </span>
                        </a>
                        <br>
                        <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-block">
                        <span class="badge bg-dark text-white fs-6 p-2">
                            <i class="bi bi-instagram me-1"></i>Instagram
                        </span>
                        </a>
                    </div>    
                    </div>
                </div>
            </div>
        </div>

    <?php require('inc/footer.php'); ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".swiper-container", {
            spaceBetween: 30,
            effect: "fade",
            loop: true,
            autoplay: {
                delay:3500,
                disableOnInteraction: false
            }
        });

        var swiper = new Swiper(".swiper-testimonials", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            slidesPerView: "3",
            loop: true,
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: false,
            },
            pagination: {
                el: ".swiper-pagination"
            },
            breakpoints: {
                
                320: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });

        var swiperRooms = new Swiper(".carousel-rooms", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: false,
             resizeObserver: true, // ensures it responds to screen size change
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                  
                480: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 4,
                },
            }
            
        });

        window.addEventListener('resize', () => {
            swiperRooms.update(); // Force Swiper to recalculate layout
        });
    </script>

</body>
</html>