<?php
/**
 * This class retrieves and saves data of the users advertisements.
 *
 * @author  samuelrcosta
 * @version 1.0.1, 01/12/2017
 * @since   1.0, 01/11/2017
 */


class Advertisements extends Model{

    /**
     * This function get the advertisements from database using the user ID.
     *
     * @param   $id_user    int for the user ID.
     * @return  array with the retrieved data.
     */
    public function getUserAds($id_user){
        $sql = "SELECT * FROM advertisements WHERE id_user = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id_user));
        return $sql->fetchAll();
    }

    /**
     * This function get the advertisements from database using the user ID.
     *
     * @param   $id_user    int for the user ID.
     * @param   $id_category    int for the category Advertisement ID.
     * @param   $id_subcategory    int for the subcategory Advertisement ID.
     * @param   $title    string for the Advertisement title.
     * @param   $abstract    string for the Advertisement abstract.
     * @param   $media    string for the Advertisement media.
     * @param   $description    int for the Advertisement description.
     * @param   $status    int for the Advertisement internal status.
     * @param   $type    int for the Advertisement type.
     * @param   $rating    int for the rating param.
     * @param   $new    int for the new param.
     * @param   $bestseller    int for the best seller param.
     * @param   $sale    int for the sale param.
     */
    public function register($id_user, $id_category, $id_subcategory, $title, $abstract, $media, $description, $status, $type, $rating = 0, $new = 0, $bestseller = 0, $sale = 0){
        $sql = 'INSERT INTO advertisements (id_user, id_category, id_subcategory, title, abstract, media, description, status, type, rating, new, bestseller, sale) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id_user, $id_category, $id_subcategory, $title, $abstract, $media, $description, $status, $type, $rating, $new, $bestseller, $sale));
    }
}