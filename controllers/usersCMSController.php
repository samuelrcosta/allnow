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

        if($u->isLogged() && $u->havePermission('users')){
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

        if($u->isLogged() && $u->havePermission('users')){
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
        if($u->isLogged() && $u->havePermission('users')){
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
                            // Build the permissions
                            $perms = "";
                            if(isset($_POST['menuAds']))
                                $perms .= "ads;";
                            if(isset($_POST['menuUsers']))
                                $perms .= "users;";
                            if(isset($_POST['menuContacts']))
                                $perms .= "contacts;";
                            if(isset($_POST['menuCategories']))
                                $perms .= "categories;";
                            if(isset($_POST['menuSubcategories']))
                                $perms .= "subcats;";
                            if(isset($_POST['menuHomeTutorial']))
                                $perms .= "homeTutorial;";
                            // Try to register
                            if($u->register($name, $email, $perms, $password)){
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
     * This function shows users editPage
     */
    public function editUserPage($id){
        $u = new Administrators();
        $data = array();

        if($u->isLogged() && $u->havePermission('users')){
            $id = addslashes(base64_decode(base64_decode($id)));
            $data['title'] = 'ADM - Editar Usuário';
            $data['link'] = 'usersCMS/index';
            $data['userData'] = $u->getData(1, $_SESSION['adminLogin']);
            $data['usData'] = $u->getData(1, $id);
            $this->loadTemplateCMS('cms/users/editUser', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function edit a user using POST request
     */
    public function editUser(){
        $u = new Administrators();

        if($u->isLogged() && $u->havePermission('users')){
            if(!empty($_POST)){
                $s = new Store();
                // Array for check the keys
                $keys = array('id', 'email', 'name');
                if($s->array_keys_check($keys, $_POST)){
                    // Check if the array is completed
                    if($s->array_check_completed_keys($keys, $_POST)){
                        $id = addslashes($_POST['id']);
                        $email = addslashes($_POST['email']);
                        $name = addslashes($_POST['name']);
                        $password = addslashes($_POST['password']);
                        $password_confirmation = addslashes($_POST['password_confirmation']);
                        // Checks passwords
                        if($password == $password_confirmation){
                            // Build the permissions
                            $perms = "";
                            if(isset($_POST['menuAds']))
                                $perms .= "ads;";
                            if(isset($_POST['menuUsers']))
                                $perms .= "users;";
                            if(isset($_POST['menuContacts']))
                                $perms .= "contacts;";
                            if(isset($_POST['menuCategories']))
                                $perms .= "categories;";
                            if(isset($_POST['menuSubcategories']))
                                $perms .= "subcats;";
                            if(isset($_POST['menuHomeTutorial']))
                                $perms .= "homeTutorial;";
                            // Try to register
                            if($u->edit($id, $name, $email, $perms, $password)){
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

        if($u->isLogged() && $u->havePermission('users')){
            $id = addslashes(base64_decode(base64_decode($id)));
            $u->delete($id);
            $msg = urlencode('Usuário deletado com sucesso.');
            header("Location: " . BASE_URL . "usersCMS?notification=".$msg."&status=alert-success");
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }
}