<?php
/**
 * This class is the Controller of the Areas pages.
 *
 * @author  samuelrcosta
 * @version 1.0, 05/24/2018
 * @since   1.0, 05/24/2018
 */
class areasController extends Controller{

    // Models instances
    private $a;
    private $c;
    private $s;
    private $areas;

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();
        // Initialize instances
        $this->a = new Advertisements();
        $this->c = new Categories();
        $this->s = new Store();
        $this->areas = new Areas();
    }

    /**
     * This page not exists, redirect to home page.
     */
    public function index(){
        header("Location: ".BASE_URL);
        exit;
    }

    /**
     * This function shows the advertisements of this area.
     */
    public function open($slug){
        $data = array();

        $slug = addslashes($slug);

        $data['categoryMenuData'] = $this->areas->getCompleteList();

        $areaData = $this->areas->getAreaBySlug($slug);

        // Checks if a area with this slug
        if(!empty($areaData)){
            $data['menuUrlActive'] = $areaData['id'];
            $data['activeArea'] = $areaData;
            $data['site_map'] = "<a href='".BASE_URL."'>Home</a> <span> > </span> <a href='".BASE_URL."areas/open/".$areaData['slug']."'> ".$areaData['name']." </a>";

            $data['title'] = 'Optium - '.$areaData['name'];
            $data['advertisementsData'] = $this->s->normalizeBadgesName($this->a->getAdsByAreaId($areaData['id']));

            $this->loadTemplate('areas/open', $data);
        }else{
            $data['title'] = 'Página não encontrada';
            $this->loadTemplate('notFound/404', $data);
        }
    }
}