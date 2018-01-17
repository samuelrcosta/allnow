<?php
/**
 * This class retrieves and saves data of the Brazil's cities.
 *
 * @author  samuelrcosta
 * @version 1.0, 01/10/2017
 * @since   1.0
 */
class Cities extends Model{

    /**
     * This function retrieves all data from citys's database using the state ID.
     *
     * @param   $id_state  int for the state ID.
     * @return  array containing all data retrieved.
     */
    public function getCities($id_state){
        $sql = "SELECT * FROM cities WHERE id_state = ? ORDER BY name";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id_state));
        $sql = $sql->fetchAll();
        return $sql;
    }

    /**
     * This function retrieves all data from citys's database.
     *
     * @return  array containing all data retrieved.
     */
    public function getList(){
        $sql = "SELECT * FROM cities";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        $sql = $sql->fetchAll();
        return $sql;
    }
}