<?php
/**
 * This class is the Controller of the Admin Users panel.
 *
 * @author  samuelrcosta
 * @version 1.2.0, 05/05/2018
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
        $data = array();

        if($u->isLogged()){
            $data['title'] = 'ADM - Usuários';
            $data['link'] = 'usersCMS/index';
            $data['userData'] = $u->getData(1, $_SESSION['adminLogin']);
            $data['usersData'] = $u->getList();

            $this->loadTemplateCMS('cms/users/index', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function shows the register page for a new user.
     */
    public function newUser(){
        $u = new Administrators();
        $data = array();

        if($u->isLogged()){
            $data['title'] = 'ADM - Novo usuário';
            $data['link'] = 'usersCMS/index';
            $data['userData'] = $u->getData(1, $_SESSION['adminLogin']);

            $this->loadTemplateCMS('cms/users/newUser', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function register a new user in database, with POST request
     */
    public function saveNewUser(){
        $u = new Administrators();
        if($u->isLogged()){
            if(!empty($_POST)){
                $s = new Store();
                // Array for check the keys
                $keys = array('email', 'name', 'password', 'password_confirmation');
                if($s->array_keys_check($keys, $_POST)){
                    // Check if the array is completed
                    if($s->array_check_completed_keys($keys, $_POST)){
                        $email = addslashes($_POST['email']);
                        $name = addslashes($_POST['name']);
                        $password = addslashes($_POST['password']);
                        $password_confirmation = addslashes($_POST['password_confirmation']);
                        // Checks passwords
                        if($password == $password_confirmation){
                            // Try to register
                            if($u->register($name, $email, $password)){
                                echo json_encode(true);
                            }else{
                                echo json_encode("E-mail já cadastrado.");
                            }
                        }else{
                            echo json_encode("Confirmação de senha inválida.");
                        }
                    }else{
                        echo json_encode("Dados incompletos.");
                    }
                }else{
                    echo json_encode("Dados corrompidos.");
                }
            }
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
        $data = array();

        $id = addslashes(base64_decode(base64_decode($id)));

        if($u->isLogged()){

            //Verify if exists POST for edit

            if(isset($_POST['name']) && !empty($_POST['name'])){
                $name = addslashes($_POST['name']);
                $email = addslashes($_POST['email']);
                $password = addslashes($_POST['password']);
                $passConfirm = addslashes($_POST['password_confirmation']);

                $data['usData']['name'] = $name;
                $data['usData']['email'] = $email;

                if(!empty($name) && !empty($email)){
                    // Checks passwords
                    if($password == $passConfirm){
                        if($u->edit($id, $name, $email, $password)){
                            $msg = urlencode('Dados editados com sucesso.');
                            header("Location: " . BASE_URL . "usersCMS?notification=".$msg."&status=alert-success");
                        }else{
                            $data['notice'] = '<div class="alert alert-warning">O email digitado já está cadastrado em outra conta.</div>';
                        }
                    }else{
                        $data['notice'] = '<div class="alert alert-warning">Confirmação de senha inválida.</div>';
                    }
                }else{
                    $data['notice'] = '<div class="alert alert-warning">Preencha todos os campos.</div>';
                }
            }else{
                //If not, render editPage
                $data['usData'] = $u->getData(1, $id);
            }

            $data['title'] = 'ADM - Editar Usuário';
            $data['link'] = 'usersCMS/index';
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