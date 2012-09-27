<?php
require 'design_header.php';
require 'design_menu_left.php';

    // Text errors
    if($change_password->error == 1) $change_password->error = 'You have to write your old pass and new pass';
elseif($change_password->error == 2) $change_password->error = 'Password incorrect';

?>

<div class="span10">
<center>
<?php echo !empty($change_password->error)?'<span class="label label-important">'.$change_password->error.'</span>':''; ?>
<?php echo $change_password->success?'<span class="label label-success">You changed your password</span>':''; ?><br><br>
<form action="Change_Password" method="POST">
old pass: <input type="password" name="old_pass" /><br>
new pass: <input type="password" name="new_pass" /><br>
<button class="btn btn-primary" name="login_submit" type="submit">Change</button>
</form>
</center>
</div>

<?php require 'design_bottom.php'; ?>