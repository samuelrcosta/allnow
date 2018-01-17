<?php
/**
 * This class is the Controller of the User data pages.
 *
 * @author  samuelrcosta
 * @version 1.0, 01/11/2017
 * @since   1.0, 01/11/2017
 */
class userController extends Controller{

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * This page not exists, redirect to login page.
     */
    public function index(){
        header("Location: ".BASE_URL."login");
        exit;
    }

    /**
     * This page shows user data, if the user is logged in.
     */
    public function account(){
        $u = new Users();
        $data = array();
        if($u->isLogged()){
            $userData = $u->getData(1, $_SESSION['idLogin']);
            $data['title'] = 'Minha Conta';
            $data['userData'] = $userData;
            $this->loadTemplate('user/account', $data);
        }else{
            header("Location: ".BASE_URL."login");
            exit;
        }
    }

    /**
     * This function checks if the user if logged in, if so shows the user data editing page.
     * Receive the input data and use the user's edit method.
     */
    public function editAccount(){
        $u = new Users();
        $e = new States();
        $c = new Cities();
        $data = array();
        if($u->isLogged()) {
            $userData = $u->getData(1, $_SESSION['idLogin']);
            $data['title'] = 'Minha Conta';
            $data['userData'] = $userData;
            $data['states'] = $e->getList();
            $data['cities'] = $c->getCities($userData['id_state']);

            if(isset($_POST['name']) && !empty($_POST['name']) ) {
                $name = addslashes($_POST['name']);
                $cpf = addslashes($_POST['cpf']);
                $email = addslashes($_POST['email']);
                $password = addslashes($_POST['password']);
                $newPassword = addslashes($_POST['newPassword']);
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
                    if($password != "" || $newPassword != ""){
                        if($u->login($email, $password)){
                            if ($u->edit($_SESSION['idLogin'], $name, $cpf, $email, $newPassword, $telephone, $cellphone, $street, $number, $complement, $neighborhood, $zip_code, $id_state, $id_city)){
                                $msg = urlencode('Dados editados com sucesso.');
                                header("Location: " . BASE_URL . "user/account?notification=".$msg."&status=alert-success");
                            }else{
                                $data['notice'] = '<div class="alert alert-warning">O email digitado já está cadastrado em outra conta.</div>';
                            }
                        }else{
                            $data['notice'] = '<div class="alert alert-danger">Senha incorreta.</div>';
                        }
                    }else{
                        if($u->edit($_SESSION['idLogin'], $name, $cpf, $email, '', $telephone, $cellphone, $street, $number, $complement, $neighborhood, $zip_code, $id_state, $id_city)){
                            $msg = urlencode('Dados editados com sucesso.');
                            header("Location: " . BASE_URL . "user/account?notification=".$msg."&status=alert-success");
                        }else{
                            $data['notice'] = '<div class="alert alert-warning">O email digitado já está cadastrado em outra conta.</div>';
                        }
                    }
                }else{
                    $data['notice'] = '<div class="alert alert-warning">Preencha todos os campos obrigatórios</div>';
                }
            }
            $this->loadTemplate('user/editAccount', $data);
        }else{
            header("Location: ".BASE_URL."login");
            exit;
        }
    }

    /**
     * This function use the user's delete method and redirects to homepage
     */
    public function deleteAccount(){
        $u = new Users();

        if($u->isLogged()) {
            $u->delete($_SESSION['idLogin']);
            $u->logOff();
            header("Location: ".BASE_URL);
        }else{
            header("Location: ".BASE_URL."login");
            exit;
        }
    }

    /**
     * This function shows user advertisements, if it's logged in
     */
    public function advertisements(){
        $u = new Users();
        $a = new Advertisements();
        $data = array();

        if($u->isLogged()) {
            $data['title'] = "Meus Anúncios";
            $data['adsData'] = $a->getUserAds($_SESSION['idLogin']);
            $this->loadTemplate('user/advertisements', $data);
        }else{
            header("Location: ".BASE_URL."login");
            exit;
        }
    }
}