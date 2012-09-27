<?php

    // If account already login, sending him to index page
if(isset($_SESSION['admin']))
{
    header('location: Jobs');
    die;
}

require 'classes/class_login.php';
$login = new login();

    // If there are query to login
if(isset($_POST['login_submit']))
{
        // If user didnt write his login or password, script write an error
    if(!isset($_POST['login'])|| !isset($_POST['password']) || empty($_POST['login'])  || empty($_POST['password']))
        $login->error = 1;
    
        // Else tries to auth user with this login and password
    else
        $login->auth($_POST['login'],$_POST['password']);
    
        // On success sending user to index page
    if($login->success)
        header('location: Jobs');
}

require 'design/design_login.php';
?>
