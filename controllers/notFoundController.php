<?php
/**
 * This class is used if the user accesses a page that does not exist.
 *
 * @author  samuelrcosta
 * @version 1.0, 01/10/2017
 * @since   1.0, 01/10/2017
 */
class notFoundController extends Controller {

    // Models instances
    private $a;

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();
        // Initialize instances
        $this->a = new Areas();
    }

    /**
     * This method shows a 404 page.
     */
    public function index() {
        $data = array();

        $data['title'] = 'Página não encontrada';
        $data['categoryMenuData'] = $this->a->getCompleteList();

        $this->loadTemplate('notFound/404', $data);
    }

}