<?php
/**
 * This class retrieves and saves data of the Brazil's states.
 *
 * @author  samuelrcosta
 * @version 1.0, 01/10/2017
 * @since   1.0
 */
class States extends Model{

    /**
     * This function retrieves all data from states's database.
     *
     * @return  array containing all data retrieved.
     */
    public function getList(){
        $sql = "SELECT * FROM states ORDER BY uf";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        $sql = $sql->fetchAll();
        return $sql;
    }
}