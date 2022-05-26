<?php
    /* Your password */
    // $password = 'smartivr';
    $password = $_POST['password'];

    /* Redirects here after login */
    $redirect_after_login = 'attachments/smartivr_email_doc.php';

    /* Will not ask password again for */
    // $remember_password = strtotime('+30 days'); // 30 days
    $remember_password = strtotime('');

    if (isset($_POST['password']) && $_POST['password'] == $password) {
        setcookie("password", $password, $remember_password);
        header('Location: ' . $redirect_after_login);
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
        You must enter the password to view this content.
        <form method="POST">
            <input type="text" name="password">
        </form>
    </div>
</body>
</html>