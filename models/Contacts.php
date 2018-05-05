<?php
/**
 * This class retrieves and saves data of the users contacts.
 *
 * @author  samuelrcosta
 * @version 1.0.0, 05/01/2018
 * @since   1.0.0, 05/01/2018
 */

class Contacts extends Model {

    /**
     * This function takes all data from the contacts database.
     *
     * @return  array containing all returned and rearranges data.
     */
    public function getList(){
        $array = array();

        $sql = "SELECT contacts.*, DATE_FORMAT(contacts.date_register, '%d/%m/%Y às %H:%i') as date FROM contacts ORDER BY id DESC";
        $sql = $this->db->query($sql);

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }

        return $array;
    }

    /**
     * This function takes all data from contact in database using its ID.
     *
     * @param   $id     int for the contact id.
     *
     * @return  array containing all returned and rearranges data.
     */
    public function getDataById($id){
        $array = array();

        $sql = "SELECT contacts.*, DATE_FORMAT(contacts.date_register, '%d/%m/%Y às %H:%i') as date FROM contacts WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id));

        if($sql->rowCount() > 0){
            $array = $sql->fetch();
        }

        return $array;
    }

    /**
     * This function register a new contact in database.
     *
     * @param   $name           string for the user's name.
     * @param   $email          string for the user's e-mail.
     * @param   $phone          string for the user's phone.
     * @param   $subject        string for the user's message subject.
     * @param   $message        string for the user's message.
     *
     */
    public function register($name, $email, $phone, $subject, $message){
        $sql = "INSERT INTO contacts (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($name, $email, $phone, $subject, $message));
    }

    /**
     * This function update a contact status if its exists
     *
     * @param   $id           string for the user's name.
     * @param   $status          string for the user's e-mail.
     *
     * @return boolean true for success delete, false if this contacts not exists
     *
     */
    public function setStatus($id, $status){
        // Checks if the contact exists
        $sql = "SELECT COUNT(*) as TOTAL FROM contacts WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id));
        $sql = $sql->fetch();
        if($sql["TOTAL"] > 0){
            $sql = "UPDATE contacts SET status = ? WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($status, $id));
            return true;
        }else{
            return false;
        }
    }

    /**
     * This function delete a contact, if this exists.
     *
     * @param   $id   int for the contact id
     *
     * @return boolean true for success delete, false if this contacts not exists
     */
    public function delete($id){
        // Checks if the contact exists
        $sql = "SELECT COUNT(*) as TOTAL FROM contacts WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id));
        $sql = $sql->fetch();
        if($sql["TOTAL"] > 0){
            $sql = "DELETE FROM contacts WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($id));
            return true;
        }else{
            return false;
        }
    }

}
?>