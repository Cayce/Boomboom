<?php

/*
 * Author - Chudinov Kirill
 */

if(!isset($_SESSION['admin']))
{
    header('location: Login');
    die;
}

require 'engine/classes/parser/class_parser_webmaster.php';
require 'engine/classes/parser/class_parser_themarker.php';
require 'engine/classes/parser/class_parser_jobnet.php';
require 'engine/classes/parser/class_parser_jobmax.php';
require 'engine/classes/parser/class_parser_alljobs.php';
require 'engine/classes/parser/class_parser_jobzone.php';
require 'engine/classes/parser/class_parser_avodazmanit.php';
require 'engine/classes/parser/class_parser_jobmaster.php';
require 'engine/classes/parser/class_parser_homeless.php';
require 'engine/classes/parser/class_parser_freelancerim.php';
require 'engine/classes/parser/class_parser_drushim.php';

    // Make an array with all the websites
require 'engine/classes/class_jobs.php';
$jobs = new jobs();
$jobs->get_websites();

    // All jobs that parsed
$jobs_parsed = array();

if(isset($_POST['parse_submit']))
{  
    set_time_limit(0);
    
    if(isset($_POST['websites'][2]))
    {
        $parser_alljobs = new parser_alljobs();
        $parser_alljobs->parse();
    }
    
    if(isset($_POST['websites'][5]))
    {
        $parser_themarker = new parser_themarker();
        $parser_themarker->parse();
    }
    
    if(isset($_POST['websites'][10]))
    {
        $parser_jobnet = new parser_jobnet();
        $parser_jobnet->parse();
    }
    
    if(isset($_POST['websites'][13]))
    {
        $parser_jobmax = new parser_jobmax();
        $parser_jobmax->parse();
    }
    
    if(isset($_POST['websites'][7]))
    {
        $parser_jobzone = new parser_jobzone();
        $parser_jobzone->parse();
    }
    
    if(isset($_POST['websites'][8]))
    {
        $parser_avodazmanit = new parser_avodazmanit();
        $parser_avodazmanit->parse();
    }
    
    if(isset($_POST['websites'][9]))
    {
        $parser_jobmaster = new parser_jobmaster(); //there is a captcha !!! 18.05.13: а самому исправить не судьба?! спассибо бля.
        $parser_jobmaster->parse();
    }
    
    if(isset($_POST['websites'][11]))
    {
        $parser_homeless = new parser_homeless();
        $parser_homeless->parse();
    }
    
    if(isset($_POST['websites'][4]))
    {
        $parser_freelancerim = new parser_freelancerim();
        $parser_freelancerim->parse();
    }
    
    if(isset($_POST['websites'][21]))
    {
        $parser_drushim = new parser_drushim();
        $parser_drushim->parse();
    }
    
    if(isset($_POST['websites'][3]))
    {
        $parser_webmaster = new parser_webmaster();
        $parser_webmaster->parse();
    }
    
    db::query("UPDATE `parser` SET `last_id`=`last_id`+1 WHERE `name`='parser'");
}

require 'design/design_parser.php';