<?php
/**
 * Author - Chudinov Kirill
 *
 * All pages loaded through this script
 * 
 * For example, query like this:
 *  Boomboom.co.il/Up
 * 
 * Will be converted to this:
 *  Boomboom.co.il/index.php?require_page=Up
 * 
 * And this script will require 'engine/engine_upload.php'
 *
 */
    // First of all, checking that script run in our universe.
if(2+2!==4)
    die('Configurations of your universe doesn\'t support this script :(<br> Please contact your universe administrator(aka God).');

require 'config.php';
require 'engine/classes/class_log.php';
require 'engine/functions.php';
require 'engine/classes/class_db.php';

header('Content-Type: text/html; charset=utf-8');
session_start();

    // Connecting to database
db::connect();

    // If magic quotes are turned on, turning them off
//if(get_magic_quotes_gpc())
    //magic_quotes_turn_off();

    // In this variable we have name of the page to load, if it's empty loading index
$require_page = isset($_GET['require_page'])&&!empty($_GET['require_page'])?$_GET['require_page']:'index';

    // Judging by the name of the page, we chose the name of the file to require
$search  = array('index','Up','Co','load_jobs','404');
$replace = array('index','upload','contact','load_jobs','index');
$require_page = str_replace($search, $replace, $require_page, $count);

    // If there are required page, getting it.
if($count > 0 && ($require_page==='index' || $require_page==='upload' || $require_page==='contact' || $require_page==='load_jobs'))
    require 'engine/engine_'.$require_page.'.php';

    // Else sending user to 404 page, assuming he required a not existing page
else
    header('location: /?404');