<?php

/*
 * Author - Chudinov Kirill
 */

class upload
{
    /** List of job types to show in the form
     * 
     * Every website have:
     *  id_job_type - the id of the job type 
     *  name        - name of the job type
     * 
     */
    public $list_of_job_types = array();
    public $list_of_job_types_count = 0;
    
    /** List of categories to show in the form
     * 
     * Every category have:
     *  id_category - the id of the category
     *  name        - name of the category
     * 
     */
    public $list_of_categories = array();
    public $list_of_categories_count = 0;
    
    public $title = '';
    public $job_types  = array();
    public $categories = array();
    public $text = '';
    public $budget_min = '';
    public $budget_max = '';
    public $company_name = '';
    public $company_website = '';
    public $contact_name = '';
    public $contact_email = '';
    public $contact_phone = '';
    public $contact_fax = '';
    
        // On success this varible will be set to true
    public $success = false;

    /** In case of error, this variable will have the numbers of errors
     *
     * 1 - Empty title
     * 2 - Empty categories
     * 3 - Incorrect categories
     * 4 - Empty text
     * 5 - Incorrect budget_min
     * 6 - Incorrect budget_max
     * 7 - company_website incorrect
     * 8 - contact_email incorrect
     * 9 - Incorrect contact_phone
     * 10 - Empty job types
     * 11 - Incorrect job types 
     * 12 - Incorrect contact fax
     * 
     * @var array 
     */
    public $errors = array();
    
    /** Functions adds a new job
     *
     * @param string $title
     * @param array $job_types
     * @param array $categories
     * @param string $text
     * @param integer $budget_min
     * @param integer $budget_max
     * @param string $contact_company_website
     * @param string $contact_name
     * @param string $contact_contact_email
     * @param integer $contact_phone
     * @return boolean 
     */
    public function add($title,$job_types,$categories,$text,$budget_min,$budget_max,$company_name,$company_website,$contact_name,$contact_email,$contact_phone,$contact_fax)
    {
        db::connect();
     
            // Saving variables in their first position
        $this->title           = $title;
        $this->job_types       = $job_types;
        $this->categories      = $categories;
        $this->text            = nl2br($text);
        $this->budget_min      = $budget_min;
        $this->budget_max      = $budget_max;
        $this->company_name    = $company_name;
        $this->company_website = $company_website;
        $this->contact_name    = $contact_name;
        $this->contact_email   = $contact_email;
        $this->contact_phone   = $contact_phone;
        $this->contact_fax     = $contact_fax;
       
            // Checkink if all variables correct
        $title_correct           = $this->check_title($title);
        $job_types_correct       = $this->check_job_types($job_types);
        $categories_correct      = $this->check_categories($categories);
        $text_correct            = $this->check_text($text);
        $budget_min_correct      = $this->check_budget_min($budget_min);
        $budget_max_correct      = $this->check_budget_max($budget_max);
        $company_name_correct    = $this->check_company_name($company_name);
        $company_website_correct = $this->check_company_website($company_website);
        $contact_name_correct    = $this->check_contact_name($contact_name);
        $contact_email_correct   = $this->check_contact_email($contact_email);
        $contact_phone_correct   = $this->check_contact_phone($contact_phone);
        $contact_fax_correct     = $this->check_contact_fax($contact_fax);

            // If one of the variables doesn't correct, returning false
        if(!$title_correct || !$categories_correct || !$job_types_correct || !$text_correct || !$budget_min_correct
           || !$budget_max_correct || !$company_name_correct || !$company_website_correct || !$contact_name_correct
           || !$contact_email_correct || !$contact_phone_correct || !$contact_fax_correct)
            return false;
        
            // Cleaning variables from sql injections
        $title           = db::quote($title);
        $text            = db::quote($text);
        $budget_min      = db::quote(intval($budget_min));
        $budget_max      = db::quote(intval($budget_max));
        $company_name    = db::quote($company_name);
        $company_website = db::quote($company_website);
        $contact_name    = db::quote($contact_name);
        $contact_email   = db::quote($contact_email);
        $contact_phone   = db::quote(intval($contact_phone));
        $contact_fax     = db::quote(intval($contact_fax));
        
            // If user mixed budget min and max, changing it so $budget_max > $budget_min
        if($budget_min > $budget_max)
        {
            $budget_max2 = $budget_max;
            $budget_max  = $budget_min;
            $budget_min  = $budget_max2;
        } 
        if($budget_min == 0)
        {
            $budget_min = $budget_max;
            $budget_max = 0;
        }
        if($budget_min == $budget_max)
            $budget_max = 0;
        
        db::query("INSERT INTO `jobs`(`title`,`text`,`budget_min`,`budget_max`,`company_name`,`company_website`,`contact_name`,`contact_email`,`contact_phone`,`contact_fax`,`date`,`website_id`) 
                              VALUES($title,$text,$budget_min,$budget_max,$company_name,$company_website,$contact_name,$contact_email,$contact_phone,$contact_fax,NOW(),1)");
        
            // Adding connections between new job and his job types 
        $id_job = db::lastInsertId();
        foreach($job_types as $key => $value)
            db::query("INSERT INTO `jobs_job_types`(`id_job`,`id_job_type`) VALUES('$id_job',".db::quote($value).")");
        
            // Adding connections between new job and his categories 
        foreach($categories as $key => $value)
            db::query("INSERT INTO `jobs_categories`(`id_job`,`id_category`) VALUES('$id_job',".db::quote($value).")");
        
        
            // On success
        $this->success = true;
        
            // Empty all the variables
        $this->title = $this->text = $this->budget_min = $this->budget_max = $this->company_name = $this->company_website = $this->contact_name = $this->contact_email = $this->contact_phone = $this->contact_fax = '';
        $this->job_types  = array();
        $this->categories = array();
        
        return true;
    }
    
    /** This function fill the $this->list_of_job_types variable
     * 
     *  It takes 'id_job_type' and 'name' from the database
     * 
     */
    public function get_job_types()
    {
        db::connect();
        
        $list_of_job_types = array();
        $query = db::query("SELECT `id_job_type`,`name` FROM `job_types` ORDER BY `order`");
        for($i = 0; $r = $query->fetch(); $i++)
        {
            $list_of_job_types[$i]['id_job_type'] = $r['id_job_type'];
            $list_of_job_types[$i]['name']        = $r['name'];
        }
        
        $this->list_of_job_types       = $list_of_job_types;
        $this->list_of_job_types_count = $i;
    }
    
    /** This function fill the $this->list_of_categories variable
     * 
     * It takes 'id_category' and 'name' from the database
     * 
     */
    public function get_categories()
    {
        db::connect();
        
        $list_of_categories = array();
        $query = db::query("SELECT `id_category`,`name` FROM `categories` ORDER BY `order`");
        for($i = 0; $r = $query->fetch(); $i++)
        {
            $list_of_categories[$i]['id_category'] = $r['id_category'];
            $list_of_categories[$i]['name']        = $r['name'];
        }
        
        $this->list_of_categories       = $list_of_categories;
        $this->list_of_categories_count = $i;
    }
    
    private function check_title($title)
    {
        if(!empty($title))
            return true;
        else
        {
            $this->errors[] = 1; // empty title!
            return false;
        }
    }
    
    private function check_job_types($job_types)
    { 
        if(empty($job_types) || !is_array($job_types))
        {
            $this->errors[] = 10; // empty job_types!
            return false;
        }
        
        foreach($job_types as $value)
        {
            if(intval($value)==0)
            {
                $this->errors[] = 11; // incorrect job_types!
                return false;
            }
        }
        
        return true;
    }
    
    private function check_categories($categories)
    { 
        if(empty($categories) || !is_array($categories))
        {
            $this->errors[] = 2; // empty categories!
            return false;
        }
        
        foreach($categories as $value)
        {
            if(intval($value)==0)
            {
                $this->errors[] = 3; // incorrect categories!
                return false;
            }
        }
        
        return true;
    }
    
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
    
    private function check_budget_min($budget_min)
    { 
        if(!empty($budget_min) && intval($budget_min)===0 && $budget_min !== 0)
        {
            $this->errors[] = 5; // incorrect budget_min!
            return false;
        }
        
        return true;
    }
    
    private function check_budget_max($budget_max)
    { 
        
        if(!empty($budget_max) && intval($budget_max)===0 && $budget_min !== 0)
        {
            $this->errors[] = 6; // incorrect budget_max!
            return false;
        }
        
        return true;
    }
    
    private function check_company_name($company_name)
    { 
        return true;
    }
    
    private function check_company_website($company_website)
    {
            // Connecting to database
        db::connect();
        
        if(empty($company_website) || preg_match("/^(https?:\/\/)?([A-z0-9][-A-z0-9]+\.)+.+$/i",$company_website))
            return true;

        else
        {
            $this->errors[] = 7; // company_website incorrect!
            return false;
        }
    }
    
    private function check_contact_name($contact_name)
    { 
        return true;
    }
    
    private function check_contact_email($contact_email)
    {
        if(empty($contact_email) || preg_match("/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+([A-z]{2,4}\.)?[A-z]{2,4}+$/",$contact_email))
            return true;

        else
        {
            $this->errors[] = 8; // contact_email incorrect!
            return false;
        }
    }
    
    private function check_contact_phone($contact_phone)
    { 
        $contact_phone_len = strlen($contact_phone);

        if(!empty($contact_phone) && (intval($contact_phone)==0 || $contact_phone_len !== 9 && $contact_phone_len !== 10))
        {
            $this->errors[] = 9; // incorrect contact_phone!
            return false;
        }
        
        return true;
    }
    
    private function check_contact_fax($contact_fax)
    { 
        $contact_fax_len = strlen($contact_fax);

        if(!empty($contact_fax) && (intval($contact_fax)==0 || $contact_fax_len !== 9 && $contact_fax_len !== 10))
        {
            $this->errors[] = 12; // incorrect contact_fax!
            return false;
        }
        
        return true;
    }

}