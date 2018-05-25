<?php
/**
 * This class retrieves and saves data of the categories.
 *
 * @author  samuelrcosta
 * @version 1.2.1, 05/24/2018
 * @since   1.0.0, 01/15/2017
 */

class Categories extends Model {

    // Models instances
    private $s;
    private $a;

    /**
     * Class constructor
     */
    public function __construct(){
        parent::__construct();
        // Initialize instances
        $this->s = new Store();
        $this->a = new Advertisements();
    }

    /**
     * This return all principal categories
     *
     * @return  array containing all data.
     */
    public function getPrincipals(){
        $array = array();
        $sql = "SELECT cats.*, (SELECT name FROM areas WHERE id = cats.id_area) as area_name FROM categories cats WHERE cats.id_principal is null ORDER BY cats.name ASC";
        $sql = $this->db->prepare($sql);
        $sql->execute(array());
        $categories = $sql->fetchAll();
        if($categories && count($categories)){
            $array = $categories;
        }
        return $array;
    }

    /**
     * This return all subcategories
     *
     * @return  array containing all data.
     */
    public function getSubcategoriesList(){
        $array = array();
        $sql = "SELECT cats.*, (SELECT name FROM categories WHERE id = cats.id_principal) as principal_name FROM categories cats WHERE id_principal is not null ORDER BY cats.name ASC";
        $sql = $this->db->prepare($sql);
        $sql->execute(array());
        $categories = $sql->fetchAll();
        if($categories && count($categories)){
            $array = $categories;
        }
        return $array;
    }

    /**
     * This return all categories area list by area id.
     *
     * @param   $id     int for the area id.
     *
     * @return  array containing all data.
     */
    public function getCategoriesByAreaId($id){
        $array = array();
        $sql = "SELECT * FROM categories WHERE id_area = ? ORDER BY name ASC";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id));
        $categories = $sql->fetchAll();
        if($categories && count($categories)){
            foreach ($categories as $key => $cats){
                $categories[$key]['subs'] = self::getSubcategoriesByPrincipalId($cats['id']);
            }
            $array = $categories;
        }
        return $array;
    }

    /**
     * This return all subcategories list by principal category id.
     *
     * @param   $id     int for the principal category id.
     *
     * @return  array containing all returned and rearranges data.
     */
    public function getSubcategoriesByPrincipalId($id){
        $array = array();
        $sql = "SELECT * FROM categories WHERE id_principal = ? ORDER BY name ASC";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id));
        $categories = $sql->fetchAll();
        if($categories && count($categories)){
            $array = $categories;
        }
        return $array;
    }

    /**
     * This return category data by this id.
     *
     * @param   $id     int for the category id.
     *
     * @return  array containing all retrieved data.
     */
    public function getDataById($id){
        $array = array();
        $sql = "SELECT * FROM categories WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id));
        $category = $sql->fetch();
        if($category && count($category)){
            $array = $category;
        }
        return $array;
    }

    /**
     * This return category data by this slug.
     *
     * @param   $slug     string for the category slug.
     *
     * @return  array containing all retrieved data.
     */
    public function getDataBySlug($slug){
        $array = array();
        $sql = "SELECT * FROM categories WHERE slug = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($slug));
        $category = $sql->fetch();
        if($category && count($category)){
            $array = $category;
        }
        return $array;
    }

    /**
     * This function register a new category in database.
     * If this category already registered returns False, else returns True.
     *
     * @param   $name           string for the category name.
     * @param   $id_principal   int for the principal category if exists.
     * @param   $id_area        int for the area if exists
     *
     * @return  boolean     boolean false for category already registered, or instead True.
     */
    public function register($name, $id_principal = Null, $id_area = Null){
        $slug = $this->s->createSlug($name);
        $sql = "SELECT * FROM categories WHERE slug = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($slug));
        $sql = $sql->fetchAll();
        if($sql && count($sql)){
            return false;
        }else{
            $sql = "INSERT INTO categories (name, id_principal, slug, id_area) VALUES (?, ?, ?, ?)";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($name, $id_principal, $slug, $id_area));
            return true;
        }
    }

    /**
     * This function edit a category in database.
     * If this category already registered returns False, else returns True.
     *
     * @param   $name           string for the category name.
     * @param   $id_principal   int for the principal category if exists.
     * @param   $id_area        int for the area if exists
     *
     * @return  boolean     boolean false for category already registered, or instead True.
     */
    public function edit($id, $name, $id_principal = Null, $id_area = Null){
        $slug = $this->s->createSlug($name);
        $sql = "SELECT * FROM categories WHERE slug = ? AND id != ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($slug, $id));
        $sql = $sql->fetchAll();
        if($sql && count($sql)){
            return false;
        }else{
            $sql = "UPDATE categories SET name = ?, id_principal = ?, slug = ?, id_area = ? WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($name, $id_principal, $slug, $id_area, $id));
            return true;
        }
    }

    /**
     * This function delete a category and all its subcategories.
     *
     * @param   $id       int for the category id.
     */
    public function delete($id){
        // Get data
        $cData = self::getDataById($id);
        // Checks if its a principal category
        if(empty($cData['id_principal'])){
            $type = "id_category";
            // Delete ads
            $ads = $this->a->getAdsByCategoryId($id, $type);
            foreach ($ads as $ad){
                $this->a->delete($ad['id']);
            }
            // Delete subcategories
            $sql = "DELETE FROM categories WHERE id_principal = ?";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($id));
            // Delete
            $sql = "DELETE FROM categories WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($id));
        }else{
            $type = "id_subcategory";
            // Delete ads
            $ads = $this->a->getAdsByCategoryId($id, $type);
            foreach ($ads as $ad){
                $this->a->delete($ad['id']);
            }
            // Delete
            $sql = "DELETE FROM categories WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($id));
        }
    }

}
?>