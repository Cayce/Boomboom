<?php

/*
 * Author - Chudinov Kirill
*/
ob_start();

    // This scripts run direct from php not from server, thereof this variable isn't set
$_SERVER['SERVER_ADDR'] = '127.0.0.11';

require __DIR__.'/../config.php';
require __DIR__.'/engine/classes/class_log.php';
require __DIR__.'/engine/functions.php';
require __DIR__.'/engine/classes/class_db.php';

header('Content-Type: text/html; charset=utf-8');

    // Connecting to database
db::connect();

require __DIR__.'/engine/classes/parser/class_parser_webmaster.php';
require __DIR__.'/engine/classes/parser/class_parser_themarker.php';
require __DIR__.'/engine/classes/parser/class_parser_jobnet.php';
require __DIR__.'/engine/classes/parser/class_parser_jobmax.php';
require __DIR__.'/engine/classes/parser/class_parser_alljobs.php';
require __DIR__.'/engine/classes/parser/class_parser_jobzone.php';
require __DIR__.'/engine/classes/parser/class_parser_avodazmanit.php';
require __DIR__.'/engine/classes/parser/class_parser_jobmaster.php';
require __DIR__.'/engine/classes/parser/class_parser_homeless.php';
require __DIR__.'/engine/classes/parser/class_parser_freelancerim.php';
require __DIR__.'/engine/classes/parser/class_parser_drushim.php';

set_time_limit(0);

$parser_alljobs = new parser_alljobs();
$parser_alljobs->parse();

$parser_themarker = new parser_themarker();
$parser_themarker->parse();

$parser_jobnet = new parser_jobnet();
$parser_jobnet->parse();

$parser_jobmax = new parser_jobmax();
$parser_jobmax->parse();

$parser_jobzone = new parser_jobzone();
$parser_jobzone->parse();

$parser_avodazmanit = new parser_avodazmanit();
$parser_avodazmanit->parse();

$parser_jobmaster = new parser_jobmaster(); //there is a captcha !!! 18.05.13: а самому исправить не судьба?! спассибо бля.
$parser_jobmaster->parse();

$parser_homeless = new parser_homeless();
$parser_homeless->parse();

$parser_freelancerim = new parser_freelancerim();
$parser_freelancerim->parse();

$parser_drushim = new parser_drushim();
$parser_drushim->parse();

$parser_webmaster = new parser_webmaster();
$parser_webmaster->parse();

db::query("UPDATE `parser` SET `last_id`=`last_id`+1 WHERE `name`='parser'");  

echo 'q0';
$a = ob_get_contents();

db::query("INSERT INTO `parser`(`name`,`last_id`) VALUES('".$a."','0')"); 