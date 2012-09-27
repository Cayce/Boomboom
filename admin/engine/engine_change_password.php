<?php

if(!isset($_SESSION['admin']))
{
    header('location: Login');
    die;
}

require 'classes/class_change_password.php';
$change_password = new change_password();

    // If there are query to change pass
if(isset($_POST['login_submit']))
{

        // If user didnt write his old pass or new pass, script write an error
    if(!isset($_POST['old_pass']) || !isset($_POST['new_pass']) || empty($_POST['old_pass']) || empty($_POST['new_pass']))
        $change_password->error = 1;

        // Else tries to auth user with this login and password
    else
        $change_password->change($_POST['old_pass'],$_POST['new_pass']);
}

require 'design/design_change_password.php';
?>
