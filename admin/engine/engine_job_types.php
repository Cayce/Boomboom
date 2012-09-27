<?php

if(!isset($_SESSION['admin']))
{
    header('location: Login');
    die;
}

require 'classes/class_job_types.php';
$job_types = new job_types();

    // If there are a request to save the job types
if(isset($_POST['save_job_types_submit']))
{
        // Saving the job types
    if(isset($_POST['job_types']))
        $job_types->save($_POST['job_types']);
    
        // Adding new job type, if admin fill one
    $checked = isset($_POST['checked'])?1:0;
    if(isset($_POST['name']) && isset($_POST['order']) && !empty($_POST['name']) && !empty($_POST['order']))
        $job_types->add($_POST['name'],$_POST['order'],$checked);
}

    // If there are a request to delete category
if(isset($_GET['d']))
    $job_types->delete($_GET['d']);

    // Gets all the job types in array
$job_types->get();

require 'design/design_job_types.php';

