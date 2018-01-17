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
        $data = array();
        $data['title'] = 'Home';
        $this->loadTemplate('home/index', $data);
    }

}