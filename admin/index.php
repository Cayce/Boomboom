<?php
/**
 * Author - Chudinov Kirill
 *
 * All pages loaded through this script
 * 
 * For example, query like this:
 *  Boomboom.co.il/Login
 * 
 * Will be converted to this:
 *  Boomboom.co.il/index.php?require_page=Login
 * 
 * And this script will require 'engine/engine_login.php'
 *
 */

require '../config.php';
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
$require_page = isset($_GET['require_page'])&&!empty($_GET['require_page'])?$_GET['require_page']:'Jobs';

    // Judging by the name of the page, we chose the name of the file to require
$search  = array('index','Login','Exit','ChangePassword','Jobs','load_jobs','Websites','Categories','JobTypes','Parser');
$replace = array('jobs','login','exit','change_password','jobs','load_jobs','websites','categories','job_types','parser');
$require_page = str_replace($search, $replace, $require_page, $count);

    // If there are required page, getting it.
if($count > 0 && ($require_page==='login' || $require_page==='exit' || $require_page==='change_password'
               || $require_page==='jobs' || $require_page==='load_jobs' || $require_page==='websites' || $require_page==='categories'
               || $require_page==='job_types' || $require_page==='parser'))
    require 'engine/engine_'.$require_page.'.php';

    // Else sending user to 404 page, assuming he required a not existing page
else
    header('location: ./?404');