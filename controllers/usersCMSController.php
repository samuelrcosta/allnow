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
            $data['usersData'] = $u->getList();

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
        $data = array();

        $id = addslashes(base64_decode(base64_decode($id)));

        if($u->isLogged()){

            //Verify if exists POST for edit

            if(isset($_POST['name']) && !empty($_POST['name'])){
                $name = addslashes($_POST['name']);
                $email = addslashes($_POST['email']);

                if(!empty($name) && !empty($email)){
                    if($u->edit($id, $name, $email, '')){
                        $msg = urlencode('Dados editados com sucesso.');
                        header("Location: " . BASE_URL . "usersCMS?notification=".$msg."&status=alert-success");
                    }else{
                        $data['usData']['name'] = $name;
                        $data['usData']['email'] = $email;
                        $data['notice'] = '<div class="alert alert-warning">O email digitado já está cadastrado em outra conta.</div>';
                    }
                }else{
                    $data['usData']['name'] = $name;
                    $data['usData']['email'] = $email;
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