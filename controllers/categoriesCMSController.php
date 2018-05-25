<?php
/**
 * This class is the Controller of the Admin Categories panel.
 *
 * @author  samuelrcosta
 * @version 1.2.0, 05/24/2018
 * @since   1.0, 01/15/2017
 */

class categoriesCMSController extends Controller{

    // Models instances
    private $u;
    private $c;
    private $areas;

    /**
     * Class constructor
     */
    public function __construct(){
        // Initialize instances
        $this->u = new Administrators();
        $this->c = new Categories();
        $this->areas = new Areas();
        parent::__construct();
    }

    /**
     * This function shows the Admin Categories List page.
     */
    public function index(){
        $data = array();

        if($this->u->isLogged() && $this->u->havePermission('categories')){
            $data['title'] = 'ADM - Categorias';
            $data['link'] = 'categoriesCMS/index';
            $data['userData'] = $this->u->getData(1, $_SESSION['adminLogin']);
            $data['categoriesData'] = $this->c->getPrincipals();

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
        $data = array();

        if($this->u->isLogged() && $this->u->havePermission('categories')){
            //Verify if exists POST for a new register

            if((isset($_POST['name']) && !empty($_POST['name'])) && (isset($_POST['id_area']) && !empty($_POST['id_area']))){
                $name = addslashes($_POST['name']);
                $id_area = addslashes($_POST['id_area']);

                if(!empty($name) && !empty($id_area)){
                    if($this->c->register($name, null, $id_area)){
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
            $data['areasData'] = $this->areas->getAreasList();
            $data['userData'] = $this->u->getData(1, $_SESSION['adminLogin']);

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
        $data = array();

        $id = addslashes(base64_decode(base64_decode($id)));

        if($this->u->isLogged() && $this->u->havePermission('categories')){

            //Verify if exists POST for edi
            if((isset($_POST['name']) && !empty($_POST['name'])) && (isset($_POST['id_area']) && !empty($_POST['id_area']))){
                $name = addslashes($_POST['name']);
                $id_area = addslashes($_POST['id_area']);

                if(!empty($name) && !empty($id_area)){
                    if($this->c->edit($id, $name, null, $id_area)){
                        $msg = urlencode('Categoria editada com sucesso!');
                        header("Location: ".BASE_URL."categoriesCMS?notification=".$msg."&status=alert-info");
                        exit;
                    }else{
                        $data['categoryData']['name'] = $name;
                        $data['categoryData']['id_area'] = $id_area;
                        $data['notice'] = '<div class="alert alert-warning">Já existe categoria com esse mesmo nome.</div>';
                    }
                }else{
                    $data['categoryData']['name'] = $name;
                    $data['categoryData']['id_area'] = $id_area;
                    $data['notice'] = '<div class="alert alert-warning">Preencha todos os campos.</div>';
                }
            }else{
                //If not, render editPage
                $data['categoryData'] = $this->c->getDataById($id);
            }

            $data['title'] = 'ADM - Editar Categoria';
            $data['link'] = 'categoriesCMS/index';
            $data['areasData'] = $this->areas->getAreasList();
            $data['userData'] = $this->u->getData(1, $_SESSION['adminLogin']);

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

        $id = addslashes(base64_decode(base64_decode($id)));

        if($this->u->isLogged() && $this->u->havePermission('categories')){
            $this->c->delete($id);
            header("Location: ".BASE_URL."categoriesCMS");
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }
}