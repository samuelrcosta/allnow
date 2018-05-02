<?php
/**
 * This class is the Controller of the Admin Categories panel.
 *
 * @author  samuelrcosta
 * @version 1.1.0, 05/02/2018
 * @since   1.0, 01/15/2017
 */

class categoriesCMSController extends Controller{

    /**
     * Class constructor
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * This function shows the Admin Categories List page.
     */
    public function index(){
        $u = new Administrators();
        $c = new Categories();
        $data = array();

        if($u->isLogged()){
            $data['title'] = 'ADM - Categorias';
            $data['link'] = 'categoriesCMS/index';
            $data['userData'] = $u->getData(1, $_SESSION['adminLogin']);
            $data['categoriesData'] = $c->getList();

            $this->loadTemplateCMS('cms/categories/index', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function shows the Admin Categories register page.
     */
    public function newCategory(){
        $u = new Administrators();
        $c = new Categories();
        $data = array();

        if($u->isLogged()){
            //Verify if exists POST for a new register

            if(isset($_POST['name']) && !empty($_POST['name'])){
                $name = addslashes($_POST['name']);

                if(!empty($name)){
                    if($c->register($name)){
                        $msg = urlencode('Categoria registrada com sucesso!');
                        header("Location: ".BASE_URL."categoriesCMS?notification=".$msg."&status=alert-info");
                        exit;
                    }else{
                        $data['name'] = $name;
                        $data['notice'] = '<div class="alert alert-warning">Essa categoria já está cadastrada.</div>';
                    }
                }else{
                    $data['name'] = $name;
                    $data['notice'] = '<div class="alert alert-warning">Preencha todos os campos.</div>';
                }
            }

            $data['title'] = 'ADM - Nova Categoria';
            $data['link'] = 'categoriesCMS/index';
            $data['userData'] = $u->getData(1, $_SESSION['adminLogin']);

            $this->loadTemplateCMS('cms/categories/newCategory', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function receive a category id on Base64 (2x),
     * show the edit page with the category data, receive back
     * all edited data and update the database.
     * Finally headers to index page (categoriesCMS/index)
     */
    public function editCategory($id){
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
                        $data['categoryData']['name'] = $name;
                        $data['notice'] = '<div class="alert alert-warning">Já existe categoria com esse mesmo nome.</div>';
                    }
                }else{
                    $data['categoryData']['name'] = $name;
                    $data['notice'] = '<div class="alert alert-warning">Preencha todos os campos.</div>';
                }
            }else{
                //If not, render editPage
                $data['categoryData'] = $c->getCategoryTree($id)['0'];
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
     * This function receive a category id on Base64 (2x),
     * execute delete function and headers to index page (categoriesCMS/index)
     */
    public function deleteCategory($id){
        $u = new Administrators();
        $c = new Categories();

        $id = addslashes(base64_decode(base64_decode($id)));

        if($u->isLogged()){
            $c->delete($id, 'id_category');
            header("Location: ".BASE_URL."categoriesCMS");
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }
}