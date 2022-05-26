<?php
    
   $base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off") ? "https" : "http");
   $base_url .= "://".$_SERVER['HTTP_HOST'];
   $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

    if(isset($_POST['user']) && isset($_POST['pass']))
    {
        $user   =   $_POST['user'];
        $pass   =   $_POST['pass'];

        //memory & time execution
        ini_set('memory_limit',-1);
        ini_set('max_execution_time',-1);
        ini_set('upload_max_filesize',"800M");

        $accessFile = "access/".$user.'.json';

        // Read the JSON file
        $json = file_get_contents($accessFile);

        // Decode the JSON file
        $json_data = json_decode($json,true);

        // Display data
        if($json_data['email'] == $user && $json_data['pass'] == $pass)
        {
            $file        =  $json_data['file_name'];
            $file_path    =  "attachments/".$file;

            if (file_exists($file_path)) 
            {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.basename($file_path));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file_path));
                ob_clean();
                flush();
                readfile($file_path);

                echo "File downloaded successfully";
            }

        }

        exit;

       
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Password protected</title>
</head>
<body>
    <div style="text-align:center;margin-top:50px;">
        You must enter the username & password to download this content.</br></br>
        <form method="POST">
            <input type="email" name="user" placeholder="Enter Your Username"></br></br>
            <input type="text" name="pass" placeholder="Enter Your Password"></br></br>
            
            <button type="submit" value="Submit">Submit</button>
        </form>
    </div>
</body>
</html>