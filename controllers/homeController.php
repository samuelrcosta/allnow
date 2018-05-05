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
        //normalize data
        for($i = 0; $i < count($data['advertisementsData']); $i++){
            $badges = array();
            if($data['advertisementsData'][$i]['new'] == "1"){
                $badges[] = array('class' =>'new', 'name' => "Novo");
            }
            if($data['advertisementsData'][$i]['bestseller'] == "1"){
                $badges[] = array('class' =>'bestseller', 'name' => "Mais&nbsp;vendidos");
            }
            if($data['advertisementsData'][$i]['sale'] == "1"){
                $badges[] = array('class' =>'sale', 'name' => "Promoção");
            }
            $data['advertisementsData'][$i]['badges'] = $badges;
        }
        $this->loadTemplate('home/index', $data);
    }

    public function inscribeRegister(){
        $store = new Store();
        if(isset($_POST['email']) && !empty($_POST['email'])){
            $email = $_POST['email'];
            $result = $store->subscribeMailChimp($email);
            echo $result;
        }else{
            echo 'false';
        }
    }

    public function teste(){
        $template = file_get_contents(BASE_URL."assets/templates/mail_template.htm");
        $template = str_replace("#EMAIL_TEXT#", "<b>Texto do Email -----------</b>", $template);
        echo $template;
    }

}