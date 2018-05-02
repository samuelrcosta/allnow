<?php
/**
 * This class is the Controller of the Information pages.
 *
 * @author  samuelrcosta
 * @version 1.0.0, 04/21/2017
 * @since   1.0, 04/21/2017
 */

class infoController extends Controller{

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * This function redirects to home page
     */
    public function index(){
        echo "<script>window.location.replace('".BASE_URL."')</script>";
        exit;
    }

    /**
     * This function shows the corporation informations
     */
    public function about(){
        $c = new Categories();
        $data = array();

        $data['title'] = 'Optium - Sobre a empresa';
        $data['categoryMenuData'] = $c->getActiveList();
        $this->loadTemplate('info/about', $data);
    }

    /**
     * This function shows the contact page
     */
    public function contact(){
        $c = new Categories();
        $data = array();

        $data['title'] = 'Optium - Contato';
        $data['categoryMenuData'] = $c->getActiveList();
        $this->loadTemplate('info/contact', $data);
    }

    /**
     * This function saves a contact POST
     */
    public function saveContact(){
        if(!empty($_POST)){
            $s = new Store();
            $c = new Contacts();
            // Array for check the keys
            $keys = array('name', 'email', 'phone', 'subject', 'message');
            if($s->array_keys_check($keys, $_POST)){
                // Check if the array is completed
                if($s->array_check_completed_keys($keys, $_POST)){
                    $name = addslashes($_POST['name']);
                    $email = addslashes($_POST['email']);
                    $phone = addslashes($_POST['phone']);
                    $subject = addslashes($_POST['subject']);
                    $message = addslashes($_POST['message']);
                    // Sends E-mail to Admin
                    // Sends E-mail to user
                    $c->register($name, $email, $phone, $subject, $message);
                    // Returns true
                    echo json_encode(true);
                }else{
                    echo json_encode("Dados incompletos.");
                }
            }else{
                echo json_encode("Dados corrompidos.");
            }
        }else{
            exit;
        }
    }

}