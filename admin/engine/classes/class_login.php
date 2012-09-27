<?php

class login
{
    /** In case of error, this variable will have the number of error
     *
     * 1 - You have to write your login and password
     * 2 - There are no account with this login
     * 3 - Account is blocked
     * 4 - Password incorrect
     * 
     * @var integer 
     */
    public $error;
    
        // On success this varible will be set to true
    public $success = false;
     
    /** Authorize an admin
     *
     * @param string $login
     * @param string $password
     * @return boolean 
     */
    public function auth($login,$password)
    {
        $login    = db::quote($login);
        $password = md5('a'.$password.'b'.sha1('c'.$password.'d').'e');
        
        $query = db::query("SELECT `id_account`,`name` FROM `accounts` WHERE `login`=$login AND `password`='$password' AND `status`=9");
        
            // If there are this login and password for some account, and the account isnt blocked
        if($r = $query->fetch())
        {
            $_SESSION['admin']        = $r['id_account'];
            $_SESSION['account_name'] = $r['name'];
            return ($this->success = true);
        }

            // Else we will check what the problem
        $query = db::query("SELECT `status` FROM `accounts` WHERE `login`=$login");
        
            // If there are no account with this login
        if(!$query)
        {
            $this->error = 2;
            return false;
        }
        
            // If this account is blocked
        $r = $query->fetch();
        if($r['status']==-1)
        {
            $this->error = 3;
            return false;
        }

            // If its not the first error and not the second, there are only one option - the password is incorrect
        $this->error = 4;
        return false;
    }
    
    
}
?>
