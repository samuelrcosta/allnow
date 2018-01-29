<?php
/**
 * This class is the Controller of the Advertisements pages.
 *
 * @author  samuelrcosta
 * @version 1.0, 01/20/2017
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
    public function open($id){
        $c = new Categories();
        $a = new Advertisements();
        $data = array();

        $id = addslashes(base64_decode(base64_decode($id)));

        $data['advertisementData'] = $a->getDataById($id);

        $data['categoryData'] = array();
        $data['categoriesData'] = $c->getActiveList();

        foreach ($data['categoriesData'] as $item){
            foreach ($item['subs'] as $sub){
                if($sub['id'] == $data['advertisementData']['id_subcategory']){
                    $data['categoryData'] = $sub;
                    break;
                }
            }
        }

        $data['title'] = 'Allnow - '.$data['advertisementData']['title'];


        $this->loadTemplate('advertisements/open', $data);
    }
}