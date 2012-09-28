<?php

/**     
 *  $require_page - Page that user require to load(for now it 3 options - contact, upload, index)
 */

?>

<!DOCTYPE html>
<html lang="he">
  <head>
    <meta charset="utf-8" />
    <title>מודעות לפרילנסרים</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="אספנו את כל המודעות לפרילנסרים למקום אחד . You're welcome" />
    <meta name="author" content="Kirill Chudinov" />


    <!-- Le styles -->
    <link href="design/static/bootstrap/css/bootstrap.css" rel="stylesheet" />
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>

    <link href="design/static/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" />
    
    <link rel="icon" type="image/png" href="design/static/images/favicons/1.ico">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
  </head>

  <body dir='rtl'>

    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
        <div class="container">
        <a class="brand" href=".">Boomboom</a> <p class="pull-left">beta 2</p>

        <div class="nav-collapse">
            <ul class="nav pull-right">
                <li class="<?php if($require_page==='contact') echo 'active dropdown'; ?>"><a href="Co"><i class="icon-envelope <?php if($require_page==='contact') echo 'icon-white'; ?>"></i> צור קשר</a></li>
                <li class="<?php if($require_page==='upload') echo 'active dropdown'; ?>"><a href="Up"><i class="icon-upload <?php if($require_page==='upload') echo 'icon-white'; ?>"></i> הוסף מודעה</a></li>
                <li class="<?php if($require_page==='index') echo 'active dropdown'; ?>"><a href="."><i class="icon-home <?php if($require_page==='index') echo 'icon-white'; ?>"></i> דף ראשי</a></li>
            </ul>


        </div>

        </div>
        </div>
    </div>
