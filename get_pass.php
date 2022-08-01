<?php

  if(!empty($_GET['email']))
  {
    $base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off") ? "https" : "http");
    $base_url .= "://".$_SERVER['HTTP_HOST'];
    $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
    
    $user_mail  = $_GET['email'];

    $dirAccess  =  "access";
    $json_file  =  $user_mail.'.json';

    if (!file_exists($dirAccess)) 
    {
      mkdir($dirAccess, 0777, true);
    }

    if(!is_file($json_file))
    {
      $accessFile = "access/".$json_file;

      // Read the JSON file
      $json = file_get_contents($accessFile);

      // Decode the JSON file
      $json_data = json_decode($json,true);
      
      $password = rand();
      
      // data stored in an array called posts
      $posts = Array (

          "email" => $json_data['email'],
          "file_name" => $json_data['file_name'],
          "pass" => $password,
          
      );
      // encode array to json
      $json = json_encode($posts);

      // $contents = "$user_mail:$password:$file_name";
      file_put_contents($dirAccess.'/'.$json_file, $json);
    }

    //   $message   =  "Hello, Click Here To Download Attachment: ".$base_url ."click.php";
    $message   =  "<html><body><p>Hello Sir/Ma'am</p> <p> Username : ".$user_mail." </p> </n>  <p> Use your email id as Username with this Password : ".$password." </p> Please <a href= ".$base_url .'click.php'.">click here</a> To Download The Attachment </body></html>";

    //send mail using php-pear
    include('Mail.php');

    $to = $user_mail;

    $headers['MIME-Version'] = '1.0'; # . "\r\n";
    $headers['Content-type'] = 'text/html; charset=iso-8859-1'; #. "\r\n";
    $headers['To'] = $to;
    #$headers['To'] = $to2;
    $headers['From'] = '"care" <care@voztechlabs.com>';
    $headers['Reply-To'] = 'care@voztechlabs.com';
    $headers['Subject'] = "Test Mail";


    $auth = array('host' => 'mail.voztechlabs.com', 'auth' => true, 'username' => 'care@voztechlabs.com', 'password' => 'care@voztechlabs');
    $smtp = Mail::factory('smtp', $auth);
    $mail = $smtp->send($to, $headers, $message);

    if (PEAR::isError($mail))
    echo('<p>PEAR mail: '.$mail->getMessage().'</p>');
    else
    echo('<p>PEAR mail: Message successfully sent!</p>');
  }

?>