<?php
/**
 * This class retrieves and saves data of the users advertisements.
 *
 * @author  samuelrcosta
 * @version 1.3.0, 05/24/2018
 * @since   1.0, 01/11/2017
 */


class Advertisements extends Model{

    // Models instances
    private $medias_ads;
    private $s;

    /**
     * Class constructor
     */
    public function __construct(){
        parent::__construct();
        // Initialize instances
        $this->medias_ads = new Medias_ads();
        $this->s = new Store();
    }

    /**
     * This function get the Admin advertisements from database.
     *
     * @return  array with the retrieved data.
     */
    public function getAdminAds(){
        $sql = 'SELECT advertisements.*, (SELECT name FROM categories WHERE advertisements.id_category = id) as category_name,
(SELECT name FROM categories WHERE advertisements.id_subcategory = id) as subcategory_name FROM advertisements WHERE status = 1';
        $sql = $this->db->query($sql);
        $array = $sql->fetchAll();
        /*
        foreach ($array as &$ad){
            $ad['medias'] = $this->medias_ads->getMedias($ad['id']);
        }
        */
        return $array;
    }

    /**
     * This function get the Highlights advertisements from database.
     *
     * @return  array with the retrieved data.
     */
    public function getHighlightsAds(){
        $sql = 'SELECT advertisements.*, (SELECT name FROM categories WHERE advertisements.id_category = id) as category_name,
(SELECT name FROM categories WHERE advertisements.id_subcategory = id) as subcategory_name
FROM advertisements WHERE highlight = 1 AND status = 1';
        $sql = $this->db->query($sql);
        $array = $sql->fetchAll();

        foreach ($array as &$ad){
            $ad['medias'] = $this->medias_ads->getMedias($ad['id']);
        }
        return $array;
    }

    /**
     * This function search a advertisement in database by word.
     *
     * @param   $word   string for the search word
     * @return  array with the retrieved data.
     */
    public function getSearchAds($word){
        $array = array();
        $sql = "SELECT advertisements.*, (SELECT name FROM categories WHERE advertisements.id_category = id) as category_name,
(SELECT name FROM categories WHERE advertisements.id_subcategory = id) as subcategory_name
FROM advertisements WHERE (title LIKE '%".$word."%' OR abstract LIKE '%".$word."%') AND status = 1";
        $sql = $this->db->prepare($sql);
        $sql->execute(array());

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
            foreach ($array as &$ad) {
                $ad['medias'] = $this->medias_ads->getMedias($ad['id']);
            }
        }
        return $array;
    }

    /**
     * This function returns all advertisements in a area.
     *
     * @param   $id   int for the area id
     *
     * @return  array with the retrieved data.
     */
    public function getAdsByAreaId($id){
        $array = array();

        $sql = "SELECT advertisements.*, advertisements.id as id_ad, (SELECT name FROM categories WHERE advertisements.id_category = id) as category_name, (SELECT name FROM categories WHERE advertisements.id_subcategory = id) as subcategory_name FROM advertisements WHERE advertisements.id_category IN(SELECT id FROM categories WHERE id_area = ?)";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id));

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
            foreach ($array as $key => $item){
                $array[$key]['medias'] = $this->medias_ads->getMedias($item['id']);
            }
        }
        return $array;
    }

    /**
     * This function returns all advertisements in a category or subcategory.
     *
     * @param   $id     int for the category id
     * @param   $type   string for the category type (id_category, id_subcategory)
     *
     * @return  array with the retrieved data.
     */
    public function getAdsByCategoryId($id, $type){
        $array = array();

        if($type == 'id_category'){
            $sql = "SELECT advertisements.*, advertisements.id as id_ad, (SELECT name FROM categories WHERE advertisements.id_category = id) as category_name, (SELECT name FROM categories WHERE advertisements.id_subcategory = id) as subcategory_name FROM advertisements WHERE advertisements.id_category IN(SELECT id FROM categories WHERE id_category = ?)";
        }else{
            $sql = "SELECT advertisements.*, advertisements.id as id_ad, (SELECT name FROM categories WHERE advertisements.id_category = id) as category_name, (SELECT name FROM categories WHERE advertisements.id_subcategory = id) as subcategory_name FROM advertisements WHERE advertisements.id_category IN(SELECT id FROM categories WHERE id_subcategory = ?)";
        }

        $sql = $this->db->prepare($sql);
        $sql->execute(array($id));

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
            foreach ($array as $key => $item){
                $array[$key]['medias'] = $this->medias_ads->getMedias($item['id']);
            }
        }
        return $array;
    }

    /**
     * This function get the advertisement data from database by id code.
     *
     * @param   $id     int for the advertisement id.
     *
     * @return  array with the retrieved data.
     */
    public function getDataById($id){
        $array = array();

        $sql = 'SELECT advertisements.*, (SELECT name FROM categories WHERE advertisements.id_category = id) as name_category,
(SELECT name FROM categories WHERE advertisements.id_subcategory = id) as name_subcategory FROM advertisements WHERE id = ?';
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id));
        if($sql->rowCount() > 0){
            $array = $sql->fetch();
            $array['medias'] = $this->medias_ads->getMedias($array['id']);
        }

        return $array;
    }

    /**
     * This function get the advertisement data from database by slug code.
     *
     * @param   $slug     int for the advertisement slug.
     *
     * @return  array with the retrieved data.
     */
    public function getDataBySlug($slug){
        $array = array();

        $sql = 'SELECT advertisements.*, (SELECT name FROM categories WHERE advertisements.id_category = id) as category_name,
(SELECT name FROM categories WHERE advertisements.id_subcategory = id) as subcategory_name FROM advertisements WHERE slug = ?';
        $sql = $this->db->prepare($sql);
        $sql->execute(array($slug));
        if($sql->rowCount() > 0){
            $array = $sql->fetch();
            $array['medias'] = $this->medias_ads->getMedias($array['id']);
        }

        return $array;
    }

    /**
     * This function register a new advertisement in database.
     *
     * @param   $id_category    int for the category Advertisement ID.
     * @param   $id_subcategory    int for the subcategory Advertisement ID.
     * @param   $title    string for the Advertisement title.
     * @param   $abstract    string for the Advertisement abstract.
     * @param   $description    int for the Advertisement description.
     * @param   $status    int for the Advertisement internal status.
     * @param   $rating    int for the rating param.
     * @param   $highlight  int for the highlights param
     * @param   $new    int for the new param.
     * @param   $bestseller    int for the best seller param.
     * @param   $sale    int for the sale param.
     *
     * @return boolean true if success or false if failed.
     */
    public function register($id_category, $id_subcategory, $title, $abstract, $description, $status, $rating, $highlight = null, $new = null, $bestseller = null, $sale = null){
        $slug = $this->s->createSlug($title);
        $sql = 'SELECT * FROM advertisements WHERE slug = ? AND status = 1';
        $sql = $this->db->prepare($sql);
        $sql->execute(array($slug));
        if($sql->rowCount() > 0){
            return false;
        }else{
            $sql = 'INSERT INTO advertisements (id_category, id_subcategory, title, abstract, description, status, rating, highlight, new, bestseller, sale, slug) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $sql = $this->db->prepare($sql);
            $sql->execute(array($id_category, $id_subcategory, $title, $abstract, $description, $status, $rating, $highlight, $new, $bestseller, $sale, $slug));
            return $this->db->lastInsertId();
        }
    }

    /**
     * This function edit an advertisement using the its ID.
     *
     * @param   $id    int for the advertisement ID.
     * @param   $id_category    int for the category Advertisement ID.
     * @param   $id_subcategory    int for the subcategory Advertisement ID.
     * @param   $title    string for the Advertisement title.
     * @param   $abstract    string for the Advertisement abstract.
     * @param   $description    int for the Advertisement description.
     * @param   $status    int for the Advertisement internal status.
     * @param   $rating    int for the rating param.
     * @param   $new    int for the new param.
     * @param   $bestseller    int for the best seller param.
     * @param   $sale    int for the sale param.
     *
     * @return boolean true if success or false if failed.
     */
    public function edit($id, $id_category, $id_subcategory, $title, $abstract, $description, $status, $rating = null, $highlight = null, $new = null, $bestseller = null, $sale = null){
        $slug = $this->s->createSlug($title);
        $sql = 'SELECT * FROM advertisements WHERE slug = ? AND status = 1 AND id != ?';
        $sql = $this->db->prepare($sql);
        $sql->execute(array($slug, $id));
        if($sql->rowCount() > 0){
            return false;
        }else{
            $sql = 'UPDATE advertisements SET id_category = ?, id_subcategory = ?, title = ?, abstract = ?, description = ?, status = ?, rating = ?, highlight = ?, new = ?, bestseller = ?, sale = ?, slug = ? WHERE id = ?';
            $sql = $this->db->prepare($sql);
            $sql->execute(array($id_category, $id_subcategory, $title, $abstract, $description, $status, $rating, $highlight, $new, $bestseller, $sale, $slug, $id));
            return true;
        }
    }

    /**
     * This function delete an advertisement using the its ID.
     *
     * @param   $id    int for the advertisement ID.
     */
    public function delete($id){
        // Delete Medias
        $this->medias_ads->deleteAdvertisementMedias($id);
        // Delete Advertisement
        $sql = 'DELETE FROM advertisements WHERE id = ?';
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id));
    }

}