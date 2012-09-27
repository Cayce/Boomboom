<?php

class change_password
{
    /** In case of error, this variable will have the number of error
     *
     * 1 - You have to write your old pass and new pass
     * 2 - Password incorrect
     * 
     * @var integer 
     */
    public $error;
    
        // On success this varible will be set to true
    public $success = false;
    
    /** Change password of admin
     *
     * @param string $old_pass
     * @param string $new_pass
     * @return boolean 
     */
    public function change($old_pass,$new_pass)
    {
        $old_pass = md5('a'.$old_pass.'b'.sha1('c'.$old_pass.'d').'e');
        $new_pass = md5('a'.$new_pass.'b'.sha1('c'.$new_pass.'d').'e');
        
        $query = db::query("SELECT `id_account` FROM `accounts` WHERE `login`='admin' AND `password`='$old_pass' AND `status`=9");
        
            // If there are this login and password for some account, and the account isnt blocked
        if($query->fetch())
        {
            db::query("UPDATE `accounts` SET `password`='$new_pass' WHERE `login`='admin'");
            return ($this->success = true);
        }
        else
        {
                // The password is incorrect
            $this->error = 2;
            return false;
        }
    }
    
    
}
?>
