<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> - ABOUT US</title>
    <style>
        .box{
            border-top-color: var(--teal) !important;
        }
    </style>
</head>
<body class="bg-light">
    
    <?php require('inc/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">ABOUT US</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
            Welcome to MCH Hotel, your home away from home. Nestled in the heart of the city, our hotel blends comfort, style, and service to provide the perfect stay for both business and leisure travelers.

Founded on the principles of hospitality, integrity, and innovation, MCH Hotel strives to deliver a premium experience without compromising affordability. Every detail, from our cozy rooms to our top-tier facilities, is crafted with your comfort in mind.

Our team is committed to providing heartfelt service and creating unforgettable moments for every guest.
        </p>
    </div>
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6 col-md-5 mb-4 oreder-lg-1 oreder-md-1 order-2">
                <h3 class="mb-3">Michael Carlos Hernandez</h3>
                <p>
                   Michael Carlos Hernandez is the visionary behind MCH Hotel. With a deep passion for hospitality and innovation, he founded the hotel to provide travelers with more than just a place to stay—he envisioned a space where comfort meets excellence. His dedication to quality service and guest satisfaction continues to shape the values and direction of the hotel today.
                </p>
            </div>
            <div class="col-lg-5 col-md-5 mb-4 oreder-lg-2 oreder-md-2 order-1">
                <img src="images/about/about.jpg" class="w-100">
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/hotel.svg" width="70px">
                    <h4 class="mt-3">200+ ROOMS</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/customers.svg" width="70px">
                    <h4 class="mt-3">200+ CUSTOMERS</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/rating.svg" width="70px">
                    <h4 class="mt-3">150+ REVIEWS</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/staff.svg" width="70px">
                    <h4 class="mt-3">200+ STAFFS</h4>
                </div>
            </div>
        </div>
    </div>

    <h3 class="my-5 fw-bold h-font text-center">MANAGEMENT TEAM</h3>
    
    <div class="container px-4">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper mb-5">
                <?php 
                    $about_r = selectAll('team_details');
                    $path = ABOUT_IMG_PATH;
                    while($row = mysqli_fetch_assoc($about_r)){
                        echo<<<data
                            <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                                <img src="$path$row[picture]" class="w-100">
                                <h5 class="mt-2">$row[name]</h5>
                            </div>
                        data;
                    }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <?php require('inc/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper",{
            slidesPerView: 4,
            spaceBetween: 40,
            pagination: {
                el: ".swiper-pagination",
            },
            breakpoints: {
                
                320: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });
    </script>
</body>
</html>