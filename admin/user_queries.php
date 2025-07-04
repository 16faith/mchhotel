<?php 
    require('inc/essentials.php');
    require('inc/db_config.php');
    adminLogin();

    if(isset($_GET['seen'])){
        $frm_data = $_GET;

        if($frm_data['seen']=='all'){
            $q = "UPDATE `user_queries` SET `seen`=?";
            $values = [1];
            if(update($q, $values, 'i')){
                alert('success', 'Marked all as read!');
            }
            else{
                alert('danger', 'something went wrong!');
            }
        }
        else{
            $q = "UPDATE `user_queries` SET `seen`=? WHERE `id`=?";
            $values = [1,$frm_data['seen']];
            if(update($q, $values, 'ii')){
                alert('success', 'Marked as read!');
            }
            else{
                alert('danger', 'something went wrong!');
            }
        }
    }

    if(isset($_GET['del'])){
        $frm_data = $_GET;

        if($frm_data['del']=='all'){
            $q = "DELETE FROM `user_queries`";
            if(mysqli_query($con, $q)){
                alert('success', 'All data has been deleted!');
            }
            else{
                alert('danger', 'something went wrong!');
            }
        }
        else{
            $q = "DELETE FROM `user_queries` WHERE `id`=?";
            $values = [$frm_data['del']];
            if(delete($q, $values, 'i')){
                alert('success', 'Message Deleted!');
            }
            else{
                alert('danger', 'something went wrong!');
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - User Queries</title>
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">
    
    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">USER QUERIES</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-dark shadow-none btn-sm"><i class="bi bi-check-all"></i>Mark all as read</a>
                            <a href="?del=all" class="btn btn-danger shadow-none btn-sm"><i class="bi bi-trash"></i>Delete all</a>

                        </div>
                        <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top text-center">
                                    <tr>
                                    <th class="bg-dark text-light"scope="col">#</th>
                                    <th class="bg-dark text-light"scope="col">Name</th>
                                    <th class="bg-dark text-light"scope="col">Email</th>
                                    <th class="bg-dark text-light"scope="col" width="25%">Subject</th>
                                    <th class="bg-dark text-light"scope="col" width="35%">Message</th>
                                    <th class="bg-dark text-light"scope="col">Date</th>
                                    <th class="bg-dark text-light"scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center justify-content-center align-items-center">
                                    <?php
                                        $q = "SELECT * FROM `user_queries` ORDER BY `id` DESC";
                                        $data = mysqli_query($con, $q);
                                        $i = 1;

                                        while($row = mysqli_fetch_assoc($data)){
                                            $seen= '';
                                            if($row['seen'] != 1){
                                                $seen = "<a href='?seen={$row['id']}' class='btn btn-sm btn-primary'>Mark as read</a> <br>";
                                            }
                                            $seen.= "<a href='?del={$row['id']}' class='btn btn-sm btn-danger mt-2'>Delete</a>";
                                            echo<<<query
                                                <tr>
                                                    <td>$i</td>
                                                    <td>$row[name]</td>
                                                    <td>$row[email]</td>
                                                    <td>$row[subject]</td>
                                                    <td>$row[message]</td>
                                                    <td>$row[datentime]</td>
                                                    <td>$seen</td>
                                                </tr>
                                            query;
                                            $i++;
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>

</body>
</html>