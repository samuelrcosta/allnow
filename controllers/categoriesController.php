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

        $slug = addslashes($slug);

        $data['categoryData'] = array();
        $data['categoriesData'] = $c->getActiveList();

        foreach ($data['categoriesData'] as $item){
            if($item['slug'] == $slug){
                $data['categoryData'] = $item;
                break;
            }
            foreach ($item['subs'] as $sub){
                if($sub['slug'] == $slug){
                    $data['categoryData'] = $sub;
                    break;
                }
            }
        }

        $categories = array();
        if(empty($data['categoryData']['id_principal'])){
            $categories['id_category'] = $data['categoryData']['id'];
        }else{
            $categories['id_subcategory'] = $data['categoryData']['id'];
        }

        $data['advertisementsData'] = $a->getList($categories);
        $data['title'] = 'Allnow - '.$data['categoryData']['name'];


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