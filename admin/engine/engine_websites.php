<?php

if(!isset($_SESSION['admin']))
{
    header('location: Login');
    die;
}

require 'classes/class_websites.php';
$websites = new websites();

    // If there are a request to save the websites
if(isset($_POST['save_websites_submit']))
{
    
        // Saving the websites
    if(isset($_POST['websites']))
        $websites->save($_POST['websites']);
    
        // Adding new website, if admin fill one
    $checked = isset($_POST['checked'])?1:0;
    if(isset($_POST['name']) && isset($_POST['order']) && isset($_FILES['image']['tmp_name']) &&
      !empty($_POST['name']) && !empty($_POST['order']) && !empty($_FILES['image']['tmp_name']))
        $websites->add($_POST['name'],$_POST['order'],$checked,$_FILES['image']);
}

    // If there are a request to delete website
if(isset($_GET['d']))
    $websites->delete($_GET['d']);

    // Gets all the websites in array
$websites->get();

require 'design/design_websites.php';

