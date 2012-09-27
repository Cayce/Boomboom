<?php
require 'design_header.php';

    // Text errors
    if($login->error == 1) $login->error = 'You have to write your login and password';
elseif($login->error == 2) $login->error = 'There are no account with this login';
elseif($login->error == 3) $login->error = 'Account is blocked';
elseif($login->error == 4) $login->error = 'Password incorrect';

?>
<div class="span12">
<center>
<img src="design/static/images/you_shall_not_pass.jpg">
<?php echo !empty($login->error)?'<span class="label label-important">'.$login->error.'</span>':''; ?><br><br>
<form action="Login" method="POST">
user: <input type="text" name="login" value="<?php echo isset($_POST['login'])?e($_POST['login']):''; ?>" /><br>
pass: <input type="password" name="password" /><br>
<button class="btn btn-primary" name="login_submit" type="submit">Login</button>
</form>

</center>
</div>

<?php require 'design_bottom.php'; ?>