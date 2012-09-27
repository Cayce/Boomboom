<?php
require 'design_header.php';
require 'design_menu_left.php';

/**
 * $job_types->errors - array of the id's errors.
 * 
 */
?>

<div class="span10">
<center>
    
<form action="JobTypes" method="POST">
<table class="table">
    <tr><td><b>#</b></td><td><b>name</b></td><td><b>checked by default?</b></td><td></td></tr>
    <?php
    for($i=0;$i<$job_types->job_types_count;$i++)
    {
        if($job_types->job_types[$i]['checked']==1) $checked = ' checked="checked"';
        else                                        $checked = '';
        
        echo '<tr><td><input type="hidden" name="job_types['.$i.'][id_job_type]" value="'.$job_types->job_types[$i]['id_job_type']
            .'"><input type="text" name="job_types['.$i.'][order]" value="'.$job_types->job_types[$i]['order']
            .'" class="input-xlarge span1" /></td><td><input type="text" dir="rtl" name="job_types['.$i.'][name]" value="'.e($job_types->job_types[$i]['name'])
            .'" class="input-xlarge span4" /></td><td><label class="checkbox"><input'.$checked
            .' type="checkbox" name="job_types['.$i.'][checked]" value="1"></label></td><td><a href="?job_types&d='.$job_types->job_types[$i]['id_job_type']
            .'"><i class="icon-trash" onclick="return confirm(\'Are you sure you want to delete this job type?\')"></i></a></td></tr>';
    }
    ?>
    <tr><td><input type="text" name="order" value="<?= $job_types->new_order ?>" class="input-xlarge span1" /></td>
        <td><input type="text" dir="rtl" name="name" placeholder="סוג משרה חדש..." class="input-xlarge span4" /></td>
        <td><label class="checkbox"><input type="checkbox" name="checked" value="1"></label></td><td></td></tr>
    <tr><td></td><td><button class="btn btn-primary" name="save_job_types_submit" type="submit">Save</button></td><td colspan="3"></td></tr>
</table>
</form>

</center>
</div>

<?php
require 'design_bottom.php';
?>
