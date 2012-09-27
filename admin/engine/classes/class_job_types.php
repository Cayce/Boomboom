<?php

class job_types
{

        // Array of the websites
    public $job_types = array();

        // Count of job types
    public $job_types_count = 0;

        // Numerical order for new job types
    public $new_order = 1;

    /** In case of error, this variable will have the numbers of errors
     * 
     * @var array 
     */
    public $errors = array();
    
    
    /** Adds new job type
     *
     * @param string $name
     * @param integer $order
     * @param integer $checked 
     */
    public function add($name,$order,$checked)
    {   
        $name       = db::quote($name);
        $order      = intval($order);
        $checked    = intval($checked);

        db::query("INSERT INTO `job_types`(`name`,`order`,`checked`) VALUES($name,$order,$checked)");
    }

    
    /** Update all the job types
     *
     * @param array $job_types
     * @return boolean 
     */
    public function save($job_types)
    {
        if(!is_array($job_types))
            return false;

        $job_types_count = count($job_types);
        for($i=0;$i<$job_types_count;$i++)
        {
            if(!isset($job_types[$i]['id_job_type']) || !isset($job_types[$i]['name']) || !isset($job_types[$i]['order']))
                continue;

            $id_job_type = intval($job_types[$i]['id_job_type']);
            $name        = db::quote($job_types[$i]['name']);
            $order       = intval($job_types[$i]['order']);
            $checked     = isset($job_types[$i]['checked'])?1:0;

            db::query("UPDATE `job_types` SET `name`=$name, `order`=$order, `checked`=$checked WHERE `id_job_type`=$id_job_type");
        }
        
    }

    /** Delete job type
     *
     * @param ineger $id_job_type 
     */
    public function delete($id_job_type)
    {
        $id_job_type = intval($id_job_type);
        db::query("DELETE FROM `job_types` WHERE `id_job_type`='$id_job_type'");
    }


    /** Gets all the job types
     * 
     */
    public function  get()
    {
        $query = db::query("SELECT `id_job_type`,`name`,`order`,`checked` FROM `job_types` ORDER BY `order`");

        $websites = array();
        for($i=0;$r = $query->fetch();$i++)
        {
            $job_types[$i]['id_job_type'] = $r['id_job_type'];
            $job_types[$i]['name']        = $r['name'];
            $job_types[$i]['order']       = $r['order'];
            $job_types[$i]['checked']     = $r['checked'];
        }

        $this->job_types = $job_types;
        $this->job_types_count = $i;

                // For new job type, we get the last id order, and increase it buy 1
        if($i!=0)
            $this->new_order = $job_types[$i-1]['order']+1;
    }
    
}
?>
