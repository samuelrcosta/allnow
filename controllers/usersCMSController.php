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
        $c = new Categories();
        $data = array();

        $id = addslashes(base64_decode(base64_decode($id)));

        if($u->isLogged()){

            //Verify if exists POST for edit

            if(isset($_POST['name']) && !empty($_POST['name'])){
                $name = addslashes($_POST['name']);

                if(!empty($name)){
                    if($c->edit($id, $name)){
                        $msg = urlencode('Categoria editada com sucesso!');
                        header("Location: ".BASE_URL."categoriesCMS?notification=".$msg."&status=alert-info");
                        exit;
                    }else{
                        $data['name'] = $name;
                        $data['notice'] = '<div class="alert alert-warning">Já existe categoria com esse mesmo nome.</div>';
                    }
                }else{
                    $data['name'] = $name;
                    $data['notice'] = '<div class="alert alert-warning">Preencha todos os campos.</div>';
                }
            }else{
                //If not, render editPage
                $data['categoryData'] = $c->getCategoryTree($id);
                $data['name'] = $data['categoryData']['0']['name'];
            }

            $data['title'] = 'ADM - Editar Categoria';
            $data['link'] = 'categoriesCMS/index';
            $data['userData'] = $u->getData(1, $_SESSION['adminLogin']);

            $this->loadTemplateCMS('cms/categories/editCategory', $data);
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
        $c = new Categories();

        $id = addslashes(base64_decode(base64_decode($id)));

        if($u->isLogged()){
            $c->delete($id);
            header("Location: ".BASE_URL."categoriesCMS");
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }
}