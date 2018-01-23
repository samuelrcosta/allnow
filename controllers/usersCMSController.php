<?php
/**
 * This class is the Controller of the Admin Users panel.
 *
 * @author  samuelrcosta
 * @version 1.0.0, 01/20/2017
 * @since   1.0, 01/20/2017
 */

class usersCMSController extends Controller{

    /**
     * Class constructor
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * This function shows the Admin Users List page.
     */
    public function index(){
        $u = new Administrators();
        $users = new Users();
        $c = new Categories();
        $data = array();

        if($u->isLogged()){
            $data['title'] = 'ADM - Usuários';
            $data['link'] = 'usersCMS/index';
            $data['userData'] = $u->getData(1, $_SESSION['adminLogin']);
            $data['usersData'] = $users->getList();

            $this->loadTemplateCMS('cms/users/index', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function receive a user id on Base64 (2x),
     * show the edit page with the user data, receive back
     * all edited data and update the database.
     * Finally headers to index page (usersCMS/index)
     */
    public function editUser($id){
        $u = new Administrators();
        $c = new Cities();
        $e = new States();
        $user = new Users();
        $data = array();

        $id = addslashes(base64_decode(base64_decode($id)));

        if($u->isLogged()){

            //Verify if exists POST for edit

            if(isset($_POST['name']) && !empty($_POST['name'])){
                $name = addslashes($_POST['name']);
                $cpf = addslashes($_POST['cpf']);
                $email = addslashes($_POST['email']);
                $telephone = addslashes($_POST['telephone']);
                $cellphone = addslashes($_POST['cellphone']);
                $street = addslashes($_POST['street']);
                $number = addslashes($_POST['number']);
                $complement = addslashes($_POST['complement']);
                $neighborhood = addslashes($_POST['neighborhood']);
                $zip_code = addslashes($_POST['zip_code']);
                $id_state = addslashes($_POST['id_state']);
                $id_city = addslashes($_POST['id_city']);

                if(!empty($name) && !empty($email) && !empty($id_state) && !empty($id_city)){
                    if($user->edit($id, $name, $cpf, $email, '', $telephone, $cellphone, $street, $number, $complement, $neighborhood, $zip_code, $id_state, $id_city)){
                        $msg = urlencode('Dados editados com sucesso.');
                        header("Location: " . BASE_URL . "usersCMS?notification=".$msg."&status=alert-success");
                    }else{
                        $data['usData']['name'] = $name;
                        $data['usData']['cpf'] = $cpf;
                        $data['usData']['email'] = $email;
                        $data['usData']['telephone'] = $telephone;
                        $data['usData']['cellphone'] = $cellphone;
                        $data['usData']['street'] = $street;
                        $data['usData']['number'] = $number;
                        $data['usData']['complement'] = $complement;
                        $data['usData']['neighborhood'] = $neighborhood;
                        $data['usData']['zip_code'] = $zip_code;
                        $data['usData']['id_state'] = $id_state;
                        $data['usData']['id_city'] = $id_city;
                        $data['notice'] = '<div class="alert alert-warning">O email digitado já está cadastrado em outra conta.</div>';
                    }
                }else{
                    $data['usData']['name'] = $name;
                    $data['usData']['cpf'] = $cpf;
                    $data['usData']['email'] = $email;
                    $data['usData']['telephone'] = $telephone;
                    $data['usData']['cellphone'] = $cellphone;
                    $data['usData']['street'] = $street;
                    $data['usData']['number'] = $number;
                    $data['usData']['complement'] = $complement;
                    $data['usData']['neighborhood'] = $neighborhood;
                    $data['usData']['zip_code'] = $zip_code;
                    $data['usData']['id_state'] = $id_state;
                    $data['usData']['id_city'] = $id_city;
                    $data['notice'] = '<div class="alert alert-warning">Preencha todos os campos.</div>';
                }
            }else{
                //If not, render editPage
                $data['usData'] = $user->getData(1, $id);
            }

            $data['title'] = 'ADM - Editar Usuário';
            $data['link'] = 'usersCMS/index';
            $data['states'] = $e->getList();
            $data['cities'] = $c->getCities($data['usData']['id_state']);
            $data['userData'] = $u->getData(1, $_SESSION['adminLogin']);

            $this->loadTemplateCMS('cms/users/editUser', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function receive a user id on Base64 (2x),
     * execute delete function and headers to index page (usersCMS/index)
     */
    public function deleteUser($id){
        $u = new Administrators();
        $user = new Users();

        $id = addslashes(base64_decode(base64_decode($id)));

        if($u->isLogged()){
            $user->delete($id);
            $msg = urlencode('Usuário deletado com sucesso.');
            header("Location: " . BASE_URL . "usersCMS?notification=".$msg."&status=alert-success");
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }
}