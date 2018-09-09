<?php
/**
 * This class is the Controller of the Admin Privacy Policy configurations.
 *
 * @author  samuelrcosta
 * @version 1.0.0, 09/07/2018
 * @since   1.0, 09/07/2018
 */

class aboutCMSController extends Controller{

    // Models instances
    private $u;
    private $c;
    private $s;

    /**
     * Class constructor
     */
    public function __construct(){
        // Initialize instances
        $this->u = new Administrators();
        $this->c = new Configs();
        $this->s = new Store();
        parent::__construct();
    }

    /**
     * This function shows the Privacy Policy data configuration page.
     */
    public function index(){
        $data = array();

        if($this->u->isLogged() && $this->u->havePermission('about')){
            $data['title'] = 'ADM - Sobre a Empresa';
            $data['link'] = 'aboutCMS/index';
            $data['userData'] = $this->u->getData(1, $_SESSION['adminLogin']);
            $data['configData'] = $this->c->getConfig("about");
            $this->loadTemplateCMS('cms/about/index', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function edit Privacy Policy config data.
     */
    public function saveData(){
        if($this->u->isLogged() && $this->u->havePermission('about')){
            if(!empty($_POST)){
                // Array for check the keys
                $keys = array('text');
                if($this->s->array_keys_check($keys, $_POST)){
                    if($this->s->array_check_completed_keys($keys, $_POST)){
                        $text = $_POST['text'];

                        $this->c->updateConfig('about', $text);
                        echo json_encode(true);
                        exit;
                    }else{
                        echo json_encode("Preencha o texto");
                    }
                }else{
                    echo json_encode("Dados corrompidos.");
                    exit;
                }
            }
        }
    }
}