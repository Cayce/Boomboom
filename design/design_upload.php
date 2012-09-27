<?php
require 'design_header.php';

/**
 * $upload->errors - array of the id's errors.
 *     1 - Empty title
 *     2 - Empty categories
 *     3 - Incorrect categories
 *     4 - Empty text
 *     5 - Incorrect budget_min
 *     6 - Incorrect budget_max
 *     7 - company_website incorrect
 *     8 - contact_email incorrect
 *     9 - Incorrect contact_phone
 *     10 - Empty job types
 *     11 - Incorrect job types
 *     12 - Incorrect contact fax
 * 
 * 
 * All the values in the form:
 *     $upload->title
 *     $upload->job_types
 *     $upload->categories
 *     $upload->text
 *     $upload->budget_min
 *     $upload->budget_max
 *     $upload->company_name
 *     $upload->company_website
 *     $upload->contact_name
 *     $upload->contact_email
 *     $upload->contact_phone
 *     $upload->contact_fax
 */
?>
<div class="container">
    <div class="row">

    <div class="span3 offset8"> 
        
        <form method="POST" class="form-horizontal">
        <fieldset>
        <legend>הוסף מודעה</legend><br />
        <?php
        if($upload->success)
            echo '<span class="label label-success">הודעה נוספה בהצלחה, מחקה לאישור</span><br /><br />';
        ?>
        
        <table border="0">
        <tr><td valign="top" nowrap>כותרת </td><td>
        <div class="control-group <?php if(in_array(1,$upload->errors)) echo 'error'; ?>">
        <div class="controls">
        <input type="text" name="title" value="<?php echo e($upload->title); ?>" class="input-xlarge span5" />
        <?php if(in_array(1,$upload->errors)) echo '<span class="help-inline">בחר כותרת להודעה</span>'; ?>
        </div>
        </div></td></tr>
           
        <tr><td valign="top" nowrap>סוג משרה </td><td>    
        <div class="control-group <?php if(in_array(10,$upload->errors) || in_array(11,$upload->errors)) echo 'error'; ?>">
        <div class="controls">
              <select name="job_types[]" class="span5" multiple="multiple">
               <?php
               
               for($i=0;$i<$upload->list_of_job_types_count;$i++)
               {
                   if(in_array($upload->list_of_job_types[$i]['id_job_type'],$upload->job_types))
                       $selected = 'selected="selected"';
                   else
                       $selected = '';
                   
                   echo '<option '.$selected.'value="'.$upload->list_of_job_types[$i]['id_job_type'].'">'.e($upload->list_of_job_types[$i]['name']).'</option>';
               }
               
               ?>
              </select>
        <?php if(in_array(10,$upload->errors)) echo '<span class="help-inline">בחר לפחות סוג משרה אחת</span>';
              elseif(in_array(11,$upload->errors)) echo '<span class="help-inline">אל תבלבל תשכל</span>'; ?>
        </div>
        </div></td></tr>
        
        <tr><td valign="top" nowrap>קטגוריה </td><td>    
        <div class="control-group <?php if(in_array(2,$upload->errors) || in_array(3,$upload->errors)) echo 'error'; ?>">
        <div class="controls">
              <select name="categories[]" class="span5" multiple="multiple">
               <?php
               
               for($i=0;$i<$upload->list_of_categories_count;$i++)
               {
                   if(in_array($upload->list_of_categories[$i]['id_category'],$upload->categories))
                       $selected = 'selected="selected"';
                   else
                       $selected = '';
                   
                   echo '<option '.$selected.'value="'.$upload->list_of_categories[$i]['id_category'].'">'.e($upload->list_of_categories[$i]['name']).'</option>';
               }
               
               ?>
              </select>
        <?php if(in_array(2,$upload->errors)) echo '<span class="help-inline">בחר לפחות קטגוריה אחת</span>';
              elseif(in_array(3,$upload->errors)) echo '<span class="help-inline">אל תבלבל תשכל</span>'; ?>
        </div>
        </div></td></tr>
        
        <tr><td valign="top" nowrap>תוכן ההודעה </td><td>
        <div class="control-group <?php if(in_array(4,$upload->errors)) echo 'error'; ?>">
        <div class="controls">
        <textarea name="text" class="input-xlarge span5"  rows="5"><?php echo e($upload->text); ?></textarea>
        <?php if(in_array(4,$upload->errors)) echo '<span class="help-inline">רשום תוכן להודעה</span>'; ?>
        </div>
        </div></td></tr>

        <tr><td valign="top" nowrap>תקציב מינימלי </td><td>
        <div class="control-group <?php if(in_array(5,$upload->errors)) echo 'error'; ?>">
        <div class="controls">
        <input name="budget_min" value="<?php echo $upload->budget_min; ?>" type="text" class="input-small" />
        <?php if(in_array(5,$upload->errors)) echo '<span class="help-inline">רשום מספר</span>'; ?>
        </div>
        </div></td></tr>
        
        <tr><td valign="top" nowrap>תקציב מקסימלי </td><td>
        <div class="control-group <?php if(in_array(6,$upload->errors)) echo 'error'; ?>">
        <div class="controls">
        <input name="budget_max" value="<?php echo $upload->budget_max; ?>" type="text" class="input-small" />
        <?php if(in_array(6,$upload->errors)) echo '<span class="help-inline">רשום מספר</span>'; ?>
        </div>
        </div></td></tr>
        
        <tr><td valign="top" nowrap>שם החברה</td><td>
        <div class="control-group">
        <div class="controls">
        <input name="company_name" value="<?php echo e($upload->company_name); ?>" type="text" class="input-xlarge" />
        </div>
        </div></td></tr>
        
        <tr><td valign="top" nowrap>אתר אינטרנט </td><td>
        <div class="control-group <?php if(in_array(7,$upload->errors)) echo 'error'; ?>">
        <div class="controls">
        <input name="company_website" value="<?php echo e($upload->company_website); ?>" type="text" class="input-xlarge" />
        <?php if(in_array(7,$upload->errors)) echo '<span class="help-inline">כתובת אתר אינה תקינה</span>'; ?>
        </div>
        </div></td></tr>
        
        <tr><td valign="top" nowrap>שם איש הקשר </td><td>
        <div class="control-group">
        <div class="controls">
        <input name="contact_name" value="<?php echo e($upload->contact_name); ?>" type="text" class="input-xlarge" /></td></tr>
        </div>
        </div></td></tr>
                
        <tr><td valign="top" nowrap>דואר אלקטרוני </td><td>    
        <div class="control-group <?php if(in_array(8,$upload->errors)) echo 'error'; ?>">
        <div class="controls">
        <input name="contact_email" value="<?php echo e($upload->contact_email); ?>" type="text" class="input-xlarge" />
        <?php if(in_array(8,$upload->errors)) echo '<span class="help-inline">דואר אלקטרוני אינו תקין</span>'; ?>
        </div>
        </div></td></tr>
        
        <tr><td valign="top" nowrap>מספר פלאפון </td><td>
        <div class="control-group <?php if(in_array(9,$upload->errors)) echo 'error'; ?>">
        <div class="controls">
        <input name="contact_phone" value="<?php echo $upload->contact_phone; ?>" type="text" class="input-xlarge" />
        <?php if(in_array(9,$upload->errors)) echo '<span class="help-inline">מספר פלאפון אינו תקין</span>'; ?>
        </div>
        </div></td></tr>
        
        <tr><td valign="top" nowrap>מספר פקס </td><td valign="center">
        <div class="control-group <?php if(in_array(12,$upload->errors)) echo 'error'; ?>">
        <div class="controls">
        <input name="contact_fax" value="<?php echo $upload->contact_fax; ?>" type="text" class="input-xlarge" />
        <?php if(in_array(12,$upload->errors)) echo '<span class="help-inline">מספר פקס אינו תקין</span>'; ?>
        </div>
        </div></td></tr>
        
        
        <tr><td colspan="2"><div class="form-actions"><center>
            <button name="submit_upload" type="submit" class="btn btn-primary">שלח!</button>
            
            </center>
        </div></td></tr>

        
        </table>
        </fieldset>
        </form>

    </div>
    </div>
</div>


<?php
require 'design_bottom.php';
?>