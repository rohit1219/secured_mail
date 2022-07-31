<?php

      // $to         =  $_POST['to'];
      // $subject    =  "My subject";
      // $txt        =  $file_url;
      // $headers    =  "From: ".$_POST['from'] . "\r\n" .
      //                'Reply-To: '.$_POST['from'] . "\r\n" .
      //                'X-Mailer: PHP/' . phpversion();

      // mail($to,$subject,$txt,$headers);

      $message = "HELLOW... WELCOME TO SECURED MAIL..............";
      include('Mail.php');

      $to = 'kuldeep@voztechlabs.com,rohitsonawane123@gmail.com';

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

?>
