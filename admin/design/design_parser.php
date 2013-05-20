<?php
require 'design_header.php';
require 'design_menu_left.php';
?>
<div class="span2">
<form action="Parser" method="POST">
<div class="well">
<ul class="nav nav-list" dir="ltr">
<?php
for($i=0;$i<$jobs->list_of_websites_count;$i++)
{
    echo '<li><a><label class="checkbox"><input checked="checked" type="checkbox" name="websites['
         .$jobs->list_of_websites[$i]['id_website'].'][]" value="1"> <span style="color: #008080;">'
         .$jobs->list_of_websites[$i]['name'].'</span> <img align="right" src="../design/static/images/favicons/'
         .$jobs->list_of_websites[$i]['id_website'].'.ico" /></label></a></li>';
}
?>
</ul>
</div>
<div class="well">
<center><button class="btn btn-primary" name="parse_submit" type="submit">Parse!</button></center>
</div>
</form>
</div>


<?php

require 'design_bottom.php';