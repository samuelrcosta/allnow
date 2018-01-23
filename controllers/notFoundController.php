<?php
/**
 * This class is used if the user accesses a page that does not exist.
 *
 * @author  samuelrcosta
 * @version 1.0, 01/10/2017
 * @since   1.0, 01/10/2017
 */
class notFoundController extends Controller {

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * This method shows a 404 page.
     */
    public function index() {
        $data = array();

        $data['title'] = 'Página não encontrada';

        $this->loadView('404', $data);
    }

}