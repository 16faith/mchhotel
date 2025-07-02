<?php 
    require('../admin/inc/db_config.php');
    require('../admin/inc/essentials.php');

    date_default_timezone_set("Asia/Manila");

    if(isset($_POST['register']))
    {
        $data = filteration($_POST);

        //match password and confirm password field

        if($data['pass'] != $data['cpass']){
            echo 'pass_mismatch';
            exit;
        }

        //check user if it exist
        $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? OR `phonenum`=?", [$data['email'],$data['phonenum']],'ss');

        if(mysqli_num_rows($u_exist)!=0){
            $u_exist_fetch = mysqli_fetch_assoc($u_exist);
            echo ($u_exist_fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
            exit; 
        }

        //upload user image to server
        $img = uploadUserImage($_FILES['profile']);

        if($img == 'inv_img'){
            echo 'inv_img';
            exit;
        }
        else if($img == 'upd_failed'){
            echo 'upd_failed';
            exit;
        }

        // encrypt password

        $enc_pass = password_hash($data['pass'],PASSWORD_BCRYPT);

        $query = "INSERT INTO `user_cred`(`name`, `email`, `address`, `phonenum`, `pincode`, `dob`, `profile`, `password`) VALUES (?,?,?,?,?,?,?,?)";
        $values = [$data['name'], $data['email'], $data['address'], $data['phonenum'], $data['pincode'], $data['dob'],$img,$enc_pass];

        if(insert($query,$values,'ssssssss')){
            echo '1';
        }
        else{
            echo 'ins_failed';
        }

    }

    if(isset($_POST['login']))
    {
        $data = filteration($_POST);

        // Fetch user by email or phone
        $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? OR `phonenum`=?", [$data['email_mob'],$data['email_mob']],'ss');

        if(mysqli_num_rows($u_exist) == 0){
            echo 'inv_email_mob'; // Invalid email or phone
            exit;
        }

        $u_fetch = mysqli_fetch_assoc($u_exist);

        if($u_fetch['status']==0){
            echo 'inactive';
            exit;
        }
        // Verify password
        else{
            if(!password_verify($data['pass'], $u_fetch['password'])){
            echo 'invalid_pass';
            }
            else{
                session_start();
                $_SESSION['login'] = true;
                $_SESSION['uId'] = $u_fetch['id'];
                $_SESSION['uName'] = $u_fetch['name'];
                $_SESSION['uPic'] = $u_fetch['profile'];
                $_SESSION['uPhone'] = $u_fetch['phonenum'];
                echo 1;
            }
        }
        echo 'login_success';
        exit;


    }
?>