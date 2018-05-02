<?php
/**
 * This class is the Controller of the Advertisements pages.
 *
 * @author  samuelrcosta
 * @version 1.1, 05/02/2018
 * @since   1.0, 01/20/2017
 */
class advertisementsController extends Controller{

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * This page shows all advertisements in database.
     */
    public function index(){
        $filters = array();
        if(isset($_GET['filters'])){
            $filters = $_GET['filters'];
        }
    }

    /**
     * This function shows the advertisements of this category.
     */
    public function open($slug){
        $c = new Categories();
        $a = new Advertisements();
        $data = array();

        $data['categoryData'] = array();
        $data['categoriesData'] = $c->getActiveList();
        $data['categoryMenuData'] = $c->getActiveList();

        $data['advertisementData'] = $a->getDataBySlug($slug);
        if(!empty($data['advertisementData'])){

            foreach ($data['categoriesData'] as $item){
                if($item['id'] == $data['advertisementData']['id_category']){
                    $data['categoryData'] = $item;
                    $data['name_category'] = $item['name'];
                    $data['slug_category'] = $item['slug'];
                }
                foreach ($item['subs'] as $sub){
                    if($sub['id'] == $data['advertisementData']['id_subcategory']){
                        $data['name_subcategory'] = $sub['name'];
                        $data['slug_subcategory'] = $sub['slug'];
                        break;
                    }
                }
            }


            $data['site_map'] = "<a href='".BASE_URL."'>Home</a> <span> > </span> <a href='".BASE_URL."categories/open/".$data['slug_category']."'>".$data['name_category']."</a> <span> > </span> <a href='".BASE_URL."categories/open/".$data['slug_subcategory']."'>".$data['name_subcategory']."</a> <span> > </span> <a href='".BASE_URL."advertisements/open/".$slug."'>".$data['advertisementData']['title']."</a>";

            $data['menuOptions']['url'] = $data['slug_category'];
            $data['title'] = 'Optium - '.$data['advertisementData']['title'];

            $this->loadTemplate('advertisements/open', $data);
        }else{
            $data['title'] = 'Página não encontrada';
            $this->loadTemplate('notFound/404', $data);
        }
    }
}