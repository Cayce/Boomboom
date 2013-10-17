<?php

/*
 * Author - Chudinov Kirill
 */

if(!isset($_SESSION['admin']))
{
    header('location: Login');
    die;
}

# DRY: http://en.wikipedia.org/wiki/Don't_repeat_yourself

# unchecked code, probably buggy

$parsers = array(
    'webmaster',
    'themarker',
    'jobnet',
    'jobmax',
    'alljobs',
    'jobzone',
    'avodazmanit',
    'jobmaster',
    'homeless',
    'freelancerim',
    'drushim',
);

$classes = array();
foreach ($parsers as $parser) {
    require "engine/classes/parser/class_parser_$parser.php";
    $func = "parser_$parser";
    $classes[$parser] = $func;
}

// Make an array with all the websites
require 'engine/classes/class_jobs.php';
$jobs = new jobs();
$jobs->get_websites();

    // All jobs that parsed
$jobs_parsed = array();

if(isset($_POST['parse_submit']))
{  
    set_time_limit(0);
    
    foreach($_POST['websites'] as $parser) { // be sure to set <input name="jobinfo">
    {
        $p = new $classes[$parser]();
        $p->parse();
    }

require 'design/design_parser.php';
