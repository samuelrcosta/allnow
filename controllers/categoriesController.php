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

        $filters['category'] = $slug;

        $data['categoriesData'] = $c->getActiveList();

        foreach ($data['categoriesData'] as $item){
            if($item['slug'] == $slug){
                $data['activeCategory_type'] = 'id_category';
                $data['activeCategory'] = $item;
                break;
            }
            foreach ($item['subs'] as $sub){
                if($sub['slug'] == $slug){
                    $data['activeCategory_type'] = 'id_subcategory';
                    $data['activeCategory'] = $sub;
                    break;
                }
            }
        }

        $categories = array();
        $categories[$data['activeCategory_type']] = $data['activeCategory']['id'];

        $data['categoryMenuData'] = $c->getActiveList();
        $data['title'] = 'Allnow - '.$data['activeCategory']['name'];
        $data['advertisementsData'] = $a->getList($categories);
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