<?php
/**
 * This class is the Controller of the Admin Areas panel.
 *
 * @author  samuelrcosta
 * @version 1.0.0, 05/24/2018
 * @since   1.0, 05/24/2018
 */

class areasCMSController extends Controller{

    // Models instances
    private $u;
    private $c;
    private $a;

    /**
     * Class constructor
     */
    public function __construct(){
        // Initialize instances
        $this->u = new Administrators();
        $this->c = new Categories();
        $this->a = new Areas();
        parent::__construct();
    }

    /**
     * This function shows the Admin Areas List page.
     */
    public function index(){
        $data = array();

        if($this->u->isLogged() && $this->u->havePermission('areas')){
            $data['title'] = 'ADM - Áreas';
            $data['link'] = 'areasCMS/index';
            $data['userData'] = $this->u->getData(1, $_SESSION['adminLogin']);
            $data['areasData'] = $this->a->getAreasList();

            $this->loadTemplateCMS('cms/areas/index', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function shows the Admin area register page.
     */
    public function newArea(){
        $data = array();

        if($this->u->isLogged() && $this->u->havePermission('areas')){
            //Verify if exists POST for a new register

            if(isset($_POST['name']) && !empty($_POST['name'])){
                $name = addslashes($_POST['name']);

                if(!empty($name)){
                    if($this->a->register($name)){
                        $msg = urlencode('Área registrada com sucesso!');
                        header("Location: ".BASE_URL."areasCMS?notification=".$msg."&status=alert-info");
                        exit;
                    }else{
                        $data['name'] = $name;
                        $data['notice'] = '<div class="alert alert-warning">Essa área já está cadastrada.</div>';
                    }
                }else{
                    $data['name'] = $name;
                    $data['notice'] = '<div class="alert alert-warning">Preencha todos os campos.</div>';
                }
            }

            $data['title'] = 'ADM - Nova Área';
            $data['link'] = 'areasCMS/index';
            $data['userData'] = $this->u->getData(1, $_SESSION['adminLogin']);

            $this->loadTemplateCMS('cms/areas/new', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function receive a area id on Base64 (2x),
     * show the edit page with the area data, receive back
     * all edited data and update the database.
     * Finally headers to index page (areasCMS/index)
     */
    public function editArea($id){
        $data = array();

        $id = addslashes(base64_decode(base64_decode($id)));

        if($this->u->isLogged() && $this->u->havePermission('areas')){

            //Verify if exists POST for edit

            if(isset($_POST['name']) && !empty($_POST['name'])){
                $name = addslashes($_POST['name']);

                if(!empty($name)){
                    if($this->a->edit($id, $name)){
                        $msg = urlencode('Área editada com sucesso!');
                        header("Location: ".BASE_URL."areasCMS?notification=".$msg."&status=alert-info");
                        exit;
                    }else{
                        $data['areaData']['name'] = $name;
                        $data['notice'] = '<div class="alert alert-warning">Já existe área com esse mesmo nome.</div>';
                    }
                }else{
                    $data['areaData']['name'] = $name;
                    $data['notice'] = '<div class="alert alert-warning">Preencha todos os campos.</div>';
                }
            }else{
                //If not, render editPage
                $data['areaData'] = $this->a->getArea($id);
            }

            $data['title'] = 'ADM - Editar Área';
            $data['link'] = 'areasCMS/index';
            $data['userData'] = $this->u->getData(1, $_SESSION['adminLogin']);

            $this->loadTemplateCMS('cms/areas/edit', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function receive a area id on Base64 (2x),
     * execute delete function and headers to index page (areasCMS/index)
     */
    public function delete($id){

        $id = addslashes(base64_decode(base64_decode($id)));

        if($this->u->isLogged() && $this->u->havePermission('areas')){
            $this->a->delete($id);
            header("Location: ".BASE_URL."areasCMS");
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }
}