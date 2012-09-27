<?php

class websites
{

        // Array of the websites
    public $websites = array();

        // Count of websites
    public $websites_count = 0;

        // Numerical order for new website
    public $new_order = 1;

    /** In case of error, this variable will have the numbers of errors
     *
     * 1 - Image must be in ico format
     * 2 - You can't delete website that have jobs, that just stupid
     * 
     * @var array 
     */
    public $errors = array();

    /** Adds new website
     *
     * @param string $name
     * @param integer $order
     * @param integer $checked 
     * @param array $image
     */
    public function add($name,$order,$checked,$image)
    {
        
         $imageinfo = getimagesize($image['tmp_name']);
         if($imageinfo['mime'] != 'image/vnd.microsoft.icon')
             $this->errors[] = 1; // Image must be in ico format
         else
         {
             
             $name       = db::quote($name);
             $order      = intval($order);
             $checked    = intval($checked);

             db::query("INSERT INTO `websites`(`name`,`order`,`checked`) VALUES($name,$order,$checked)");
             $id_image = db::lastInsertId();
             move_uploaded_file($image['tmp_name'],'../design/static/images/favicons/'.$id_image.'.ico');
         }

         return (false);
    }

    /** Update all the websites
     *
     * @param array $websites
     * @return boolean 
     */
    public function save($websites)
    {
        if(!is_array($websites))
            return false;

        $websites_count = count($websites);
        for($i=0;$i<$websites_count;$i++)
        {
            if(!isset($websites[$i]['id_website']) || !isset($websites[$i]['name']) || !isset($websites[$i]['order']))
                continue;

            $id_website = intval($websites[$i]['id_website']);
            $name       = db::quote($websites[$i]['name']);
            $order      = intval($websites[$i]['order']);
            $checked    = isset($websites[$i]['checked'])?1:0;

            db::query("UPDATE `websites` SET `name`=$name, `order`=$order, `checked`=$checked WHERE `id_website`=$id_website");
        }
        
    }

    /** Delete website
     *
     * @param ineger $id_website 
     */
    public function delete($id_website)
    {
        $id_website = intval($id_website);
        
                
        $query = db::query("SELECT `id_job` FROM `jobs` WHERE `website_id`=".$id_website);
        if($query->fetch())
        {
            $this->errors[] = 2; //  You can't delete website that have jobs, that just stupid
            return false;
        }
        
        db::query("DELETE FROM `websites` WHERE `id_website`='$id_website'");
    }


    /** Gets all the websites
     * 
     */
    public function  get()
    {
        $query = db::query("SELECT `id_website`,`name`,`order`,`checked` FROM `websites` ORDER BY `order`");

        $websites = array();
        for($i=0;$r = $query->fetch();$i++)
        {
            $websites[$i]['id_website'] = $r['id_website'];
            $websites[$i]['name']       = $r['name'];
            $websites[$i]['order']      = $r['order'];
            $websites[$i]['checked']    = $r['checked'];
        }

        $this->websites = $websites;
        $this->websites_count = $i;

                // For new website, we get the last id order, and increase it buy 1
        if($i!=0)
            $this->new_order = $websites[$i-1]['order']+1;
    }
    
}
?>
