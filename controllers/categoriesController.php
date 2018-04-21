<?php
/**
 * This class is the Controller of the Category pages.
 *
 * @author  samuelrcosta
 * @version 1.0, 01/20/2017
 * @since   1.0, 01/20/2017
 */
class categoriesController extends Controller{

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();
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
        $c = new Categories();
        $a = new Advertisements();
        $data = array();
        $filters = array();

        $slug = addslashes($slug);

        if(isset($_GET['filters']) && !empty($_GET['filters'])){
            $filters = $_GET['filters'];
        }

        $data['categoriesData'] = $c->getActiveList();

        foreach ($data['categoriesData'] as $item){
            if($item['slug'] == $slug){
                $data['activeCategory_type'] = 'id_category';
                $data['activeCategory'] = $item;
                $data['activePrincipalCategory'] = $item;
                break;
            }
            foreach ($item['subs'] as $sub){
                if($sub['slug'] == $slug){
                    $data['activeCategory_type'] = 'id_subcategory';
                    $data['activePrincipalCategory'] = $item;
                    $data['activeCategory'] = $sub;
                    break;
                }
            }
        }

        $categories = array();
        $categories[$data['activeCategory_type']] = $data['activeCategory']['id'];
        if($data['activeCategory_type'] == 'id_category'){
            $data['site_map'] = "<a href='".BASE_URL."'>Home</a> <span> > </span> <a href='".BASE_URL."categories/open/".$data['activeCategory']['slug']."'>".$data['activeCategory']['name']."</a>";
        }else{
            $data['site_map'] = "<a href='".BASE_URL."'>Home</a> <span> > </span> <a href='".BASE_URL."categories/open/".$data['activePrincipalCategory']['slug']."'>".$data['activePrincipalCategory']['name']."</a> <span> > </span> <a href='".BASE_URL."categories/open/".$data['activeCategory']['slug']."'>".$data['activeCategory']['name']."</a>";
        }


        $data['categoryMenuData'] = $c->getActiveList();
        $data['menuOptions']['url'] = $data['activePrincipalCategory']['slug'];
        $data['title'] = 'Optium - '.$data['activeCategory']['name'];
        $data['advertisementsData'] = $a->getList($categories, $filters);
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
        $data['filters'] = $filters;

        $this->loadTemplate('categories/open', $data);
    }

    /**
     * This function receive a sub-category id on Base64 (2x),
     * get all subcategory data and echo in json
     */
    public function getSubcategories($id){
        $c = new Categories();

        $id = addslashes(base64_decode(base64_decode($id)));

        $subcategoryData = array();

        $data = $c->getUserList();
        foreach ($data as $category){
            if($category['id'] == $id){
                foreach ($category['subs'] as $subcategory){
                    $subcategoryData[] = $subcategory;
                }
            }
        }

        echo json_encode($subcategoryData);
    }
}