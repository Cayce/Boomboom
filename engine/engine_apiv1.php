<?php

require __DIR__.'/classes/class_jobs.php';

$jobs = new jobs();

$sites = array();
$types = array();
$categories = array();
$sinceId = null;
$sinceDate = new DateTime('-1 day');


if(isset($_GET['categories']) && is_array($_GET['categories']))
{
    $jobs->get_categories();
    $jobCategories = $jobs->list_of_categories;

    foreach($_GET['categories'] as $category)
        if(ctype_digit($category) && array_field_exists($jobCategories, 'id_category', $category))
            $categories[] = intval($category);
}


if(isset($_GET['sites']) && is_array($_GET['sites']))
{
    $jobs->get_websites();
    $jobSites = $jobs->list_of_websites;

    foreach($_GET['sites'] as $site)
        if(ctype_digit($site) && array_field_exists($jobSites, 'id_website', $site))
            $sites[] = intval($site);
}


if(isset($_GET['types']) && is_array($_GET['types']))
{
    $jobs->get_job_types();
    $jobTypes = $jobs->list_of_job_types;

    foreach($_GET['types'] as $type)
        if(ctype_digit($type) && array_field_exists($jobTypes, 'id_job_type', $type))
            $types[] = intval($type);
}


if(isset($_GET['sinceId']) && false !== filter_var($_GET['sinceId'], FILTER_VALIDATE_INT))
{
    $sinceId = intval($_GET['sinceId']);
    $sinceDate = null;
}

if(isset($_GET['sinceDate']) && false !== filter_var($_GET['sinceDate'], FILTER_VALIDATE_INT))
{
    $sinceDate = DateTime::createFromFormat('U', $_GET['sinceDate']);
    $sinceId = null;
}



$res = $jobs->get_jobs_selection($sites, $categories, $types, $sinceId, $sinceDate);
header('Content-Type: application/json');
echo json_encode($res);
//var_export($res);


/**
 * Checks whether within an array a sub array exists,
 * in which there is a specific index with a specific value assigned to it
 * @param array $array
 * @param $fieldName
 * @param null $expectedValue
 * @return bool
 */
function array_field_exists(array & $array, $fieldName, $expectedValue = null)
{
    $found = false;

    foreach($array as $subArray)
    {
        if(!is_array($subArray))
            continue;

        if(!isset($subArray[$fieldName]))
        {
            continue;
        }
        else if(null === $expectedValue)
        {
            $found = true;
            break;
        }
        else if($subArray[$fieldName] == $expectedValue)
        {
            $found = true;
        }
    }

    return $found;
}
