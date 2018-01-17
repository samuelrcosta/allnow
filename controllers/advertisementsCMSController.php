<?php
/**
 * This class is the Controller of the Admin Advertisement panel.
 *
 * @author  samuelrcosta
 * @version 1.0.0, 01/15/2017
 * @since   1.0, 01/15/2017
 */

class advertisementsCMSController extends Controller{

    /**
     * Class constructor
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * This function shows the Admin Advertisement List page.
     * Shows a List of Advertisements of Admin User
     */
    public function index(){
        $u = new Administrators();
        $data = array();

        if($u->isLogged()){
            $data['title'] = 'ADM - Login';
            $data['link'] = 'advertisementsCMS/index';
            $data['userData'] = $u->getData(1, $_SESSION['adminLogin']);

            $this->loadTemplateCMS('cms/advertisements/index', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }
}