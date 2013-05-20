<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Boomboom Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Boomboom Admin" />
    <meta name="author" content="Kirill Chudinov" />


    <!-- Le styles -->
    <link href="design/static/bootstrap/css/bootstrap.css" rel="stylesheet" />
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>

    <link href="design/static/bootstrapcss/bootstrap-responsive.css" rel="stylesheet" />

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
        <div class="container-fluid">
        <a class="brand" href=".">Boomboom Admin</a>

        <div class="nav-collapse">
            <ul class="nav">
            <?php if(isset($_SESSION['admin'])) { ?>
                <li class="<?php if($require_page=='jobs') echo 'active'; ?>"><a href="Jobs">Jobs</a></li>
                <li class="<?php if($require_page=='websites') echo 'active'; ?>"><a href="Websites">Websites</a></li>
                <li class="<?php if($require_page=='categories') echo 'active'; ?>"><a href="Categories">Categories</a></li>
                <li class="<?php if($require_page=='job_types') echo 'active'; ?>"><a href="JobTypes">Job Types</a></li>
                
                
                <li class="<?php if($require_page=='change_password') echo 'active'; ?>"><a href="ChangePassword">Change Password</a></li>
                <li class="<?php if($require_page=='parser') echo 'active'; ?>"><a href="Parser">Parser</a></li>
                <li><a href="Exit">Exit<i class="icon-off"></i></a></li>
            <?php } ?>
            </ul>


        </div>

        </div>
        </div>
    </div>
<div class="container-fluid">
<div class="row-fluid">