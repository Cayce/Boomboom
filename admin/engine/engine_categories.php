<?php

if(!isset($_SESSION['admin']))
{
    header('location: Login');
    die;
}

require 'classes/class_categories.php';
$categories = new categories();

    // If there are a request to save the categories
if(isset($_POST['save_categories_submit']))
{
        // Saving the categories
    if(isset($_POST['categories']))
        $categories->save($_POST['categories']);
    
        // Adding new category, if admin fill one
    $checked = isset($_POST['checked'])?1:0;
    if(isset($_POST['name']) && isset($_POST['order']) && !empty($_POST['name']) && !empty($_POST['order']))
        $categories->add($_POST['name'],$_POST['order'],$checked);
}

    // If there are a request to delete category
if(isset($_GET['d']))
    $categories->delete($_GET['d']);

    // Gets all the categories in array
$categories->get();

require 'design/design_categories.php';

