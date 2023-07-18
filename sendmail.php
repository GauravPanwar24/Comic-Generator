<?php
require __DIR__.'/config.php';
function getcontent(){
    $location = 'https://c.xkcd.com/random/comic/';
    $headers = get_headers($location,1);
    $random_url=$headers['Location'][1];
    $url1=$random_url.'info.0.json';
    $ch = curl_init();  
    curl_setopt($ch,CURLOPT_URL,$url1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//only to run curl in localhost
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//only to run curl in localhost
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $output=curl_exec($ch);
    curl_close($ch);
    $result=json_decode($output);
    return $result;
}
require_once __DIR__.'/connection.php';
$users=mysqli_query($conn,"SELECT * from users where status='active'");
while($row=mysqli_fetch_assoc($users)){
    $result=getcontent();
    $from_email = $fmail;
    $from_name = $fname;
    $to_email = $row["email"];
    $to_name = $row["name"];
    $subject = 'XKCD Comic Update ['.$result->title.']';
    $link = "<a href='".$url."/unsubscribe-email.php?key=".$row['email']."&token=".$row['email_verification_link']."'>Click and Unsubscribe</a>";
    $message = '<html>
    <body>
        <div style="border: 2px solid #e7e9eb;background-color: #e7e9eb63 ">
            <div style="">
                <center><h1>'.$result->title.'</h1><center>
            </div>
            <div>     
                <center><img src="'.$result->img.'" alt"'.$result->alt.'"></center>
            </div>
        </div><br><br>
        <p>Click On This Link to Unsubscribe Email service : '.$link.'</p>
        </body></html>';
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
            "htmlContent" => $message,
            "params" => array(
                "bodyMessage" => 'XCKD Comic Update'
            ),
            "attachment" => array(
                array(
                    "url"=>$result->img,
                    "name"=>$result->title.'.png'
                )
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
    
    $result1 = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

} catch (Exception $e) {
echo $e->getMessage(),PHP_EOL;
}

}

?>
