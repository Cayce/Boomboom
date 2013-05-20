<?php

/*
 * Author - Chudinov Kirill
 */

if(!isset($_SESSION['admin']))
{
    header('location: Login');
    die;
}

require 'engine/classes/class_jobs.php';

$jobs = new jobs();

    // If there are a request to delete/show/hide job
if(isset($_POST['delete']) && isset($_POST['id_job']))
    $jobs->delete_job($_POST['id_job']);
elseif(isset($_POST['show']) && isset($_POST['id_job']))
    $jobs->show_job($_POST['id_job']);
elseif(isset($_POST['hide']) && isset($_POST['id_job']))
    $jobs->hide_job($_POST['id_job']);

    // Browser doesn't send this variables, if they empty. So declare those variables
$_POST['websites']   = isset($_POST['websites'])?$_POST['websites']:array();
$_POST['categories'] = isset($_POST['categories'])?$_POST['categories']:array();
$_POST['job_types']  = isset($_POST['job_types'])?$_POST['job_types']:array();
$_POST['parser_id']  = isset($_POST['parser_id'])?$_POST['parser_id']:0;


    // If admin updated the search form
if(isset($_POST['update_checkboxes']))
{
    if(!empty($_POST['websites'])) $jobs->update_websites_checkboxes($_POST['websites']);
    else                           $_SESSION['websites_admin'] = $jobs->create_website_checkboxes();
    
    if(!empty($_POST['job_types'])) $jobs->update_job_types_checkboxes($_POST['job_types']);
    else                            $_SESSION['job_types_admin'] = $jobs->create_job_types_checkboxes();
    
    if(!empty($_POST['categories'])) $jobs->update_categories_checkboxes($_POST['categories']);
    else                             $_SESSION['categories_admin'] = $jobs->create_categories_checkboxes();
    
        // Checking what admin ask to show. Hidden jobs, not hidden jobs or both
    if(isset($_POST['hidden']) && isset($_POST['not_hidden']))
        $_SESSION['show'] = 0;
    elseif(isset($_POST['not_hidden']))
        $_SESSION['show'] = 1;
    else
        $_SESSION['show'] = 2;
}

    // Creates list of websites checks if doesnt exist
if(!isset($_SESSION['websites_admin']))
    $_SESSION['websites_admin'] = $jobs->create_website_checkboxes();

    // Creates list of job types checks if doesnt exist
if(!isset($_SESSION['job_types_admin']))
    $_SESSION['job_types_admin'] = $jobs->create_job_types_checkboxes();

    // Creates list of job-categories checks if doesnt exist
if(!isset($_SESSION['categories_admin']))
    $_SESSION['categories_admin'] = $jobs->create_categories_checkboxes();

    // Creates session show(what to show - hidden jobs, not hidden jobs or both) if doesnt exist
if(!isset($_SESSION['show']))
    $_SESSION['show'] = 0;

    // Those functions will make an array with all the job types categories and websites
$jobs->get_categories();
$jobs->get_job_types();
$jobs->get_websites();
    

    // Gets 10 jobs
$jobs->get_jobs(10,0,$_POST['parser_id']);

require 'design/design_jobs.php';