<div class="container-fluid bg-white mt-5">
        <div class="row">
            <div class="col-lg-4 p-4">
                <h3 class="h-font fw-bold fs-3 mb-2"><?php echo $settings_r['site_title'] ?></h3>
                <p>
                    <?php echo $settings_r['site_about'] ?>
                </p>
            </div>
            <div class="col-lg-4 p-4">
                <h5 class="mb-3">Links</h5>
                <a href="index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a><br>
                <a href="rooms.php" class="d-inline-block mb-2 text-dark text-decoration-none">Rooms</a><br>
                <a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none">Facilities</a><br>
                <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Contact us</a><br>
                <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">About us</a>
            </div>
            <div class="col-lg-4 p-4">
                <h5 class="mb-3">Follow us</h5>
                <?php 
                    echo<<<data
                        <a href="$contact_r[tw]" class="d-inline-block text-dark text-decoration-none mb-2">
                            <i class="bi bi-twitter me-1"></i>Twitter
                        </a><br>
                    data;
                ?>
                <a href="<?php echo $contact_r['fb']?>" class="d-inline-block text-dark text-decoration-none mb-2">
                    <i class="bi bi-facebook me-1"></i>Facebook
                </a><br>
                <a href="<?php echo $contact_r['insta']?>" class="d-inline-block text-dark text-decoration-none">
                    <i class="bi bi-instagram me-1"></i>Instagram
                </a>
            </div>
        </div>
</div>

<h6 class="text-center bg-dark text-white p-3 m-0 sticky-bottom">Designed and Developed by MCH WEBDEV</h6>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
    function alert(type,msg,position='body'){
        let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
        let element = document.createElement('div');
        element.innerHTML = `
            <div class="alert ${bs_class} alert-dismissible fade show" role="alert">
                <strong class="me-3">${msg}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        if(position=='body'){
            document.body.append(element);
            element.classList.add('custom-alert');    
        }
        else{
            document.getElementById(position).appendChild(element);
        }

        setTimeout(remAlert,3000);
    }

    function remAlert(){
        document.getElementsByClassName('alert')[0].remove();
    }

    function setActive()
    {
        let navbar = document.getElementById('nav-bar');
        if(!navbar) return;
        let a_tags = navbar.getElementsByTagName('a');

        for(i=0; i<a_tags.length; i++)
        {
            let file = a_tags[i].href.split('/').pop();
            let file_name = file.split('.')[0];

            if(document.location.href.indexOf(file_name) >=0){
                a_tags[i].classList.add('active');
            }
        }
    }

    let register_form = document.getElementById('register-form');

    register_form.addEventListener('submit', (e)=>{
        e.preventDefault();

        let data = new FormData();
        data.append('name',register_form.elements['name'].value);
        data.append('email',register_form.elements['email'].value);
        data.append('phonenum',register_form.elements['phonenum'].value);
        data.append('address',register_form.elements['address'].value);
        data.append('pincode',register_form.elements['pincode'].value);
        data.append('dob',register_form.elements['dob'].value);
        data.append('pass',register_form.elements['pass'].value);
        data.append('cpass',register_form.elements['cpass'].value);
        data.append('profile',register_form.elements['profile'].files[0]);
        data.append('register','');

        var myModal = document.getElementById('registerModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/login_register.php",true);

            xhr.onload = function(){
                if(this.responseText == 'pass_mismatch'){
                    alert('danger', "Password doesn't match!");
                }
                else if(this.responseText == 'email_already'){
                    alert('danger', "Email is already registered!");
                }
                else if(this.responseText == 'phone_already'){
                    alert('danger', "Phone number is already registered!");
                }
                else if(this.responseText == 'inv_img'){
                    alert('danger', "Only JPG, WEBP, & PNG images are allowed!");
                }
                else if(this.responseText == 'upd_failed'){
                    alert('danger', "Image upload failed!");
                }
                else if(this.responseText == 'ins_failed'){
                    alert('danger', "Registration failed! Server Down");
                }
                else{
                    alert('success', "Registration successful");
                    register_form.reset();
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }

            }

            xhr.send(data);
    });

    let login_form = document.getElementById('login-form');

    login_form.addEventListener('submit', (e) => {
    e.preventDefault();

    let data = new FormData();
    data.append('email_mob', login_form.elements['email_mob'].value);
    data.append('pass', login_form.elements['pass'].value);
    data.append('login', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/login_register.php", true);

    xhr.onload = function () {
        let res = this.responseText.trim();

        if (res == 'inv_email_mob') {
            alert('danger', "Invalid Email or Phone number!");
        }
        else if (res == 'inactive') {
            alert('danger', "Account suspended!");
        }
        else if (res == 'invalid_pass') {
            alert('danger', "Incorrect password!");
        }
        else if (res == 'login_success') {
            var myModal = document.getElementById('loginModal');
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();

            let fileurl = window.location.href.split('/').pop().split('?').shift();
            if (fileurl == 'room_details.php') {
                window.location = window.location.href;
            } else {
                window.location = window.location.pathname;
            }
        }
        else {
            alert('danger', "Unexpected error: " + res);
        }
    }

    xhr.send(data);
});


    function checkLoginToBook(status, room_id){
        if(status){
            window.location.href='confirm_booking.php?id=' + room_id;
        }
        else{
            alert('danger','Please login to book room!');
        }
    }

    setActive();
</script>