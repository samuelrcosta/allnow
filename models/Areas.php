<?php
/**
 * This class retrieves and saves data of the areas.
 *
 * @author  samuelrcosta
 * @version 1.0.0, 05/24/2017
 * @since   1.0.0, 05/24/2017
 */

class Areas extends Model {

    // Models instances
    private $c;
    private $s;

    /**
     * Class constructor
     */
    public function __construct(){
        parent::__construct();
        // Initialize instances
        $this->s = new Store();
        $this->c = new Categories();
    }


    /**
     * This function returns the areas list
     *
     * @return  array with all retrieved data
     */
    public function getAreasList(){
        $array = array();
        $sql = "SELECT * FROM areas ORDER BY name ASC";
        $sql = $this->db->prepare($sql);
        $sql->execute(array());
        $sql = $sql->fetchAll();
        if($sql && count($sql)){
            $array = $sql;
        }
        return $array;
    }

    /**
     * This function returns the complete areas list with categories and subcategories
     *
     * @return  array with all retrieved data
     */
    public function getCompleteList(){
        $array = array();
        $sql = "SELECT * FROM areas ORDER BY name ASC";
        $sql = $this->db->prepare($sql);
        $sql->execute(array());
        $areas = $sql->fetchAll();
        if($areas && count($areas)){
            foreach ($areas as $key => $area){
                $areas[$key]['subs'] = $this->c->getCategoriesByAreaId($area['id']);
            }
            $array = $areas;
        }
        return $array;
    }

    /**
     * This function returns the complete area data using this id
     *
     * @param   $id     int for the area id
     *
     * @return  array with all retrieved data
     */
    public function getArea($id){
        $array = array();
        $sql = "SELECT * FROM areas WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id));
        $sql = $sql->fetch();
        if($sql && count($sql)){
            $array = $sql;
        }
        return $array;
    }

    /**
     * This function returns the complete area data using this slug
     *
     * @param   $slug     string for the area slug
     *
     * @return  array with all retrieved data
     */
    public function getAreaBySlug($slug){
        $array = array();
        $sql = "SELECT * FROM areas WHERE slug = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($slug));
        $sql = $sql->fetch();
        if($sql && count($sql)){
            $array = $sql;
        }
        return $array;
    }

    /**
     * This function register a new area in database.
     * If this area already registered returns False, else returns True.
     *
     * @param   $name              string for the area name.
     * @param   $description       string for the area description.
     * @param   $image             array or null for the area image.
     *
     * @return  boolean     boolean false for area already registered, or instead True.
     */
    public function register($name, $description, $image){
        $slug = $this->s->createSlug($name);
        $sql = "SELECT * FROM areas WHERE slug = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($slug));
        $sql = $sql->fetchAll();
        if($sql && count($sql)){
            return false;
        }else{
            if(!empty($image)){
                $imageName = self::saveAreaImage($slug, '', $image);
                if($imageName == false){
                    return false;
                }
            }else{
                $imageName = '';
            }
            $sql = "INSERT INTO areas (name, description, share_image, slug) VALUES (?, ?, ?, ?)";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($name, $description, $imageName, $slug));
            return true;
        }
    }

    /**
     * This function edit a area in database.
     * If this area already registered returns False, else returns True.
     *
     * @param   $name           string for the area name.
     * @param   $description    string for the area description.
     * @param   $image          array or null for the area image.
     *
     * @return  boolean     boolean false for area already registered, or instead True.
     */
    public function edit($id, $name, $description, $image){
        $slug = $this->s->createSlug($name);
        $sql = "SELECT * FROM areas WHERE slug = ? AND id != ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($slug, $id));
        $sql = $sql->fetchAll();
        if($sql && count($sql)){
            return false;
        }else{
            // get area data
            $sql = "SELECT * FROM areas WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($id));
            $sql = $sql->fetch();
            $share_image = $sql['share_image'];
            if(!empty($image)){
                $imageName = self::saveAreaImage($slug, $share_image, $image);
                if($imageName == false){
                    return false;
                }
            }else{
                $imageName = $share_image;
            }
            $sql = "UPDATE areas SET name = ?, description = ?, share_image = ?, slug = ? WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($name, $description, $imageName, $slug, $id));
            return true;
        }
    }

    /**
     * This function save a area image on disk.
     *
     * @param   $slug           string for the area slug.
     * @param   $oldImage       string for the area old url if exists
     * @param   $file           array with image area.
     *
     * @return  boolean or string     boolean false if has a error or $new_name if has success.
     */
    public function saveAreaImage($slug, $oldImage, $file){
        $exts_checks = array('jpg', 'png', 'jpeg');
        $ext = explode(".", $file['name']);
        $ext = strtolower(end($ext));
        if(array_search($ext, $exts_checks) === false) {
            return false;
        }else{
            $new_name = "area_".$slug.".".$ext;
            $dir = $_SERVER['DOCUMENT_ROOT'] . SERVER_URL . "assets/images/categories/";
            if(move_uploaded_file($file['tmp_name'], $dir.$new_name)){
                if(!empty($oldImage)){
                    // Remove old avatar
                    unlink($_SERVER['DOCUMENT_ROOT'] . SERVER_URL . "assets/images/categories/".$oldImage);
                }
                return $new_name;
            }else{
                return false;
            }
        }
    }

    /**
     * This function delete a area image on disk.
     *
     * @param   $share_image       string for the area image url
     */
    public function deleteAreaImage($share_image){
        unlink($_SERVER['DOCUMENT_ROOT'] . SERVER_URL . "assets/images/categories/".$share_image);
    }

    /**
     * This function delete a area and all its categories.
     *
     * @param   $id       int for the area id.
     */
    public function delete($id){
        $cats = $this->c->getCategoriesByAreaId($id);
        // Delete Cats (delete ads too)
        foreach ($cats as $cat) {
            $this->c->delete($cat['id']);
        }
        // Get area data
        $areaData = self::getArea($id);
        // Check area image
        if(!empty($areaData['share_image'])){
            self::deleteAreaImage($areaData['share_image']);
        }
        // Delete area
        $sql = "DELETE FROM areas WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id));
    }

}
?>