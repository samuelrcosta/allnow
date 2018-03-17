<?php
/**
 * This class is the Controller of the HomePage.
 *
 * @author  samuelrcosta
 * @version 1.0, 01/10/2017
 * @since   1.0, 01/10/2017
 */
class homeController extends Controller {

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Index page
     */
    public function index() {
        $c = new Categories();
        $a = new Advertisements();
        $data = array();

        $data['title'] = 'Optium - Home';
        $data['categoryMenuData'] = $c->getActiveList();
        $data['menuOptions']['url'] = 'home';
        $data['advertisementsData'] = $a->getHighlightsAds();
        $this->loadTemplate('home/index', $data);
    }

    public function inscribeRegister(){
        $store = new Store();
        if(isset($_POST['email']) && !empty($_POST['email'])){
            $email = $_POST['email'];
            $store->subscribeMailChimp($email);
            echo 'true';
        }else{
            echo 'false';
        }
    }

}