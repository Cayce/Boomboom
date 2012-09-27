<?php

/*
 * Author - Chudinov Kirill
 */

require 'engine/classes/class_jobs.php';

$jobs = new jobs();

    // Browser doesn't send this variables, if they empty. So declare those variables
$_POST['websites']   = isset($_POST['websites'])?$_POST['websites']:array();
$_POST['categories'] = isset($_POST['categories'])?$_POST['categories']:array();
$_POST['job_types']  = isset($_POST['job_types'])?$_POST['job_types']:array();


    // If user updated the search form
if(isset($_POST['update_checkboxes']))
{
    if(!empty($_POST['websites'])) $jobs->update_websites_checkboxes($_POST['websites']);
    else                           $_SESSION['websites'] = $jobs->create_website_checkboxes();
    
    if(!empty($_POST['job_types'])) $jobs->update_job_types_checkboxes($_POST['job_types']);
    else                            $_SESSION['job_types'] = $jobs->create_job_types_checkboxes();
    
    if(!empty($_POST['categories'])) $jobs->update_categories_checkboxes($_POST['categories']);
    else                             $_SESSION['categories'] = $jobs->create_categories_checkboxes();
}

    // Creates list of websites checks if doesnt exist
if(!isset($_SESSION['websites']))
    $_SESSION['websites'] = $jobs->create_website_checkboxes();

    // Creates list of job types checks if doesnt exist
if(!isset($_SESSION['job_types']))
    $_SESSION['job_types'] = $jobs->create_job_types_checkboxes();

    // Creates list of job-categories checks if doesnt exist
if(!isset($_SESSION['categories']))
    $_SESSION['categories'] = $jobs->create_categories_checkboxes();

    // Those functions will make an array with all the job types categories and websites
$jobs->get_categories();
$jobs->get_job_types();
$jobs->get_websites();

    // Gets 10 jobs
$jobs->get_jobs(10);

require 'design/design_index.php';