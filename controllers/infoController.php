<?php
/**
 * This class is the Controller of the Information pages.
 *
 * @author  samuelrcosta
 * @version 1.0.0, 04/21/2017
 * @since   1.0, 04/21/2017
 */

class infoController extends Controller{

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * This function redirects to home page
     */
    public function index(){
        echo "<script>window.location.replace('".BASE_URL."')</script>";
        exit;
    }

    /**
     * This function shows the corporation informations
     */
    public function sobre(){
        echo "Em construção...";
        exit;
    }

    /**
     * This function shows the contact page
     */
    public function contato(){
        echo "Em construção";
        exit;
    }

}