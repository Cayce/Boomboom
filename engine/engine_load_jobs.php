<?php

/*
 * Author - Chudinov Kirill
 */

require 'engine/classes/class_jobs.php';

$jobs = new jobs();

    // Those functions will make an array with all the websites, job types and categories.
$jobs->get_websites();
$jobs->get_job_types();
$jobs->get_categories();

    // How many jobs to skip
$skip = isset($_GET['skip'])?intval($_GET['skip']):0;

$jobs->get_jobs(5,$skip);

require 'design/design_load_jobs.php'; 