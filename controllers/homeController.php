<?php
/**
 * This class is the Controller of the HomePage.
 *
 * @author  samuelrcosta
 * @version 1.0, 01/10/2017
 * @since   1.0, 01/10/2017
 */
class homeController extends Controller {

    // Models instances
    private $u;
    private $s;
    private $a;
    private $areas;
    private $conf;

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();
        // Initialize instances
        $this->u = new Administrators();
        $this->s = new Store();
        $this->a = new Advertisements();
        $this->areas = new Areas();
        $this->conf = new Configs();
    }

    /**
     * Index page
     */
    public function index() {
        $data = array();

        $data['title'] = 'Optium - Home';
        $data['categoryMenuData'] = $this->areas->getCompleteList();
        $data['menuUrlActive'] = 'home';
        $data['advertisementsData'] = $this->s->normalizeBadgesName($this->a->getHighlightsAds());
        $data['shareDescription'] = "Optium - A maior plataforma de produtos digitais do país: idiomas, finanças, negócios, e muito mais";

        // Get tutorial data
        $data['tutorialData'] = json_decode(strval($this->conf->getConfig("tutorial_advertisement")), true);

        $this->loadTemplate('home/index', $data);
    }

    /**
     * This function receives a POST request to inscribe e-mail in MailChimp list
     */
    public function inscribeRegister(){
        if(isset($_POST['email']) && !empty($_POST['email'])){
            $email = $_POST['email'];
            $result = $this->s->subscribeMailChimp($email);
            echo $result;
        }else{
            echo 'false';
        }
    }

    /**
     * This function receives word and shows the ads search
     */
    public function search($word){
        $data = array();
        if($word != ''){
            $word = addslashes($word);
            $data['title'] = 'Optium - '.$word;
            $data['categoryMenuData'] = $this->areas->getCompleteList();
            $data['menuUrlActive'] = 'home';
            $data['word'] = $word;
            $data['advertisementsData'] = $this->s->normalizeBadgesName($this->a->getSearchAds($word));

            $data['site_map'] = "<a href='".BASE_URL."'>Home</a> <span> > </span> Pesquisa <span> > </span> <a href='".BASE_URL."home/search/".$word."'>".$word."</a>";

            $this->loadTemplate('home/search', $data);
        }else{
            header("Location: ".BASE_URL);
        }
    }

}