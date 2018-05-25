<?php
/**
 * This class is the Controller of the Advertisements pages.
 *
 * @author  samuelrcosta
 * @version 1.1, 05/02/2018
 * @since   1.0, 01/20/2017
 */
class advertisementsController extends Controller{

    // Models instances
    private $a;
    private $c;
    private $areas;

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();
        // Initialize instances
        $this->a = new Advertisements();
        $this->c = new Categories();
        $this->areas = new Areas();
    }

    /**
     * This page not exists, redirect to home.
     */
    public function index(){
        header("Location: ".BASE_URL);
        exit;
    }

    /**
     * This function shows the advertisements of this category.
     */
    public function open($slug){
        $data = array();

        $data['categoryData'] = array();
        $data['categoryMenuData'] = $this->areas->getCompleteList();

        $adData = $this->a->getDataBySlug($slug);
        if(!empty($adData)){
            $categoryData = $this->c->getDataById($adData['id_category']);
            $subcategoryData = $this->c->getDataById($adData['id_subcategory']);
            $areaData = $this->areas->getArea($categoryData['id_area']);

            $siteMap = "<a href='".BASE_URL."'>Home</a>";
            $siteMap .= " <span> > </span> <a href='".BASE_URL."areas/open/".$areaData['slug']."'>".$areaData['name']."</a>";
            $siteMap .= " <span> > </span> <a href='".BASE_URL."categories/open/".$categoryData['slug']."'>".$categoryData['name']."</a>";
            $siteMap .= " <span> > </span> <a href='".BASE_URL."categories/open/".$subcategoryData['slug']."'>".$subcategoryData['name']."</a>";
            $siteMap .= " <span> > </span> <a href='".BASE_URL."advertisements/open/".$adData['slug']."'>".$adData['title']."</a>";

            $data['site_map'] = $siteMap;
            $data['menuUrlActive'] = $areaData['id'];
            $data['title'] = 'Optium - '.$adData['title'];
            $data['advertisementData'] = $adData;

            $this->loadTemplate('advertisements/open', $data);
        }else{
            $data['title'] = 'Página não encontrada';
            $this->loadTemplate('notFound/404', $data);
        }
    }
}