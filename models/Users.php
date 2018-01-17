<?php
/**
 * This class retrieves and saves data of the user.
 *
 * @author  samuelrcosta
 * @version 1.0.1, 01/11/2017
 * @since   1.0, 01/10/2017
 */

class Users extends Model{

    /**
     * This function verify if the input is valid for any account registered.
     * If valid returns True, otherwise return False for false.
     *
     * @param   $email    string for the email registered for the account.
     * @param   $password    string for the current password.
     * @return  boolean True for the correct user ID, or False for 'user not found'.
     */
    public function login($email, $password){
        $sql = "SELECT id FROM users WHERE email = ? AND password = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($email, md5($password)));
        $sql = $sql->fetch(PDO::FETCH_ASSOC);
        if($sql && count($sql)){
            $_SESSION['idLogin'] = $sql['id'];
            return True;
        }else{
            return False;
        }
    }

    /**
     * This function register a new user in database.
     * If this email already registered returns False, else returns True.
     *
     * @param   $name       string for the user's name.
     * @param   $email      string for the user's email.
     * @param   $password   string for the user's password.
     * @param   $id_state   int for the user's state ID.
     * @param   $id_city    int for the user's city ID.
     * @return  boolean     boolean false for email already registered, or instead True.
     */
    public function register($name, $email, $password, $id_state, $id_city){
        $sql = "SELECT * FROM users WHERE email = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($email));
        $sql = $sql->fetchAll();
        if($sql && count($sql)){
            return false;
        }else{
            $sql = "INSERT INTO users (email, password, name, id_state, id_city) VALUES (?, ?, ?, ?, ?)";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($email, md5($password), $name, $id_state, $id_city));
            return true;
        }
    }

    /**
     * This function edit a user in database.
     * If this email already registered returns False, else returns True.
     *
     * @param   $id             int for the user's ID number saved in the database.
     * @param   $name           string for the user's name.
     * @param   $cpf            string for the user's cpf.
     * @param   $email          string for the user's email.
     * @param   $password       string for the user's password.
     * @param   $telephone      string for the user's telephone.
     * @param   $cellphone      string for the user's cellphone.
     * @param   $street         string for the user's address street.
     * @param   $number         string for the user's address number.
     * @param   $complement     string for the user's address complement.
     * @param   $neighborhood   string for the user's address neighborhood.
     * @param   $zip_code       string for the user's zip code.
     * @param   $id_state       int for the user's state ID.
     * @param   $id_city        int for the user's city ID.
     *
     * @return  boolean False for email already registered, or instead True.
     */
    public function edit($id, $name, $cpf, $email, $password, $telephone, $cellphone, $street, $number, $complement, $neighborhood, $zip_code, $id_state, $id_city){
        $sql = "SELECT * FROM users WHERE email = ? AND id != ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($email, $id));
        $sql = $sql->fetchAll();
        if($sql && count($sql)){
            return false;
        }else{
            if(empty($password)){
                $sql = "UPDATE users SET email = ?, name = ?, cpf = ?, telephone = ?, cellphone = ?, street = ?, number = ?, complement = ?, neighborhood = ?, zip_code = ?, id_state = ?, id_city = ? WHERE id = ?";
                $sql = $this->db->prepare($sql);
                $sql->execute(array($email, $name, $cpf, $telephone, $cellphone, $street, $number, $complement, $neighborhood, $zip_code, $id_state, $id_city, $id));
                return true;
            }else{
                $sql = "UPDATE users SET email = ?, password = ?, name = ?, cpf = ?, telephone = ?, cellphone = ?, street = ?, number = ?, complement = ?, neighborhood = ?, zip_code = ?, id_state = ?, id_city = ? WHERE id = ?";
                $sql = $this->db->prepare($sql);
                $sql->execute(array($email, md5($password), $name, $cpf, $telephone, $cellphone, $street, $number, $complement, $neighborhood, $zip_code, $id_state, $id_city, $id));
                return true;
            }
        }
    }

    /**
     * This function delete a user in database.
     *
     * @param   $id       int for the user's ID number saved in the database.
     */
    public function delete($id){
        $sql = "DELETE FROM users WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id));
    }

    /**
     * Function used to logoff the user in the session.
     */
    public function logOff(){
        unset($_SESSION['idLogin']);
    }

    /**
     * Function checks if someone is logged.
     *
     * @return  boolean for the result.
     */
    public function isLogged(){
        if(isset($_SESSION['idLogin']) && !empty($_SESSION['idLogin'])){
            return true;
        }else{
            return false;
        }
    }

    /**
     * This function retrieves all data from an user, by using it's ID or it's Email.
     *
     * @param   $type          int for the type of search, 1 to ID and 2 to Email
     * @param   $idOrEmail     string user's ID number or Email saved in the database.
     * @return  array containing all data retrieved.
     */
    public function getData($type, $idOrEmail){
        $array = array();
        if($type == 1){
            $sql = "SELECT * FROM users WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($idOrEmail));
            $sql = $sql->fetch();
            if($sql && count($sql)){
                $c = new Cities();
                $s = new States();
                $cities = $c->getList();
                $states = $s->getList();
                $array = $sql;
                $array['city'] = '';
                $array['state'] = '';
                foreach ($cities as $city){
                    if($city['id'] == $array['id_city']){
                        $array['city'] = $city['name'];
                    }
                }
                foreach ($states as $state){
                    if($state['id'] == $array['id_state']){
                        $array['state'] = $state['name'];
                    }
                }
            }
        }else{
            $sql = "SELECT * FROM users WHERE email = ?";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($idOrEmail));
            $sql = $sql->fetch();
            if($sql && count($sql)){
                $c = new Cities();
                $s = new States();
                $cities = $c->getList();
                $states = $s->getList();
                $array = $sql;
                $array['city'] = '';
                $array['state'] = '';
                foreach ($cities as $city){
                    if($city['id'] == $array['id_city']){
                        $array['city'] = $city['name'];
                    }
                }
                foreach ($states as $state){
                    if($state['id'] == $array['id_state']){
                        $array['state'] = $state['name'];
                    }
                }
            }
        }

        return $array;
    }

    /**
     * This function changes the recuperation code of the user's password using his ID
     *
     * @param   $id                 int for the user's ID.
     * @param   $hashRecover    string for the user's password recuperation code.
     */
    public function setHashRecuperacao($id, $hashRecover){
        $sql = "UPDATE users SET hashRecover = ? WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($hashRecover, $id));
    }

    /**
     * This function changes the recuperation code of the user's password using his ID
     *
     * @param   $hashRecover    string for the user's password recuperation code.
     * @return  array containing all data retrieved.
     */
    public function getDataByRecoverHash($hashRecover){
        $sql = "SELECT * FROM users WHERE hashRecover = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($hashRecover));
        $sql = $sql->fetch();
        return $sql;
    }

    /**
     * This function sends a password recovery link to the user using your email.
     *
     * @param   $email   string for the user's email.
     * @return  boolean true if the email exists in database or false if not.
     */
    public function recoverPassword($email){
        $userData = $this->getData(2, $email);
        if(!empty($userData)){
            $hashRecover = md5(time().rand(0,9999));
            $this->setHashRecuperacao($userData['id'], $hashRecover);
            $subject = "Classi-O - Recuperar Senha";
            $message = "<html xmlns=\"http://www.w3.org/1999/xhtml\">
                    <head>
                        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
                        <title>".$subject."</title>
                    </head>
                    <body paddingwidth=\"0\" paddingheight=\"0\" bgcolor=\"#d1d3d4\" style=\"padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;\" offset=\"0\" toppadding=\"0\" leftpadding=\"0\">
                        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                            <tbody>
                                <tr>
                                    <td>Olá ".$userData['name']."</td>
                                </tr>
                                <tr>
                                    <td>Recebemos sua solicitação de alteração de senha</td>
                                </tr>
                                <tr>
                                    <td>Para alterar sua senha <a href='".BASE_URL."login/recoverPassword/".$hashRecover."'>clique aqui</a></td>
                                </tr>
                                <tr>
                                    <td>     </td>
                                </tr>
                                <tr>
                                    <td>Caso não seja você que tenha feito essa solicitação, apenas ignore esse e-mail.</td>
                                </tr>
                                <tr>
                                    <td>     </td>
                                </tr>
                                <tr>
                                    <td>     </td>
                                </tr>
                                <tr>
                                    <td>     </td>
                                </tr>
                            </tbody>
                        </table>
                    </body>
                </html>";
            $recipients = array();
            $recipients[] = array(
                'email' => $userData['email'],
                'name' => $userData['name']
            );
            $store = new Store();
            return $store->sendMail($recipients, $subject, $message);
        }else{
            return False;
        }
    }

}
?>