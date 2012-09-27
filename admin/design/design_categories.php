<?php
require 'design_header.php';
require 'design_menu_left.php';

/**
 * $categories->errors - array of the id's errors.
 * 
 */
?>

<div class="span10">
<center>
    
<form action="Categories" method="POST">
<table class="table">
    <tr><td><b>#</b></td><td><b>name</b></td><td><b>checked by default?</b></td><td></td></tr>
    <?php
    for($i=0;$i<$categories->categories_count;$i++)
    {
        if($categories->categories[$i]['checked']==1) $checked = ' checked="checked"';
        else                                      $checked = '';
        
        echo '<tr><td><input type="hidden" name="categories['.$i.'][id_category]" value="'.$categories->categories[$i]['id_category']
            .'"><input type="text" name="categories['.$i.'][order]" value="'.$categories->categories[$i]['order']
            .'" class="input-xlarge span1" /></td><td><input type="text" dir="rtl" name="categories['.$i.'][name]" value="'.e($categories->categories[$i]['name'])
            .'" class="input-xlarge span4" /></td><td><label class="checkbox"><input'.$checked
            .' type="checkbox" name="categories['.$i.'][checked]" value="1"></label></td><td><a href="?categories&d='.$categories->categories[$i]['id_category']
            .'"><i class="icon-trash" onclick="return confirm(\'Are you sure you want to delete this category?\')"></i></a></td></tr>';
    }
    ?>
    <tr><td><input type="text" name="order" value="<?= $categories->new_order ?>" class="input-xlarge span1" /></td>
        <td><input type="text" dir="rtl" name="name" placeholder="קטגוריה חדשה..." class="input-xlarge span4" /></td>
        <td><label class="checkbox"><input type="checkbox" name="checked" value="1"></label></td><td></td></tr>
    <tr><td></td><td><button class="btn btn-primary" name="save_categories_submit" type="submit">Save</button></td><td colspan="3"></td></tr>
</table>
</form>

</center>
</div>

<?php
require 'design_bottom.php';
?>
