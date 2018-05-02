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

}
?>