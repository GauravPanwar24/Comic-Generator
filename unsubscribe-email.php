<?php
if(isset($_GET['key']) && isset($_GET['token']))
{
require __DIR__.'/connection.php';
$email = filter_input(INPUT_GET, 'key', FILTER_SANITIZE_EMAIL);
$token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING);
$query = mysqli_query($conn,
"SELECT * FROM `users` WHERE `email_verification_link`='".$token."' and `email`='".$email."';"
);
$d = date('Y-m-d H:i:s');
if (mysqli_num_rows($query) > 0) {
$row= mysqli_fetch_array($query);
if($row['status'] == "active"){
mysqli_query($conn,"UPDATE users set status='inactive' WHERE email='" . $email . "'");
$msg = 'Congratulations! You have successfully unsubscribed ';
}else{
$msg = 'You have already unsubscribed from our service';
}
} else {
$msg = 'This email has been not registered with us';
}
}
else
{
$msg = 'Danger! Your something goes to wrong.';
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>XKCD: Unsubscribe Service</title>
    <style>
        body {
            margin: 0px;
            background-color: #96A8C8;
        }
        h2, h3 {
            margin: 0;
            padding: 15px;
        }
        /* Add padding to containers */
        .container {
            display: grid;
            grid-template-columns: 1fr 3fr 1fr;
            row-gap: 10%;
        }
        .card{
            margin-top: 5%;
            background-color: #fff;
            grid-column-start: 2;
            grid-column-end: 3;
            justify-content: center;
            border-radius: 10px;
        }
        hr {
            border: 1px solid #f1f1f1;
            margin-bottom: 5px;
        }
    </style>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <center><h2>Unsubscribe Email service</h2></center>
            </div>
            <hr>
            <div class="card-body">
                <h3><?php echo $msg; ?></h3>
            </div>
        </div>
    </div>
</body>

</html>