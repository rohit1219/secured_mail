<?php

    if(isset($_POST['submit']))
    {    
        /* Your password */
        $user = $_POST['username'];
        $pass = $_POST['password'];

        /* Redirects here after login */
        $redirect_after_login = 'mail_form.php';

        /* Will not ask password again for */
        $remember_password = strtotime('+15 seconds'); // +1 week 3 days 7 hours 5 seconds

        $accessFile = "access/admin.json";

        // Read the JSON file
        $json = file_get_contents($accessFile);

        // Decode the JSON file
        $json_data = json_decode($json,true);

        // Display data
        if($json_data['user'] == $user && $json_data['pass'] == $pass)
        {
            setcookie("password", $pass, $remember_password);
            header('Location:'. $redirect_after_login);
            exit;
        }
        else
        {
            echo "Invalid Username/Password";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Password protected</title>
</head>
<body>
    <div style="text-align:center;margin-top:50px;">
        ADMIN LOGIN
        <form method="POST">
            <input type="text" name="username"></br>
            <input type="text" name="password"></br>
            <input type="submit" name="submit"/>
        </form>
    </div>
</body>
</html>