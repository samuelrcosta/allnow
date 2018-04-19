<?php
/**
 * This class retrieves and saves data of the users advertisements.
 *
 * @author  samuelrcosta
 * @version 1.1.1, 04/18/2017
 * @since   1.0, 01/11/2017
 */


class Advertisements extends Model{


    /**
     * This function get the Admin advertisements from database.
     *
     * @return  array with the retrieved data.
     */
    public function getAdminAds(){
        $c = new Categories();
        $m = new Medias_ads();

        $sql = 'SELECT * FROM advertisements WHERE status = 1';
        $sql = $this->db->query($sql);
        $array = $sql->fetchAll();

        foreach ($array as &$ad){
            $ad['category_name'] = $c->getNameById($ad['id_category']);
            $ad['subcategory_name'] =  $c->getNameById($ad['id_subcategory']);
            $ad['medias'] = $m->getMedias($ad['id']);
        }

        return $array;
    }

    public function getList($categories = array(), $filters = array()){
        $c = new Categories();
        $m = new Medias_ads();
        $array = array();

        $where = 'WHERE status = 1';

        if(isset($categories['id_subcategory'])){
            $where = 'WHERE id_subcategory = '.$categories['id_subcategory'].' AND status = 1';
        }
        if(isset($categories['id_category'])){
            $where = 'WHERE id_category = '.$categories['id_category'].' AND status = 1';
        }
        if(isset($filters['id_state']) && !empty($filters['id_state'])){
            $where = $where.' AND id_state = '.$filters['id_state'];
        }
        if(isset($filters['id_city']) && !empty($filters['id_city'])){
            $where = $where.' AND id_city = '.$filters['id_city'];
        }

        $sql = 'SELECT *, advertisements.id as id_ad FROM advertisements '.$where;
        $sql = $this->db->query($sql);

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
            foreach ($array as $key => $item){
                $array[$key]['category_name'] = $c->getNameById($item['id_category']);
                $array[$key]['subcategory_name'] = $c->getNameById($item['id_subcategory']);
                $array[$key]['medias'] = $m->getMedias($item['id']);
            }
        }

        return $array;
    }

    /**
     * This function get the Highlights advertisements from database.
     *
     * @return  array with the retrieved data.
     */
    public function getHighlightsAds(){
        $c = new Categories();
        $m = new Medias_ads();
        $sql = 'SELECT * FROM advertisements WHERE highlight = 1 AND status = 1';
        $sql = $this->db->query($sql);
        $array = $sql->fetchAll();

        foreach ($array as &$ad){
            $ad['category_name'] = $c->getNameById($ad['id_category']);
            $ad['subcategory_name'] =  $c->getNameById($ad['id_subcategory']);
            $ad['medias'] = $m->getMedias($ad['id']);
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
        $c = new Categories();
        $m = new Medias_ads();
        $array = array();

        $sql = 'SELECT * FROM advertisements WHERE id = ?';
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id));
        if($sql->rowCount() > 0){
            $array = $sql->fetch();
            $array['category_name'] = $c->getNameById($array['id_category']);
            $array['subcategory_name'] =  $c->getNameById($array['id_subcategory']);
            $array['medias'] = $m->getMedias($array['id']);
        }

        return $array;
    }

    /**
     * This function returns the last inserted ID.
     *
     * @return int for the ID.
     */
    public function getLastId(){

    }

    /**
     * This function get the advertisements from database using the user ID.
     *
     * @param   $id_user    int for the user ID.
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
    public function register($id_user, $id_category, $id_subcategory, $title, $abstract, $description, $status, $rating, $highlight = null, $new = null, $bestseller = null, $sale = null){
        $s = new Store();
        $slug = $s->createSlug($title);
        $sql = 'SELECT * FROM advertisements WHERE slug = ? AND status = 1';
        $sql = $this->db->prepare($sql);
        $sql->execute(array($slug));
        if($sql->rowCount() > 0){
            return false;
        }else{
            $sql = 'INSERT INTO advertisements (id_user, id_category, id_subcategory, title, abstract, description, status, rating, highlight, new, bestseller, sale, slug) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $sql = $this->db->prepare($sql);
            $sql->execute(array($id_user, $id_category, $id_subcategory, $title, $abstract, $description, $status, $rating, $highlight, $new, $bestseller, $sale, $slug));
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
        $s = new Store();
        $slug = $s->createSlug($title);
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
     * This function inactivate an advertisement using the its ID.
     *
     * @param   $id    int for the advertisement ID.
     */
    public function inactivate($id){
        $sql = 'UPDATE advertisements SET status = 0 WHERE id = ?';
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id));
    }

    /**
     * This function delete all user's advertisements.
     *
     * @param   $id_user    int for the user ID.
     */
    public function deleteUserAds($id_user){
        $sql = 'DELETE FROM advertisements WHERE id_user = ? AND type = 1';
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id_user));
    }

    /**
     * This function build a where part of sql query for filters in Category List.
     *
     * @param   $filters     array for filters.
     *
     * @return array for where clause.
     */
    private function buildWhere($filters){
        $where = array('1=1');

        if(!empty($filters['category'])){
            $where[] = 'id_category = :id_category';
        }

        if(!empty($filters['subcategory'])){
            $where[] = 'id_subcategory = :id_subcategory';
        }

        if(!empty($filters['searchTerm'])){
            $where[] = "title LIKE :searchTerm";
        }

        return $where;
    }

    /**
     * This function bind values in query for filters in Category List.
     *
     * @param   $filters     array for filters.
     * @param   $sql    string for the sql query.
     */
    private function bindWhere($filters, &$sql){
        if(!empty($filters['category'])){
            $sql->bindValue(':id_category', $filters['category']);
        }

        if(!empty($filters['subcategory'])){
            $sql->bindValue(':id_subcategory', $filters['id_subcategory']);
        }

        if(!empty($filters['searchTerm'])){
            $sql->bindValue(':searchTerm', '%'.$filters['searchTerm'].'%');
        }
    }
}