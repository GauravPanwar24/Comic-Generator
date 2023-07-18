<?php
    if(isset($_SERVER['HTTP_HOST'])){
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] 
                === 'on' ? "https" : "http") . 
                "://" . $_SERVER['HTTP_HOST'];  
    }
    $apikey= getenv('mail_api');
    $fname=getenv('from_name');
    $fmail=getenv('from_mail');
    $servername=getenv('servername');
    $username=getenv('username');
    $password=getenv('password');
    $dbname = getenv('database');
    
?>