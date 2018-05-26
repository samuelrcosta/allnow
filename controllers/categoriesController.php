<?php
/**
 * This class is the Controller of the Category pages.
 *
 * @author  samuelrcosta
 * @version 1.1, 05/02/2018
 * @since   1.0, 01/20/2017
 */
class categoriesController extends Controller{

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
     * This function shows the advertisements of this category.
     */
    public function open($slug){
        $data = array();

        $slug = addslashes($slug);

        $data['categoriesData'] = $this->areas->getCompleteList();
        $data['categoryMenuData'] = $data['categoriesData'];
        $categoryData = $this->c->getDataBySlug($slug);

        // Checks if the category exists
        if(!empty($categoryData)){

            $siteMap = "<a href='".BASE_URL."'>Home</a> <span> > </span> ";

            // Checks if this is a principal or subcategory
            if(empty($categoryData['id_principal'])){
                $areaData = $this->areas->getArea($categoryData['id_area']);
                $type = "id_category";
                $adsData = $this->a->getAdsByCategoryId($categoryData['id'], $type);
                $siteMap .= "<a href='".BASE_URL."areas/open/".$areaData['slug']."'> ".$areaData['name']." </a> <span> > </span> <a href='".BASE_URL."categories/open/".$categoryData['slug']."'>".$categoryData['name']."</a>";
            }else{
                $principalCategory = $this->c->getDataById($categoryData['id_principal']);
                $areaData = $this->areas->getArea($principalCategory['id_area']);
                $type = "id_subcategory";
                $adsData = $this->a->getAdsByCategoryId($categoryData['id'], $type);
                $siteMap .= "<a href='".BASE_URL."areas/open/".$areaData['slug']."'> ".$areaData['name']." </a> <span> > </span> <a href='".BASE_URL."categories/open/".$principalCategory['slug']."'>".$principalCategory['name']."</a> <span> > </span> <a href='".BASE_URL."categories/open/".$categoryData['slug']."'>".$categoryData['name']."</a>";
            }

            $data['title'] = 'Optium - '.$categoryData['name'];
            $data['menuUrlActive'] = $areaData['id'];
            $data['advertisementsData'] = $this->s->normalizeBadgesName($adsData);
            $data['activeCategory'] = $categoryData;
            $data['site_map'] = $siteMap;
            $data['shareData'] = $this->s->getShareData('category', $categoryData);

            $this->loadTemplate('categories/open', $data);
        }else{
            $data['title'] = 'Página não encontrada';
            $this->loadTemplate('notFound/404', $data);
        }
    }
}