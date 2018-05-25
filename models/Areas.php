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
     * @param   $name       string for the area name.
     *
     * @return  boolean     boolean false for area already registered, or instead True.
     */
    public function register($name){
        $slug = $this->s->createSlug($name);
        $sql = "SELECT * FROM areas WHERE slug = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($slug));
        $sql = $sql->fetchAll();
        if($sql && count($sql)){
            return false;
        }else{
            $sql = "INSERT INTO areas (name, slug) VALUES (?, ?)";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($name, $slug));
            return true;
        }
    }

    /**
     * This function edit a area in database.
     * If this area already registered returns False, else returns True.
     *
     * @param   $name           string for the area name.
     *
     * @return  boolean     boolean false for area already registered, or instead True.
     */
    public function edit($id, $name){
        $slug = $this->s->createSlug($name);
        $sql = "SELECT * FROM areas WHERE slug = ? AND id != ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($slug, $id));
        $sql = $sql->fetchAll();
        if($sql && count($sql)){
            return false;
        }else{
            $sql = "UPDATE areas SET name = ?, slug = ? WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($name, $slug, $id));
            return true;
        }
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
        // Delete area
        $sql = "DELETE FROM areas WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id));
    }

}
?>