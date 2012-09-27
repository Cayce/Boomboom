<?php

/*
 * Author - Chudinov Kirill
 */

require 'engine/classes/class_upload.php';

$upload = new upload();

    // Browser doesn't send this variables, if they empty. So declare those variables
$_POST['categories'] = isset($_POST['categories'])?$_POST['categories']:array();
$_POST['job_types']  = isset($_POST['job_types'])?$_POST['job_types']:array();

    // If there are request to add a job offer
if(isset($_POST['submit_upload']) && isset($_POST['title']) && isset($_POST['text']) && isset($_POST['budget_min'])
   && isset($_POST['budget_max']) && isset($_POST['company_website']) && isset($_POST['company_website'])
   && isset($_POST['contact_name']) && isset($_POST['contact_email']) && isset($_POST['contact_phone']) && isset($_POST['contact_fax']))
{
    $upload->add($_POST['title'],$_POST['job_types'],$_POST['categories'],$_POST['text'],$_POST['budget_min'],$_POST['budget_max'],$_POST['company_name'],$_POST['company_website'],
            $_POST['contact_name'],$_POST['contact_email'],$_POST['contact_phone'],$_POST['contact_fax']);
}

    // Those functions will make an array with all the job types and categories.
$upload->get_job_types();
$upload->get_categories();

require 'design/design_upload.php';