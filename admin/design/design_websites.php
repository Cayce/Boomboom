<?php
require 'design_header.php';
require 'design_menu_left.php';

/**
 * $websites->errors - array of the id's errors.
 *     1 - Image must be in ico format
 *     2 - You can't delete website that have jobs, that just stupid
 * 
 */
?>

<div class="span10">
<center>

<?php
if(in_array(1,$websites->errors)) echo '<div class="alert alert-error">Image must be in ico format</div><br />'; 
if(in_array(2,$websites->errors)) echo '<div class="alert alert-error">You can\'t delete website that have jobs, that just stupid</div><br />'; 
?>
    
<form action="Websites" method="POST" ENCTYPE="multipart/form-data">
<table class="table">
    <tr><td><b>#</b></td><td><b>ico</b></td><td><b>name</b></td><td><b>checked by default?</b></td><td></td></tr>
    <?php
    for($i=0;$i<$websites->websites_count;$i++)
    {
        if($websites->websites[$i]['checked']==1) $checked = ' checked="checked"';
        else                                      $checked = '';
        
        echo '<tr><td><input type="hidden" name="websites['.$i.'][id_website]" value="'.$websites->websites[$i]['id_website']
            .'"><input type="text" name="websites['.$i.'][order]" value="'.$websites->websites[$i]['order']
            .'" class="input-xlarge span1" /></td><td><img src="../design/static/images/favicons/'.$websites->websites[$i]['id_website']
            .'.ico"></td><td><input type="text" name="websites['.$i.'][name]" value="'.e($websites->websites[$i]['name'])
            .'" class="input-xlarge span4" /></td><td><label class="checkbox"><input'.$checked
            .' type="checkbox" name="websites['.$i.'][checked]" value="1"></label></td><td><a href="?websites&d='.$websites->websites[$i]['id_website']
            .'"><i class="icon-trash" onclick="return confirm(\'Are you sure you want to delete this website?\')"></i></a></td></tr>';
    }
    ?>
    <tr><td><input type="text" name="order" value="<?= $websites->new_order ?>" class="input-xlarge span1" /></td>
        <td><input type="file" name="image" class="input-xlarge span3" /></td>
        <td><input type="text" name="name" placeholder="New website..." class="input-xlarge span4" /></td>
        <td><label class="checkbox"><input type="checkbox" name="checked" value="1"></label></td><td></td></tr>
    <tr><td></td><td><button class="btn btn-primary" name="save_websites_submit" type="submit">Save</button></td><td colspan="3"></td></tr>
</table>
</form>

</center>
</div>

<?php
require 'design_bottom.php';
?>
