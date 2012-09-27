<?php

/*
 * Author - Chudinov Kirill
 */

require 'engine/classes/class_contact.php';

$contact = new contact();

    // If there are a request to email me
if(isset($_POST['submit_email']) && isset($_POST['email']) && isset($_POST['title']) && isset($_POST['text']))
    $contact->send_email($_POST['email'],$_POST['title'],$_POST['text']);

require 'design/design_contact.php';