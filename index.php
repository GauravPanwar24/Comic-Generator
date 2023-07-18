<?php

require __DIR__.'/config.php';
$msg="";

if (isset($_POST['register']))
{
    require __DIR__.'/connection.php';
    $count=0;
    if(isset($_POST['email'])){
        $email=mysqli_real_escape_string($conn,$_POST['email']);
        $email=filter_var($email, FILTER_SANITIZE_EMAIL);
    }
    if(isset($_POST['name'])){
        $name=mysqli_real_escape_string($conn,$_POST['name']);
        $name=filter_var($name, FILTER_SANITIZE_STRING);
    }
    $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND status='active'");
    $check1 = mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND status='inactive'");
    if(mysqli_num_rows($check)>0)    {
        $msg= "User already exists";
    }elseif(mysqli_num_rows($check1)>0){
        $token = md5($email).rand(10,9999);
        $query=mysqli_query($conn, "UPDATE users SET name='$name', email_verification_link='$token', email_verified_at=NULL, status='inactive' where email='$email'") || die(mysqli_error($conn));
        $link = "<a href='".$url."/verify-email.php?key=".$email."&token=".$token."'>Click and Verify Email</a>";
        $from_email = $fmail;
        $from_name = $fname;
        $to_email = $email;
        $to_name = $name;
        $subject = 'Email Verification';
        $message = '<h2>XKCD Email verification</h2><p>Click On This Link to Verify Email '.$link.'</p>';
        $data = array(
            "sender" => array(
                "email" => $from_email,
                "name" => $from_name         
            ),
            "to" => array(
                array(
                    "email" => $to_email,
                    "name" => $to_name 
                )
        
            ),
            "subject" => $subject,
            "htmlContent" => '<html><body>'.$message.'</body></html>',
            "params" => array(
                "bodyMessage" => 'Verify your email'
            )
        
        );
        
try {
    $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.sendinblue.com/v3/smtp/email');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Api-Key: '.$apikey;
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
    $msg= 'Mail sent to registered account for Verification ';
    
} catch (Exception $e) {
    $msg= 'Something went Wrong ! Try again';
}
       
}
else{
        $token = md5($email).rand(10,9999);
        $query=mysqli_query($conn, "INSERT INTO users (name, email, email_verification_link) VALUES ('$name', '$email', '$token')") || die(mysqli_error($conn));
        $link = "<a href='".$url."/verify-email.php?key=".$email."&token=".$token."'>Click and Verify Email</a>";
        $from_email = $fmail;
        $from_name = $fname;
        $to_email = $email;
        $to_name = $name;
        $subject = 'Email Verification';
        $message = '<h2>XKCD Email verification</h2><p>Click On This Link to Verify Email '.$link.'</p>';
        $data = array(
            "sender" => array(
                "email" => $from_email,
                "name" => $from_name         
            ),
            "to" => array(
                array(
                    "email" => $to_email,
                    "name" => $to_name 
                )
        
            ),
            "subject" => $subject,
            "htmlContent" => '<html><body>'.$message.'</body></html>',
            "params" => array(
                "bodyMessage" => 'Verify your email'
            )
        
        );

try {
    $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.sendinblue.com/v3/smtp/email');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Api-Key: '.$apikey;
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
    $msg= 'Mail sent to registered account for Verification ';
    
} catch (Exception $e) {
    $msg= 'Something went Wrong ! Try again';
}
       
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XKCD Comics</title>
    <style>
        body {
            margin: 0px;
            background-color: #96A8C8;
        }

        /* Add padding to containers */
        .container {
            display: grid;
            grid-template-columns: 1fr 3fr 1fr;
            row-gap: 10%;
        }

        .heading {
            margin-top: 5%;
            background-color: #fff;
            grid-column-start: 2;
            grid-column-end: 3;
            border-radius: 20px;
            font-size: 140%;
            justify-content: center;
        }

        .form {
            background-color: #fff;
            padding: 16px;
            grid-column-start: 2;
            grid-column-end: 3;
        }

        /* Full-width input fields */
        input[type=text],
        input[type=email] {
            width: 95%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
        }

        input[type=text]:focus,
        input[type=email]:focus {
            background-color: #ddd;
            outline: none;
        }

        /* Overwrite default styles of hr */
        hr {
            border: 1px solid #f1f1f1;
            margin-bottom: 25px;
        }

        /* Set a style for the submit/register button */
        .registerbtn {
            background-color: #04AA6D;
            color: white;
            padding: 16px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            opacity: 0.9;
        }

        .registerbtn:hover {
            opacity: 1;
        }

        /* Add a blue text color to links */
        a {
            color: dodgerblue;
        }

        /* Set a grey background color and center the text of the "sign in" section */
        .signin {
            background-color: #f1f1f1;
            text-align: center;
        }
    </style>
</head>

<body>

    <body>

        <div class="container">
            <div class="heading">
                <center>
                    <h1>GET RANDOM XKCD COMICS </h1>
                </center>
            </div>
            <div class="form">
                <form action="" method="post">
                    <h1>Register</h1>
                    <p>Create Account to recieve random XKCD comics updates</p>
                    <hr>
                    <h4 style="color: red;"><?php echo $msg; ?></h4>
                    <label for="name"><b>Name</b></label>
                    <input type="text" placeholder="Enter Name" name="name" id="name" required>
                    <label for="email"><b>Email</b></label>
                    <input type="email" placeholder="Enter Email" name="email" id="email" required>
                    <input type="submit" name="register" class="registerbtn">
                </form>
            </div>

        </div>

    </body>

</html>