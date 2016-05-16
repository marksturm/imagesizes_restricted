<?php
class System extends \Contao\System
{
    public static function getImageSizes()
    {
        if (empty(static::$arrImageSizes)) {
            try {

                $sizes = array();
                $be_user = parent::importStatic('BackendUser');

                if ($be_user->isAdmin) {
                    $sql_image_size = "SELECT id, name, width, height FROM tl_image_size ORDER BY pid, name";
                
                } else {
                
                    $sql_group = "SELECT allowed_imagesizes FROM tl_user_group WHERE id IN (".implode(',',$be_user->groups).")";
                    $allowed_imagegroup = \Database::getInstance()->query($sql_group);                    
                    $sql_image_size = "SELECT id, name, width, height FROM tl_image_size WHERE id IN (".implode(',',unserialize($allowed_imagegroup->allowed_imagesizes)).") ORDER BY pid, name";
                }

                $allowed_image_sizes = \Database::getInstance()->query($sql_image_size);
                
                while ($allowed_image_sizes->next()) {
                    $sizes[$allowed_image_sizes->id] = $allowed_image_sizes->name;
                    $sizes[$allowed_image_sizes->id] .= ' (' . $allowed_image_sizes->width . 'x' . $allowed_image_sizes->height . ')';
                }
                
                if ($be_user->isAdmin) {
                    static::$arrImageSizes = array_merge(array('image_sizes' => $sizes), $GLOBALS['TL_CROP']);
                
                } else {
                
                    static::$arrImageSizes = array(
                        'image_sizes' => $sizes
                    );
                }
            
            } catch (\Exception $e) {
                static::$arrImageSizes = $GLOBALS['TL_CROP'];
            }
        }
        return static::$arrImageSizes;
    }
}
?>