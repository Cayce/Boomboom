<?php
/**
 * $jobs->jobs_count - count of the jobs
 * 
 * Data of the job:	
 *     $jobs->jobs[$i]['id_job']
 *     $jobs->jobs[$i]['website_name']
 *     $jobs->jobs[$i]['website_id']
 *     $jobs->jobs[$i]['title']
 *     $jobs->jobs[$i]['text']
 *     $jobs->jobs[$i]['text_min']
 *     $jobs->jobs[$i]['categories']
 *     $jobs->jobs[$i]['budget']
 *     $jobs->jobs[$i]['company_name']
 *     $jobs->jobs[$i]['company_website']
 *     $jobs->jobs[$i]['contact_name']
 *     $jobs->jobs[$i]['contact_email']
 *     $jobs->jobs[$i]['contact_phone']
 *     $jobs->jobs[$i]['contact_fax']
 *     $jobs->jobs[$i]['url_to_contact']
 *     $jobs->jobs[$i]['source_id']
 *     $jobs->jobs[$i]['source_url']
 *     $jobs->jobs[$i]['date']
 */

$skip = isset($skip)?$skip:0;
for($i=$skip;$i<$jobs->jobs_count+$skip;$i++)
{
   
   ?>
    <div class="well well-small">
      <?php echo '<h4><a href="'.$jobs->jobs[$i]['source_url'].'" target="_blank"><img alt="'.$jobs->jobs[$i]['website_name'].
                 '" align="right" src="design/static/images/favicons/'.$jobs->jobs[$i]['website_id'].'.ico" /></a> &nbsp; '
                  .$jobs->jobs[$i]['types'].e($jobs->jobs[$i]['title']).'<div style="float: left"><h5>'.$jobs->jobs[$i]['date']
                  .'</h5></div></h4>'; ?>
    <br />
    <table><tr><td valign="top" nowrap>
    <ul class="nav nav-pills nav-stacked">
        <?php
            if(isset($jobs->jobs[$i]['text_min']))
                echo '<li class="active"><a href="#'.($i*3+1).'" data-toggle="tab">תקציר</a></li>';
        ?>
        <li<?php if(!isset($jobs->jobs[$i]['text_min'])) echo ' class="active"'; ?>><a href="#<?php echo $i*3+2; ?>" data-toggle="tab">הודעה</a></li>
        <?php
            if(!empty($jobs->jobs[$i]['company_name']) || !empty($jobs->jobs[$i]['company_website']) || !empty($jobs->jobs[$i]['contact_name']) || !empty($jobs->jobs[$i]['contact_email']) || !empty($jobs->jobs[$i]['contact_phone']) || !empty($jobs->jobs[$i]['contact_fax']) || !empty($jobs->jobs[$i]['source_url']) || !empty($jobs->jobs[$i]['url_to_contact']))
                echo '<li><a href="#'.($i*3+3).'" data-toggle="tab">צור קשר</a></li>';
        ?>
        
        
    </ul></td><td valign="top">
    <div class="tab-content" align="left">

    <?php
    if(isset($jobs->jobs[$i]['text_min']))
    {      
    ?>
    <div class="tab-pane active" align="right" id="<?php echo $i*3+1; ?>">
    <p>
        <?php
            if(MOD_CATEGORIES_ON) echo'<b>קטגוריות: </b>',$jobs->jobs[$i]['categories'],$jobs->jobs[$i]['budget'],'<br /><br />';
            
            echo $jobs->jobs[$i]['text_min'];
        ?>
    </p>
    </div>
    <?php
    }
    ?>
    <div class="tab-pane<?php if(!isset($jobs->jobs[$i]['text_min'])) echo ' active' ?>" align="right" id="<?php echo $i*3+2; ?>">
    <p>
        <?php if(MOD_CATEGORIES_ON) echo'<b>קטגוריות: </b>',$jobs->jobs[$i]['categories'],$jobs->jobs[$i]['budget'],'<br /><br />';
        
              echo $jobs->jobs[$i]['text']; ?>
    </p>
    </div>
    <?php
    if(!empty($jobs->jobs[$i]['company_name']) || !empty($jobs->jobs[$i]['company_website']) || !empty($jobs->jobs[$i]['contact_name']) || !empty($jobs->jobs[$i]['contact_email']) || !empty($jobs->jobs[$i]['contact_phone']) || !empty($jobs->jobs[$i]['contact_fax']) || !empty($jobs->jobs[$i]['source_url']) || !empty($jobs->jobs[$i]['url_to_contact']))
    {
    ?>
    <div class="tab-pane" align="right" id="<?php echo $i*3+3; ?>">
        
        <table>
        <?php echo !empty($jobs->jobs[$i]['company_name'])?'<tr><td align="left"><p><u>חברה</u>: </p></td><td><p>'.e($jobs->jobs[$i]['company_name']).'</p></td></tr>':'';
              echo !empty($jobs->jobs[$i]['company_website'])?'<tr><td align="left"><p><u>אתר אינטרנט</u>: </p></td><td><p><a href="'.e($jobs->jobs[$i]['company_website']).'" target="_blank">'.e($jobs->jobs[$i]['company_website']).'</a></p></td></tr>':'';
              echo !empty($jobs->jobs[$i]['contact_name'])?'<tr><td align="left"><p><u>שם איש הקשר</u>: </p></td><td><p>'.e($jobs->jobs[$i]['contact_name']).'</p></td></tr>':'';
              echo !empty($jobs->jobs[$i]['contact_email'])?'<tr><td align="left"><p><u>דואר אלקטרוני</u>: </p></td><td><p>'.e($jobs->jobs[$i]['contact_email']).'</p></td></tr>':'';
              echo !empty($jobs->jobs[$i]['contact_phone'])?'<tr><td align="left"><p><u>מספר פלאפון</u>: </p></td><td><p>'.e($jobs->jobs[$i]['contact_phone']).'</p></td></tr>':'';
              echo !empty($jobs->jobs[$i]['contact_fax'])?'<tr><td align="left"><p><u>מספר פקס</u>: </p></td><td><p>'.e($jobs->jobs[$i]['contact_fax']).'</p></td></tr>':'';
              echo '<tr><td><br /></td></tr>';
              echo !empty($jobs->jobs[$i]['source_url'])?'<tr><td align="right" colspan="2"><p><a href="'.e($jobs->jobs[$i]['source_url']).'" target="_blank">מקום בו פורסמה ההודעה</a></p></td></tr>':'';
              echo !empty($jobs->jobs[$i]['url_to_contact'])?'<tr><td align="right" colspan="2"><p><a href="'.e($jobs->jobs[$i]['url_to_contact']).'" target="_blank">צור קשר דרך האתר בו פורסמה ההודעה</a></p></td></tr>':'';
       ?>
        </table>
    </div>
    <?php
    }
    ?>
    </div>
    </td></tr></table>
    </div>
   <?php
}