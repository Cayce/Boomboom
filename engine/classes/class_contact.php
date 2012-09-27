<?php

/*
 * Author - Chudinov Kirill
 */

class contact
{
    
        // For who the function send_email() will send an email
    private $RECIPIENT_EMAIL = 'cayce252@gmail.com';
    
    public $author_email = '';
    public $title = '';
    public $text = '';
    
        // On success this varible will be set to true
    public $success = false;

    /** In case of errors, this array will have the numbers of errors
     *
     * 1 - empty email
     * 2 - email incorrect
     * 3 - empty title
     * 4 - empty text
     * 
     * @var array 
     */
    public $errors = array();
    
    /** This function sending an email
     *
     * @param string $author_email
     * @param string $title
     * @param string $text
     * @return boolean 
     */
    public function send_email($author_email,$title,$text)
    {
        $this->author_email = $author_email;
        $this->title        = $title;
        $this->text         = $text;
        
            // Checkink if all variables are correct
        $email_correct = $this->check_email($author_email);
        $title_correct = $this->check_title($title);
        $text_correct  = $this->check_text($text);
        
            // If one of the variables doesn't correct, returning false
        if(!$email_correct || !$title_correct || !$text_correct)
            return false;

            // Sending email
        $to      = $this->RECIPIENT_EMAIL;
        $title   = '=?UTF-8?B?' . base64_encode('Boomboom - '.$author_email.': '.$title) . '?=';
        $headers = "From: robot@".PR_DOMAIN."\r\n".
                   "Content-Type:text/html; charset=utf-8\r\n".
                   "Content-Transfer-Encoding:8bit\r\n"; 
        mail($to,$title,$text,$headers);
        
        $this->success      = true;
        $this->author_email = '';
        $this->title        = '';
        $this->text         = '';
        
        return true;
    }
    
    /** Return true if email correct, false if isn't. In $this->errors will put the id error.
     *
     * @param string $email
     * @return boolean 
     */
    private function check_email($email)
    {
            // Connecting to database
        db::connect();
        
        if(!empty($email) && preg_match("/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+([A-z]{2,4}\.)?[A-z]{2,4}+$/",$email))
            return true;
        
        if(empty($email))
        {
            $this->errors[] = 1; // Empty email
        }

        else
        {
            $this->errors[] = 2; // Email incorrect!
            return false;
        }
    }
    
    /** Return true if title correct, false if isn't. In $this->errors will put the id error.
     *
     * @param string $email
     * @return boolean 
     */
    private function check_title($title)
    {
        if(!empty($title))
            return true;
        else
        {
            $this->errors[] = 3; // empty title!
            return false;
        }
    }
    
    /** Return true if text correct, false if isn't. In $this->errors will put the id error.
     *
     * @param string $email
     * @return boolean 
     */
    private function check_text($text)
    { 
        if(!empty($text))
            return true;
        else
        {
            $this->errors[] = 4; // empty text!
            return false;
        }
    }

}