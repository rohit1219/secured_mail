<?php

   $base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off") ? "https" : "http");
   $base_url .= "://".$_SERVER['HTTP_HOST'];
   $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

   if(isset($_FILES['file']))
   {

      $errors     =  array();
      $file_name  =  $_FILES['file']['name'];
      $file_tmp   =  $_FILES['file']['tmp_name'];
      // $extensions= array("jpeg","jpg","png");

      $dir        =  "attachments";
      $file_path  =  $dir.'/'.$file_name;

      if (!file_exists($dir)) {
         mkdir($dir, 0777, true);
      }

      //memory & time execution
      ini_set('memory_limit',-1);
      ini_set('max_execution_time',-1);

      move_uploaded_file($file_tmp,$file_path);

      // $content    = file_get_contents ($file_path);
      // $txt        = "require_once('protect-this.php');";
      // file_put_contents($file_path, $txt."\n".$content );

      $user_mail  =  $_POST['to'];
      $dirAccess  =  "access";
      $json_file  =  $user_mail.'.json';

      if (!file_exists($dirAccess)) {
         mkdir($dirAccess, 0777, true);
      }

      if(!is_file($json_file)){
         $password = rand();

         // data stored in an array called posts
         $posts = Array (

            "email" => $user_mail,
            "pass" => $password,
            "file_name" => $file_name,
            
         );
         // encode array to json
         $json = json_encode($posts);

         // $contents = "$user_mail:$password:$file_name";
         file_put_contents($dirAccess.'/'.$json_file, $json);
      }

      // $message   =  "Hello, Thank You For Registering With xyz. Please Click The Following Link To Download Attachment: ".$base_url .$file_path;

      //send mail using php-pear
      include('Mail.php');
      include('Mail/mime.php');

      $to = $user_mail;

      $headers['MIME-Version'] = '1.10.2'; # . "\r\n";
      $headers['Content-type'] = 'text/html; charset=iso-8859-1'; #. "\r\n";
      $headers['To'] = $to;
      #$headers['To'] = $to2;
      $headers['From'] = '"care" <care@voztechlabs.com>';
      $headers['Reply-To'] = 'care@voztechlabs.com';
      $headers['Subject'] = "Test Mail";
      $text = 'This is a text message.';// Text version of the email
      $html = "<html><body><p>Hello Sir/Ma'am</p> Please <a href= ".$base_url .'click.php'.">click here</a> To Download The Attachment </body></html>";// HTML version of the email
      $crlf = "\r\n";

      // Creating the Mime message
      $mime = new Mail_mime($crlf);

      // Setting the body of the email
      $mime->setTXTBody($text);
      $mime->setHTMLBody($html);

      $body = $mime->get();
      $headers = $mime->headers($headers);


      $auth = array('host' => 'mail.voztechlabs.com', 'auth' => true, 'username' => 'care@voztechlabs.com', 'password' => 'care@voztechlabs');
      $smtp = Mail::factory('smtp', $auth);
      $mail = $smtp->send($to, $headers, $body);

      if (PEAR::isError($mail))
      echo('<p>PEAR mail: '.$mail->getMessage().'</p>');
      else
      echo('<p>PEAR mail: Message successfully sent!</p>');
   }

?>

<html>
   <body>

      <form action="" method="POST" enctype="multipart/form-data">
         <label for="to">To:</label><br>
         <input type="email" id="to" name="to"><br><br>
         <!-- <label for="from">From:</label><br>
         <input type="email" id="from" name="from"><br><br> -->
         <input type="file" name="file" />
         <br><br><br>
         <input type="submit"/>
      </form>

   </body>

   