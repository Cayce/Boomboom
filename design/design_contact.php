<?php
require 'design_header.php';

/**
 * $contact->errors - array of the id's errors.
 *     1 - empty email
 *     2 - email incorrect
 *     3 - empty title
 *     4 - empty text
 * 
 * All the values in the form:
 *     $contact->author_email
 *     $contact->title
 *     $contact->text
 */
?>
<div class="container">
    <div class="row">

    <div class="span3 offset8">      
        
        <form method="POST" class="form-horizontal">
        <fieldset>
        <legend>שלח אלי מכתב</legend><br />
        <?php
        if($contact->success)
            echo '<span class="label label-success">המכתב נשלח בהצלחה</span><br /><br />';
        ?>
        <table border="0">
        <tr><td valign="top" nowrap>דואר אלקטרוני </td><td>
        <div class="control-group <?php if(in_array(1,$contact->errors) || in_array(2,$contact->errors)) echo 'error'; ?>">
        <div class="controls">
        <input type="text" name="email" value="<?php echo $contact->author_email; ?>"  class="input-xlarge span5" />
        <?php if(in_array(1,$contact->errors)) echo '<span class="help-inline">חובה למלא דואר אלקטרוני</span>'; 
          elseif(in_array(2,$contact->errors)) echo '<span class="help-inline">דואר אלקטרוני אינו תקין</span>'; ?>
        </div>
        </div></td></tr>
                
        <tr><td valign="top" nowrap>כותרת </td><td>
        <div class="control-group <?php if(in_array(3,$contact->errors)) echo 'error'; ?>">
        <div class="controls">
        <input type="text" name="title" value="<?php echo $contact->title; ?>"  class="input-xlarge span5" />
        <?php if(in_array(3,$contact->errors)) echo '<span class="help-inline">חובה למלא כותרת</span>'; ?>
        </div>
        </div></td></tr>
                
        <tr><td valign="top" nowrap>תוכן המכתב </td><td>
        <div class="control-group <?php if(in_array(4,$contact->errors)) echo 'error'; ?>">
        <div class="controls">
        <textarea name="text" class="input-xlarge span5"  rows="5"><?php echo $contact->text; ?></textarea>
        <?php if(in_array(4,$contact->errors)) echo '<span class="help-inline">חובה למלא תוכן</span>'; ?>
        </div>
        </div></td></tr>  
                
        <tr><td colspan="2">
        <div class="form-actions"><center>
            <button name="submit_email" type="submit" class="btn btn-primary">שלח!</button>
          </div></td></tr>
        
        </table>
        </fieldset>
        </form>

        <legend>או צור איתי קשר בדרך אחרת</legend>
        
        דואר אלקטרוני - Cayce252@gmail.com
        <br>
ג'אבר - Cayce@jabber.org

    </div>
    </div>
</div>


<?php
require 'design_bottom.php';
?>