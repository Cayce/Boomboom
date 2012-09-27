<?php

class categories
{

        // Array of the categories
    public $categories = array();

        // Count of categories
    public $categories_count = 0;

        // Numerical order for new category
    public $new_order = 1;

    /** In case of error, this variable will have the numbers of errors
     *
     * 
     * @var array 
     */
    public $errors = array();

    /** Adds new category
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

        db::query("INSERT INTO `categories`(`name`,`order`,`checked`) VALUES($name,$order,$checked)");
    }

    
    /** Update all the categories
     *
     * @param array $categories
     * @return boolean 
     */
    public function save($categories)
    {
        if(!is_array($categories))
            return false;

        $categories_count = count($categories);
        for($i=0;$i<$categories_count;$i++)
        {
            if(!isset($categories[$i]['id_category']) || !isset($categories[$i]['name']) || !isset($categories[$i]['order']))
                continue;

            $id_category = intval($categories[$i]['id_category']);
            $name        = db::quote($categories[$i]['name']);
            $order       = intval($categories[$i]['order']);
            $checked     = isset($categories[$i]['checked'])?1:0;

            db::query("UPDATE `categories` SET `name`=$name, `order`=$order, `checked`=$checked WHERE `id_category`=$id_category");
        }
        
        return true;
    }

    /** Delete category
     *
     * @param ineger $id_category 
     */
    public function delete($id_category)
    {
        $id_category = intval($id_category);
        db::query("DELETE FROM `categories` WHERE `id_category`='$id_category'");
    }


    /** Gets all the categories
     * 
     */
    public function  get()
    {
        $query = db::query("SELECT `id_category`,`name`,`order`,`checked` FROM `categories` ORDER BY `order`");

        $categories = array();
        for($i=0;$r = $query->fetch();$i++)
        {
            $categories[$i]['id_category'] = $r['id_category'];
            $categories[$i]['name']        = $r['name'];
            $categories[$i]['order']       = $r['order'];
            $categories[$i]['checked']     = $r['checked'];
        }

        $this->categories = $categories;
        $this->categories_count = $i;

                // For new category, we get the last id order, and increase it buy 1
        if($i!=0)
            $this->new_order = $categories[$i-1]['order']+1;
    }
    
}
?>
