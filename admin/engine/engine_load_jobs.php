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

    // Those functions will make an array with all the websites, job types and categories.
$jobs->get_websites();
$jobs->get_job_types();
$jobs->get_categories();

    // How many jobs to skip
$skip = isset($_GET['skip'])?intval($_GET['skip']):0;

    // In which parser to search
$parser_id = isset($_GET['parser_id'])?intval($_GET['parser_id']):0;

$jobs->get_jobs(5,$skip,$parser_id);

require 'design/design_load_jobs.php'; 