<div class="span2">
<form method="POST" action="">
<div class="sidebar">
<div class="well">
    <ul class="nav nav-list" dir="ltr">
        <li class="<?php if($require_page=='jobs') echo 'active'; ?>"><a href="Jobs">Jobs</a></li>
        
        <li class="divider"></li>
        <li class="<?php if($require_page=='websites') echo 'active'; ?>"><a href="Websites">Websites</a></li>
        <li class="<?php if($require_page=='categories') echo 'active'; ?>"><a href="Categories">Categories</a></li>
        <li class="<?php if($require_page=='job_types') echo 'active'; ?>"><a href="JobTypes">Job Types</a></li>
        
        <li class="divider"></li>
        <li class="<?php if($require_page=='change_password') echo 'active'; ?>"><a href="ChangePassword">Change Password</a></li>
        <li class=""><a href="Exit">Exit</a></li>
    </ul>
</div>
</div>
</form>
</div>