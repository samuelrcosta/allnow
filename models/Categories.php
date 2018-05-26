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
     * @param   $description    string for the category description
     * @param   $image          array or null for the category image
     * @param   $id_principal   int for the principal category if exists.
     * @param   $id_area        int for the area if exists
     *
     * @return  boolean     boolean false for category already registered, or instead True.
     */
    public function register($name, $description, $image, $id_principal = Null, $id_area = Null){
        $slug = $this->s->createSlug($name);
        $sql = "SELECT * FROM categories WHERE slug = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($slug));
        $sql = $sql->fetchAll();
        if($sql && count($sql)){
            return false;
        }else{
            if(!empty($image)){
                $imageName = self::saveCategoryImage($slug, '', $image);
                if($imageName == false){
                    return false;
                }
            }else{
                $imageName = '';
            }
            $sql = "INSERT INTO categories (name, description, share_image, id_principal, slug, id_area) VALUES (?, ?, ?, ?, ?, ?)";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($name, $description, $imageName, $id_principal, $slug, $id_area));
            return true;
        }
    }

    /**
     * This function edit a category in database.
     * If this category already registered returns False, else returns True.
     *
     * @param   $name           string for the category name.
     * @param   $description    string for the category description.
     * @param   $image          array or null for the category image.
     * @param   $id_principal   int for the principal category if exists.
     * @param   $id_area        int for the area if exists
     *
     * @return  boolean     boolean false for category already registered, or instead True.
     */
    public function edit($id, $name, $description, $image, $id_principal = Null, $id_area = Null){
        $slug = $this->s->createSlug($name);
        $sql = "SELECT * FROM categories WHERE slug = ? AND id != ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($slug, $id));
        $sql = $sql->fetchAll();
        if($sql && count($sql)){
            return false;
        }else{
            // get category data
            $sql = "SELECT * FROM categories WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($id));
            $sql = $sql->fetch();
            $share_image = $sql['share_image'];
            if(!empty($image)){
                $imageName = self::saveCategoryImage($slug, $share_image, $image);
                if($imageName == false){
                    return false;
                }
            }else{
                $imageName = $share_image;
            }
            $sql = "UPDATE categories SET name = ?, description = ?, share_image = ?,id_principal = ?, slug = ?, id_area = ? WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($name, $description, $imageName, $id_principal, $slug, $id_area, $id));
            return true;
        }
    }

    /**
     * This function save a category image on disk.
     *
     * @param   $slug           string for the category slug.
     * @param   $oldImage       string for the category old url if exists
     * @param   $file           array with image category.
     *
     * @return  boolean or string     boolean false if has a error or $new_name if has success.
     */
    public function saveCategoryImage($slug, $oldImage, $file){
        $exts_checks = array('jpg', 'png', 'jpeg');
        $ext = explode(".", $file['name']);
        $ext = strtolower(end($ext));
        if(array_search($ext, $exts_checks) === false) {
            return false;
        }else{
            $new_name = "category_".$slug.".".$ext;
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
     * This function delete a category image on disk.
     *
     * @param   $share_image       string for the category image url
     */
    public function deleteCategoryImage($share_image){
        unlink($_SERVER['DOCUMENT_ROOT'] . SERVER_URL . "assets/images/categories/".$share_image);
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
            // Get subcategories
            $subcats = self::getSubcategoriesByPrincipalId($id);
            // Delete subcategories
            foreach ($subcats as $sub){
                self::delete($sub['id']);
            }
            // Get category data
            $catData = self::getDataById($id);
            // Check category image
            if(!empty($catData['share_image'])){
                self::deleteCategoryImage($catData['share_image']);
            }
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
            // Get category data
            $catData = self::getDataById($id);
            // Check category image
            if(!empty($catData['share_image'])){
                self::deleteCategoryImage($catData['share_image']);
            }
            // Delete
            $sql = "DELETE FROM categories WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($id));
        }
    }

}
?>