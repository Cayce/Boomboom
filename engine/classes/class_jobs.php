<?php

/*
 * Author - Chudinov Kirill
 */

class jobs
{
    
    /** List of websites to show in a search form.
     * 
     * Every website have:
     *  id_website - the id of the website
     *  name       - name of the website
     *  checked    - if to check the checkbox in form near this website 
     * 
     */
    public $list_of_websites = array();
    public $list_of_websites_count = 0;

    /** List of job types to show in a search form.
     * 
     * Every category have:
     *  id_job_type - the id of the job type
     *  name        - name of the job type
     *  checked     - if to check the checkbox in form near this job type 
     * 
     */
    public $list_of_job_types = array();
    public $list_of_job_types_count = 0;
    
    /** List of categories to show in a search form.
     * 
     * Every category have:
     *  id_category - the id of the category
     *  name        - name of the category
     *  checked     - if to check the checkbox in form near this category 
     * 
     */
    public $list_of_categories = array();
    public $list_of_categories_count = 0;

    /** Array with data of the jobs
     *
     * @var array
     */
    public $jobs;
    public $jobs_count;

    /** Get the last $limit jobs, start from job number $skip :)
     *
     * @param integer $limit - how many jobs to get
     * @param integer $skip  - how many jobs to skip
     */
    public function get_jobs($limit,$skip=0)
    {
        db::connect();

        $jobs = array();
        $limit = intval($limit);
        
            // Making website condition for query
        for($i=0;$i<$this->list_of_websites_count;$i++)
        {
            if($this->list_of_websites[$i]['checked']==1 && isset($id_websites))
                $id_websites .= ','.$this->list_of_websites[$i]['id_website'];
            
            elseif($this->list_of_websites[$i]['checked']==1)
                $id_websites = $this->list_of_websites[$i]['id_website'];
        }
       
        if(isset($id_websites))
            $condition_id_websites = '`website_id` IN ('.$id_websites.')';
        
            // If there are no websites that user checked
        else
        {
                // Make condition as if user cheked all the websites
            $condition_id_websites = '`id_job` != 0';

                // Getting all the websites
            $_SESSION['websites'] = $this->create_website_checkboxes();
            
            $this->get_websites();
        }
        
            // Making job types condition for query
        for($i=0;$i<$this->list_of_job_types_count;$i++)
        {
            if($this->list_of_job_types[$i]['checked']==1 && isset($job_types))
                $job_types .= ','.$this->list_of_job_types[$i]['id_job_type'];
            
            elseif($this->list_of_job_types[$i]['checked']==1)
                $job_types = $this->list_of_job_types[$i]['id_job_type'];
        }
        
        if(isset($job_types))
            $condition_job_types = "`id_job` IN (SELECT `id_job` FROM `jobs_job_types` WHERE `id_job_type` IN($job_types))";
        
            // If there are no job types that user checked
        else
        {
                // Make condition as if user cheked all the job types
            $condition_job_types = '`id_job` != 0';

                // Getting all the job types
            $_SESSION['job_types'] = $this->create_job_types_checkboxes();
            
            $this->get_job_types();
        }
        
            // Making job categories condition for query
        for($i=0;$i<$this->list_of_categories_count;$i++)
        {
            if($this->list_of_categories[$i]['checked']==1 && isset($categories))
                $categories .= ','.$this->list_of_categories[$i]['id_category'];
            
            elseif($this->list_of_categories[$i]['checked']==1)
                $categories = $this->list_of_categories[$i]['id_category'];
        }
       
        if(isset($categories))
            $condition_categories = "`id_job` IN (SELECT `id_job` FROM `jobs_categories` WHERE `id_category` IN($categories))";
        
            // If there are no categories that user checked
        else
        {
                // Make condition as if user cheked all the categories
            $condition_categories = '`id_job` != 0';

                // Getting all the categories
            $_SESSION['categories'] = $this->create_categories_checkboxes();
            
            $this->get_categories();
        }

            // Geting data of the jobs
        $query = db::query("SELECT * FROM `jobs` WHERE  $condition_id_websites AND $condition_categories AND $condition_job_types AND `show`=1 ORDER BY `date` DESC, `id_job` DESC LIMIT $skip,$limit");
        for($i=$skip; $r = $query->fetch(); $i++)
        {
                // Saving all the data in variables
            foreach($r as $key => $value)
                $jobs[$i][$key] = $value;
            
                // Delete all the tags in text, except <br> and <u>
            $jobs[$i]['text'] = strip_tags($jobs[$i]['text'],'<br><p><u><b>');
            
                // Creating minimized text
            if(mb_strlen($jobs[$i]['text'],'utf-8')>520)
                $jobs[$i]['text_min'] = strip_tags(mb_substr($jobs[$i]['text'],0,500,'utf-8'),'<br><p><u><b>').'...';
            
                // Getting the types
            $query4 = db::query("SELECT `name` FROM `job_types` WHERE `id_job_type` IN(SELECT `id_job_type` FROM `jobs_job_types` WHERE `id_job`=".$r['id_job'].")");
            $jobs[$i]['types'] = '';
            while($r4 = $query4->fetch())
                $jobs[$i]['types'] .= '<span class="label label-info">'.$r4['name'].'</span> ';
            
                // Geting the categories
            $query2 = db::query("SELECT `name` FROM `categories` WHERE `id_category` IN(SELECT `id_category` FROM `jobs_categories` WHERE `id_job`=".$r['id_job'].")");
            $r2 = $query2->fetch();
            $jobs[$i]['categories'] = $r2['name'];
            while($r2 = $query2->fetch())
                $jobs[$i]['categories'] .= ', '.$r2['name'];
            
                // Getting the website
            $query3 = db::query("SELECT `name` FROM `websites` WHERE `id_website` = ".$jobs[$i]['website_id']." ORDER BY `order`");
            $r3 = $query3->fetch();
            $jobs[$i]['website_name'] = $r3['name'];
            
                // Getting budget
            if($jobs[$i]['budget_min']==0 && $jobs[$i]['budget_max']==0)
                $jobs[$i]['budget'] = '';
            elseif($jobs[$i]['budget_max']==0)
                $jobs[$i]['budget'] = '<b> תקציב: </b>'.$jobs[$i]['budget_min'].'₪';
            else
                $jobs[$i]['budget'] = '<b> תקציב: </b>'.$jobs[$i]['budget_min'].'₪ - '.$jobs[$i]['budget_max'].'₪';
            
                // Fixing phone number
            $jobs[$i]['contact_phone'] = $jobs[$i]['contact_phone']!=0?$jobs[$i]['contact_phone']:'';
            
                // By language setting align and direction of the text (0-engish;1-hebrew)
            if($jobs[$i]['language']==0)
                $jobs[$i]['language'] = 'align="left" dir="ltr"';
            else
                $jobs[$i]['language'] = 'align="right" dir="rtl"';
            
                // Geting date
            $jobs[$i]['date'] = redate_short($jobs[$i]['date']);
        }

        $this->jobs       = $jobs;
        $this->jobs_count = count($jobs);
    }
    
    /** This function fill the $this->list_of_websites variable
     * 
     * 'id_website' and 'name' it takes from the database
     * and 'checked' it takes from sessions, for every website written if its checked(1) or not checked(0) 
     * 
     */
    public function get_websites()
    {
        db::connect();
        
        $list_of_websites['hide_websites'] = true;
        $list_of_websites['first_hiden_website'] = -1;
        
            // Geting all the websites
        $query = db::query("SELECT `id_website`,`name`,`checked` FROM `websites` ORDER BY `order`");
        for($i = 0; $r = $query->fetch(); $i++)
        {
                // Remembering the first website that hiden
            if($r['checked']==0 && $list_of_websites['first_hiden_website']==-1)
                $list_of_websites['first_hiden_website'] = $i;
            
            $list_of_websites[$i]['id_website'] = $r['id_website'];
            $list_of_websites[$i]['name']       = $r['name'];
            
                // If there are no session with this website, its a new website, so making it for start as checked
            if(!isset($_SESSION['websites'][$r['id_website']]))
            {
                $list_of_websites[$i]['checked'] = 1;
                $_SESSION['websites'][$r['id_website']] = 1; // adding the website to sessions
            }
            
            elseif($_SESSION['websites'][$r['id_website']] == 1)
                $list_of_websites[$i]['checked'] = 1;
            else
                $list_of_websites[$i]['checked'] = 0;
            
                // If one of the hidden websites checked, open spoiler with hiden websites
            if($list_of_websites['first_hiden_website']!=-1 && $list_of_websites[$i]['checked']==1)
                $list_of_websites['hide_websites'] = false;
        }
        
        $this->list_of_websites       = $list_of_websites;
        $this->list_of_websites_count = $i;
    }
    
    /** This function fill the $this->list_of_job_types variable
     * 
     * 'id_type' and 'name' it takes from the database,
     * and 'checked' it takes from sessions. For every category written if its checked(1) or not checked(0) 
     * 
     */
    public function get_job_types()
    {
        db::connect();
        
            // Getting all the categories
        $list_of_job_types = array();
        $query = db::query("SELECT `id_job_type`,`name` FROM `job_types` ORDER BY `order`");
        for($i = 0; $r = $query->fetch(); $i++)
        {
            $list_of_job_types[$i]['id_job_type'] = $r['id_job_type'];
            $list_of_job_types[$i]['name']        = $r['name'];
            
                // If there are no session with this category, its a new category, so making it for start as checked
            if(!isset($_SESSION['job_types'][$r['id_job_type']]))
            {
                $list_of_job_types[$i]['checked'] = 1;
                $_SESSION['job_types'][$r['id_job_type']] = 1; // adding the category to sessions
            }
            
            elseif($_SESSION['job_types'][$r['id_job_type']] == 1)
                $list_of_job_types[$i]['checked'] = 1;
            else
                $list_of_job_types[$i]['checked'] = 0;
        }
        
        $this->list_of_job_types       = $list_of_job_types;
        $this->list_of_job_types_count = $i;
    }
    
    /** This function fill the $this->list_of_categories variable
     * 
     * 'id_category' and 'name' it takes from the database,
     * and 'checked' it takes from sessions. For every category written if its checked(1) or not checked(0) 
     * 
     */
    public function get_categories()
    {
        db::connect();
        
            // Getting all the categories
        $list_of_categories = array();
        $query = db::query("SELECT `id_category`,`name` FROM `categories` ORDER BY `order`");
        for($i = 0; $r = $query->fetch(); $i++)
        {
            $list_of_categories[$i]['id_category'] = $r['id_category'];
            $list_of_categories[$i]['name']        = $r['name'];
            
                // If there are no session with this category, its a new category, so making it for start as checked
            if(!isset($_SESSION['categories'][$r['id_category']]))
            {
                $list_of_categories[$i]['checked'] = 1;
                $_SESSION['categories'][$r['id_category']] = 1; // adding the category to sessions
            }
            
            elseif($_SESSION['categories'][$r['id_category']] == 1)
                $list_of_categories[$i]['checked'] = 1;
            else
                $list_of_categories[$i]['checked'] = 0;
        }
        
        $this->list_of_categories       = $list_of_categories;
        $this->list_of_categories_count = $i;
    }
    
    /** This function return an array for sessions, with all websites marked as checked
     * It runs only if there are no already an array with websites in sessions
     *
     * @return array 
     */
    public function create_website_checkboxes()
    {
        db::connect();
        
        $checked = array();
        
            // Gettigng all the websites
        $query = db::query("SELECT `id_website`,`checked` FROM `websites` ORDER BY `order`");
        for($i = 0; $r = $query->fetch(); $i++)
        {
                // Checking if by default website is checked
            if($r['checked']==1)
                $checked[$r['id_website']] = 1;
            else    
                $checked[$r['id_website']] = 0;
        }
        
        return ($checked);
    }
    
    /** This function return an array for sessions, with all job types marked as checked
     * It runs only if there are no already an array with websites in sessions
     *
     * @return array 
     */
    public function create_job_types_checkboxes()
    {
        db::connect();
        
        $checked = array();
        
            // Gettigng all the websites
        $query = db::query("SELECT `id_job_type`,`checked` FROM `job_types` ORDER BY `order`");
        for($i = 0; $r = $query->fetch(); $i++)
        {
                // Checking if by default job type is checked
            if($r['checked']==1)
                $checked[$r['id_job_type']] = 1;
            else    
                $checked[$r['id_job_type']] = 0;
        }
        
        return ($checked);
    }
    
    /** This function return an array for sessions, with all categories marked as checked
     * It runs only if there are no already an array with categories in sessions
     *
     * @return array 
     */
    public function create_categories_checkboxes()
    {
        db::connect();
        
        $checked = array();
        
            // Gettigng all the websites
        $query = db::query("SELECT `id_category`,`checked` FROM `categories` ORDER BY `order`");
        for($i = 0; $r = $query->fetch(); $i++)
        {
                // Checking if by default job type is checked
            if($r['checked']==1)
                $checked[$r['id_category']] = 1;
            else    
                $checked[$r['id_category']] = 0;
        }
        
        return ($checked);
    }
    
    /** This function runs when user change something in the form search
     * It updates the session variable to fit what user fill in the form
     * 
     */
    public function update_websites_checkboxes($checked)
    {
        foreach($_SESSION['websites'] as $key => $value)
        {
            if(!isset($checked[$key]))
                $_SESSION['websites'][$key] = 0;
            elseif($checked[$key][0]==1)
                $_SESSION['websites'][$key] = 1;
        }
    }
    
    /** This function runs when user change something in the form search
     * It updates the session variable to fit what user fill in the form
     * 
     */
    public function update_job_types_checkboxes($checked)
    {
        foreach($_SESSION['job_types'] as $key => $value)
        {
            if(!isset($checked[$key]))
                $_SESSION['job_types'][$key] = 0;
            elseif($checked[$key][0]==1)
                $_SESSION['job_types'][$key] = 1;
        }
    }
    
    /** This function runs when user change something in the form search
     * It updates the session variable to fit what user fill in the form
     * 
     */
    public function update_categories_checkboxes($checked)
    {
        foreach($_SESSION['categories'] as $key => $value)
        {
            if(!isset($checked[$key]))
                $_SESSION['categories'][$key] = 0;
            elseif($checked[$key][0]==1)
                $_SESSION['categories'][$key] = 1;
        }
    }

}