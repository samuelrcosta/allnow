<?php
/**
 * This class retrieves and saves data of the users advertisements medias.
 *
 * @author  samuelrcosta
 * @version 1.0.0, 04/10/2018
 * @since   1.0.0, 04/10/2018
 */


class Medias_ads extends Model{

    /**
     * This function registrer a new advertisement media in database.
     *
     * @param   $id_advertisement    int for the advertisement ID.
     * @param   $media    string for the embeded media.
     * @param   $media_type    int for the type of media.
     * @param   $media_link   string for the media content.
     *
     */
    public function register($id_advertisement, $media, $media_type, $media_link){
        $sql = 'INSERT INTO medias_ads (id_advertisement, media, media_type, media_link) VALUES(?, ?, ?, ?)';
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id_advertisement, $media, $media_type, $media_link));
    }

    /**
     * This function get the medias from database using the advertisement ID.
     *
     * @param   $id_advertisement    int for the advertisement ID.
     *
     * @return array with the media data
     *
     */
    public function getMedias($id_advertisement){
        $return = array();
        $sql = "SELECT * FROM medias_ads WHERE id_advertisement = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id_advertisement));
        $sql = $sql->fetchAll();
        if($sql && count($sql)){
            $return = $sql;
        }
        return $return;
    }

    /**
     * This function delete a media in database.
     *
     * @param   $id_media    int for the media ID.
     */
    public function deleteMedia($id_media){
        $sql = 'DELETE FROM medias_ads WHERE id = ?';
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id_media));
    }

    /**
     * This function delete all advertisement medias with link in database.
     *
     * @param   $id_advertisement    int for the media ID.
     */
    public function deleteLinksMedias($id_advertisement){
        $sql = 'DELETE FROM medias_ads WHERE id_advertisement = ? AND media_type <> 3';
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id_advertisement));
    }

    /**
     * This function delete all advertisement medias in database.
     *
     * @param   $id_advertisement    int for the media ID.
     */
    public function deleteAdvertisementMedias($id_advertisement){
        $sql = 'DELETE FROM medias_ads WHERE id_advertisement = ?';
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id_advertisement));
    }
}