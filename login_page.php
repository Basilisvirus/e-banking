<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>
        Ebanking v1.0 Login
    </title>
    <style>
        body {
            background-color: #00281f;
            color: white;
        }
    </style>
</head>

<body>
<form action = "login_check.php" method= "get">
    Email: <input type="text" name="email" placeholder = "someone@example.gr" /><br /><br />
    Password: <input type="text" name="pass" placeholder = "password >=4 characters" /><br /><br />
    Nickname: <input type="text" name="nick" placeholder = "only for registration" /><br /><br />
    <input type= "submit" name="submit" value="Submit" />
<!-- dropdown menu-->
    <select name="typeOfSubmission">
        <option>Sign in</option>
        <option>Register</option>
    </select>
</form>


</body>


</html>

