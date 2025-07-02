<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <?php require('inc/links.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> - PROFILE</title>
</head>
<body class="bg-light">
    
    <?php 
        require('inc/header.php'); 
        if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
            redirect('index.php');
        }

        $u_exist = select("SELECT * FROM `user_cred` WHERE `id` =? LIMIT 1", [$_SESSION['uId']],'s');

        if(mysqli_num_rows($u_exist) == 0){
            redirect('index.php');
        }

        $u_fetch = mysqli_fetch_assoc($u_exist);
    ?>  

    <div class="container">
        <div class="row">
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold">PROFILE</h2>
                <div style="font-size: 15px;">
                    <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                    <span class="text-secondary">></span>
                    <a href="#" class="text-secondary text-decoration-none">PROFILE</a>
                </div>
            </div>

            <div class="col-12 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="info-form">
                        <h5 class="mb3 fw-bold">Basic Information</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" value="<?php echo $u_fetch['name'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="name" class="form-label">Phone Number</label>
                                <input type="number" name="phonenum" value="<?php echo $u_fetch['phonenum'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input name="dob" value="<?php echo $u_fetch['dob'] ?>" type="date" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Pincode</label>
                                <input name="pincode" value="<?php echo $u_fetch['pincode'] ?>" type="number" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-8 mb-4">
                                <label class="form-label">Address</label>
                                    <textarea name="address" class="form-control shadow-none" rows="1" required><?php echo $u_fetch['address'] ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-sm custom-bg text-white shadow-none">Save Changes</button>
                        </div>
                    </form>

                </div>
            </div>

            <div class="col-md-4 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="profile-form">
                        <h5 class="mb3 fw-bold">Picture</h5>
                        <img src="<?php echo USERS_IMG_PATH.$u_fetch['profile'] ?>" class="rounded-circle img-fluid">
                        
                        <label class="form-label required">New Picture</label>
                        <input name="profile" type="file" accept=".jpg,.jpeg,.png,.webp" class="mb-4 form-control shadow-none" required>
                        <button type="submit" class="btn btn-sm custom-bg text-white shadow-none">Save Changes</button>  
                    </form>
                </div>
            </div>

            <div class="col-md-8 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="pass-form">
                        <h5 class="mb3 fw-bold">Change Password</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">New Password</label>
                                <input name="new_pass" type="password" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label required">Confirm Password</label>
                                <input name="confirm_pass" type="password" class="form-control shadow-none" required>
                            </div>
                            <button type="submit" class="btn btn-sm custom-bg text-white shadow-none">Save Changes</button>
                        </div>      
                    </form>
                </div>
            </div>
            
        </div>
    </div>
    
 
    <?php require('inc/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        let info_form = document.getElementById('info-form');

        info_form.addEventListener('submit',function(e){
            e.preventDefault();

            let data = new FormData();
            data.append('info_form','');
            data.append('name',info_form.elements['name'].value);
            data.append('phonenum',info_form.elements['phonenum'].value);
            data.append('address',info_form.elements['address'].value);
            data.append('pincode',info_form.elements['pincode'].value);
            data.append('dob',info_form.elements['dob'].value);

            let xhr = new XMLHttpRequest();
            xhr.open('POST','ajax/profile.php',true);

            xhr.onload = function(){
                if(this.responseText=='phone_already'){
                    alert('danger', "phonenumber is already registered");
                }
                else if(this.responseText==0){
                    alert('danger',"No changes made");
                }
                else{
                    alert('success', 'Changes saved');
                }
            }
            xhr.send(data);
        });

        let profile_form = document.getElementById('profile-form');

        profile_form.addEventListener('submit',function(e){
            e.preventDefault();

            let data = new FormData();
            data.append('profile_form','');
            data.append('profile',profile_form.elements['profile'].files[0]);

            let xhr = new XMLHttpRequest();
            xhr.open('POST','ajax/profile.php',true);

            xhr.onload = function(){
                if(this.responseText == 'inv_img'){
                    alert('danger', "Only JPG, WEBP, & PNG images are allowed!");
                }
                else if(this.responseText == 'upd_failed'){
                    alert('danger', "Image upload failed!");
                }
                else if(this.responseText==0){
                    alert('danger',"Update Failed");
                }
                else{
                    window.location.href=window.location.pathname;
                    alert('success', 'Profile picture updated successfully');
                }
            }
            xhr.send(data);
        });

        let pass_form = document.getElementById('pass-form');

        pass_form.addEventListener('submit',function(e){
            e.preventDefault();

            let new_pass = pass_form.elements['new_pass'].value;
            let confirm_pass = pass_form.elements['confirm_pass'].value;

            if(new_pass != confirm_pass){
                alert('danger', "Passwords do not match");
                return false;
            }

            let data = new FormData();
            data.append('pass_form','');
            data.append('new_pass',new_pass);
            data.append('confirm_pass',confirm_pass);

            let xhr = new XMLHttpRequest();
            xhr.open('POST','ajax/profile.php',true);

            xhr.onload = function(){
                if(this.responseText == 'mismatch'){
                    alert('danger', "Password doesn't match!");
                }
                else if(this.responseText==0){
                    alert('danger',"Update Failed");
                }
                else{
                    alert('success', 'Password Changed!');
                    pass_form.reset();
                }
            }
            xhr.send(data);
        });

    </script>

</body>
</html>