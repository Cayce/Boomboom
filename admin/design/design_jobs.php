<?php
require 'design_header.php';
require 'design_menu_left.php';

/**
 * $jobs->list_of_websites       - array with all websites
 * $jobs->list_of_websites_count - count of the websites in the array
 *     $jobs->list_of_websites[$i]['id_website'] - id of the website
 *     $jobs->list_of_websites[$i]['name']       - name of the website
 *     $jobs->list_of_websites[$i]['checked']    - if the checkbox is checked. 1 - checked. 0 - not checked;
 * 
 * $jobs->list_of_job_types       - array with all job types
 * $jobs->list_of_job_types_count - count of the categories in the array
 *     $jobs->list_of_job_types[$i]['id_job_type'] - id of the job type
 *     $jobs->list_of_job_types[$i]['name']        - name of the job type
 *     $jobs->list_of_job_types[$i]['checked']     - if the checkbox is checked. 1 - checked. 0 - not checked;
 * 
 * $jobs->list_of_categories       - array with all categories
 * $jobs->list_of_categories_count - count of the categories in the array
 *     $jobs->list_of_categories[$i]['id_category'] - id of the categorie
 *     $jobs->list_of_categories[$i]['name']        - name of the categorie
 *     $jobs->list_of_categories[$i]['checked']     - if the checkbox is checked. 1 - checked. 0 - not checked;
 */
?>

<script>
var count_jobs = <?php echo $jobs->jobs_count; ?>
var parser_id = <?php echo $jobs->parser_id; ?>
</script>

    <div class="span2">
    <form method="POST" action="Jobs">
            
        <div class="well">
        <ul class="nav nav-list" dir="ltr">
            <?php
               
               for($i=0;$i<$jobs->list_of_websites_count;$i++)
               {
                   
                   if($jobs->list_of_websites[$i]['checked']==1) $checked = ' checked="checked"';
                   else                                          $checked = '';
                   
                   echo '<li><a><label class="checkbox"><input'.$checked.' type="checkbox" name="websites['
                        .$jobs->list_of_websites[$i]['id_website'].'][]" value="1"> <span style="color: #008080;">'
                        .$jobs->list_of_websites[$i]['name'].'</span> <img align="right" src="../design/static/images/favicons/'
                        .$jobs->list_of_websites[$i]['id_website'].'.ico" /></label></a></li>';
               }
               
                echo '</ul></div><div class="well"><ul class="nav nav-list">';
                
                for($i=0;$i<$jobs->list_of_job_types_count;$i++)
                {
                    if($jobs->list_of_job_types[$i]['checked']==1)
                        $checked = ' checked="checked"';
                    else
                        $checked = '';

                    echo '<li><a><label class="checkbox"><input'.$checked.' type="checkbox" name="job_types['
                          .$jobs->list_of_job_types[$i]['id_job_type'].'][]" value="1"> <span class="label label-info">'
                          .$jobs->list_of_job_types[$i]['name'].'</span></label></a></li>';
                }

                echo '</ul></div>';
                ?>
                
                
               
                
                <?php
            
               if(MOD_CATEGORIES_ON)
               {
                   echo '<div class="well"><ul class="nav nav-list">';
                   
                   for($i=0;$i<$jobs->list_of_categories_count;$i++)
                   {
                       if($jobs->list_of_categories[$i]['checked']==1)
                           $checked = ' checked="checked"';
                       else
                           $checked = '';

                       echo '<li><a><label class="checkbox"><input'.$checked.' type="checkbox" name="categories['.$jobs->list_of_categories[$i]['id_category'].'][]" value="1"> <span style="color: #008080;">'.$jobs->list_of_categories[$i]['name'].'</span></label></a></li>';
                   }
                   
                   echo '</ul></div>';
               }
            ?>

    <div class="well" align="left">
        <ul class="nav nav-list">
        <li><a><label class="checkbox"><input <?php if($_SESSION['show']!=1) echo 'checked="checked"'; ?> type="checkbox" name="hidden" value="1"> <span style="color: #008080;">Hidden</span></label></a></li>
        <li><a><label class="checkbox"><input <?php if($_SESSION['show']==0 || $_SESSION['show']==1) echo 'checked="checked"'; ?> type="checkbox" name="not_hidden" value="1"> <span style="color: #008080;">Not hidden</span></label></a></li>
        </ul>
    </div>
            
    <div class="well" align="left">
        Parser id:
        <input type="text" name="parser_id" value="<?php echo $jobs->parser_id; ?>" />
    </div>
            
    <div class="well" align="center">
        <button class="btn btn-primary" name="update_checkboxes" type="submit">שמור שינויים</button>
    </div>
            
         <style type="text/css">
            .at_a11y{position:relative!important;left:-10000px!important;top:auto!important;width:1px!important;height:1px!important;overflow:hidden!important;}
        </style>
    </form>
    </div>
    

    <div class="span8" id="list_jobs" dir="rtl">
   <?php
    require 'design/design_load_jobs.php';
   ?>
    </div>




<?php
require 'design_bottom.php';
?>