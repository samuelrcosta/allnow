<?php
/**
 * This class is the Controller of the Admin Advertisement panel.
 *
 * @author  samuelrcosta
 * @version 1.2.1, 05/24/2018
 * @since   1.0, 01/15/2017
 */

class adminAdvertisementsCMSController extends Controller{

    // Models instances
    private $u;
    private $c;
    private $a;
    private $s;
    private $medias_ads;

    /**
     * Class constructor
     */
    public function __construct(){
        // Initialize instances
        $this->u = new Administrators();
        $this->c = new Categories();
        $this->a = new Advertisements();
        $this->s = new Store();
        $this->medias_ads = new Medias_ads();
        parent::__construct();
    }

    /**
     * This function shows the Admin Advertisement List page.
     * Shows a List of Advertisements of Admin User
     */
    public function index(){
        $data = array();

        if($this->u->isLogged() && $this->u->havePermission('ads')){
            $data['title'] = 'ADM - Meus Anúncios';
            $data['link'] = 'adminAdvertisementsCMS/index';
            $data['userData'] = $this->u->getData(1, $_SESSION['adminLogin']);
            $data['advertisementsData'] = $this->a->getAdminAds();

            $this->loadTemplateCMS('cms/adminAdvertisements/index', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function shows the Admin Advertisement register page.
     */
    public function newAdvertisementPage(){
        $data = array();

        if($this->u->isLogged() && $this->u->havePermission('ads')){
            $data['title'] = 'ADM - Cadastrar Anúncio';
            $data['link'] = 'adminAdvertisementsCMS/index';
            $data['userData'] = $this->u->getData(1, $_SESSION['adminLogin']);
            $data['categoryData'] = $this->c->getPrincipals();

            $this->loadTemplateCMS('cms/adminAdvertisements/new', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function receive POST data to save a new Advertisement.
     */
    public function saveNewAdvertisement(){
        // Check if user is logged
        if($this->u->isLogged() && $this->u->havePermission('ads')) {
            // Array for check the keys
            $keys = array('title', 'id_category', 'id_subcategory', 'abstract', 'description', 'rating', 'highlight', 'new', 'bestseller', 'sale', 'medias');
            if ($this->s->array_keys_check($keys, $_POST)) {
                // Check if the array is completed
                if ($this->s->array_check_completed_keys($keys, $_POST)) {
                    $title = addslashes($_POST['title']);
                    $id_category = intval($_POST['id_category']);
                    $id_subcategory = intval($_POST['id_subcategory']);
                    $abstract = addslashes($_POST['abstract']);
                    $description = $_POST['description'];
                    $rating = addslashes($_POST['rating']);
                    $highlight = ($_POST['highlight'] == 'true') ? 1 : null;
                    $new = ($_POST['new'] == 'true') ? 1 : null;
                    $bestseller = ($_POST['bestseller'] == 'true') ? 1 : null;
                    $sale = ($_POST['sale'] == 'true') ? 1 : null;
                    // For medias
                    $keys = array('media_type', 'media_link');
                    $medias = json_decode($_POST['medias'], true);
                    // Check medias
                    $check = false;
                    if (count($medias) > 0) {
                        for ($i = 0; $i < count($medias); $i++) {
                            if ($this->s->array_keys_check($keys, $medias[$i])) {
                                if ($this->s->array_check_completed_keys($keys, $medias[$i])) {
                                    $check = true;
                                    if ($medias[$i]['media_type'] == 1) {
                                        $youtubeID= $this->s->getYoutubeId($medias[$i]['media_link']);
                                        if (!empty($youtubeID)) {
                                            $medias[$i]['media'] = $youtubeID;
                                        } else {
                                            echo "Link do Youtube inválido.";
                                            exit;
                                        }
                                    } elseif ($medias[$i]['media_type'] == 2) {
                                        $oembed_endpoint = 'http://vimeo.com/api/oembed';
                                        // Grab the video url from the url, or use default
                                        $video_url = $medias[$i]['media_link'];
                                        // Create the URLs
                                        $xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($video_url);
                                        if($this->s->curl_get($xml_url) == '404 Not Found') {
                                            echo "Link do Vimeo inválido.";
                                            exit;
                                        } else {
                                            $oembed = simplexml_load_string($this->s->curl_get($xml_url));
                                            $medias[$i]['media'] = $oembed->video_id;
                                        }
                                    } elseif ($medias[$i]['media_type'] == 3) {
                                        $medias[$i]['media'] = "<img width='100%' src=" . $medias[$i]['media_link'] . ">";
                                    } else {
                                        echo "Tipo de Mídia inválido.";
                                        exit;
                                    }
                                } else {
                                    echo 'Preencha todos os campos obrigatórios.';
                                    exit;
                                }
                            } else {
                                echo 'Preencha todos os campos obrigatórios.';
                                exit;
                            }
                        }
                        if ($check == true) {
                            // First: Save the Ad
                            $idAdvertisement = $this->a->register($id_category, $id_subcategory, $title, $abstract, $description, 1, $rating, $highlight, $new, $bestseller, $sale);
                            if ($idAdvertisement != false) {
                                for ($i = 0; $i < count($medias); $i++) {
                                    $this->medias_ads->register($idAdvertisement, $medias[$i]['media'], $medias[$i]['media_type'], $medias[$i]['media_link']);
                                }
                                // Returns true
                                echo 'true';
                                exit;
                            } else {
                                echo 'Anúncio já cadastrado.';
                                exit;
                            }
                        }
                    } else {
                        echo 'Preencha todos os campos obrigatórios.';
                        exit;
                    }
                } else {
                    echo 'Preencha todos os campos obrigatórios.';
                    exit;
                }
            } else {
                echo 'Preencha todos os campos obrigatórios.';
                exit;
            }
            exit;
        }
    }

    /**
     * This function shows the Admin Advertisement edit page.
     */
    public function editAdvertisementPage($id){
        $data = array();
        // Checks if user is logged in
        if($this->u->isLogged() && $this->u->havePermission('ads')){
            $data['title'] = 'ADM - Editar Anúncio';
            $data['link'] = 'adminAdvertisementsCMS/index';
            // Get user data
            $data['userData'] = $this->u->getData(1, $_SESSION['adminLogin']);
            // Sends the Received ID
            $data['advertisementId'] = $id;
            // Get Categories
            $data['categoryData'] = $this->c->getPrincipals();
            $this->loadTemplateCMS('cms/adminAdvertisements/edit', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function shows all data from advertisement in JSON.
     */
    public function getAdvertisementData($id){
        $u = new Administrators();
        $a = new Advertisements();
        $c = new Categories();
        // Check if user is logged
        if($u->isLogged() && $u->havePermission('ads')) {
            $data = array();
            $id = addslashes(base64_decode(base64_decode($id)));
            $data['advertisementData'] = $a->getDataById($id);
            // Show the result
            echo json_encode($data);
        }
    }

    /**
     * This function edit a Advertisement.
     */
    public function editAdvertisement(){
        $u = new Administrators();
        $a = new Advertisements();
        $medias_ads = new Medias_ads();
        $s = new Store();

        if($u->isLogged() && $u->havePermission('ads')){
            // Array for check the keys
            $keys = array('id', 'title', 'id_category', 'id_subcategory', 'abstract', 'description', 'rating', 'highlight', 'new', 'bestseller', 'sale', 'medias', 'delete_medias');
            if ($s->array_keys_check($keys, $_POST)) {
                // Check if the array is completed
                if ($s->array_check_completed_keys($keys, $_POST)) {
                    $id = base64_decode(base64_decode(addslashes($_POST['id'])));
                    $title = addslashes($_POST['title']);
                    $id_category = intval($_POST['id_category']);
                    $id_subcategory = intval($_POST['id_subcategory']);
                    $abstract = addslashes($_POST['abstract']);
                    $description = $_POST['description'];
                    $rating = (empty(addslashes($_POST['rating']))) ? null : addslashes($_POST['rating']);
                    $highlight = ($_POST['highlight'] == 'true') ? 1 : null;
                    $new = ($_POST['new'] == 'true') ? 1 : null;
                    $bestseller = ($_POST['bestseller'] == 'true') ? 1 : null;
                    $sale = ($_POST['sale'] == 'true') ? 1 : null;
                    // For medias
                    $keys = array('media_type', 'media_link');
                    $medias = json_decode($_POST['medias'], true);
                    $delete_medias = json_decode($_POST['delete_medias'], true);
                    // Check medias
                    $check = false;
                    if (count($medias) > 0) {
                        for ($i = 0; $i < count($medias); $i++) {
                            if ($s->array_keys_check($keys, $medias[$i])) {
                                if ($s->array_check_completed_keys($keys, $medias[$i])) {
                                    $check = true;
                                    if ($medias[$i]['media_type'] == 1) {
                                        $youtubeID= $s->getYoutubeId($medias[$i]['media_link']);
                                        if (!empty($youtubeID)) {
                                            $medias[$i]['media'] = $youtubeID;
                                        } else {
                                            echo "Link do Youtube inválido.";
                                            exit;
                                        }
                                    } elseif ($medias[$i]['media_type'] == 2) {
                                        $oembed_endpoint = 'http://vimeo.com/api/oembed';
                                        // Grab the video url from the url, or use default
                                        $video_url = $medias[$i]['media_link'];
                                        // Create the URLs
                                        $xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($video_url);
                                        if($s->curl_get($xml_url) == '404 Not Found') {
                                            echo "Link do Vimeo inválido.";
                                            exit;
                                        } else {
                                            $oembed = simplexml_load_string($s->curl_get($xml_url));
                                            $medias[$i]['media'] = $oembed->video_id;
                                        }
                                    } elseif ($medias[$i]['media_type'] == 3) {
                                        $medias[$i]['media'] = "<img width='100%' src=";
                                        $medias[$i]['media'] .= $medias[$i]['media_link'];
                                        $medias[$i]['media'] .= " />";
                                    } else {
                                        echo "Tipo de Mídia inválido.";
                                        exit;
                                    }
                                } else {
                                    echo 'Preencha todos os campos obrigatórios.';
                                    exit;
                                }
                            } else {
                                echo 'Preencha todos os campos obrigatórios.';
                                exit;
                            }
                        }
                        if ($check == true) {
                            // First: Save the Ad
                            if($a->edit($id, $id_category, $id_subcategory, $title, $abstract, $description, 1, $rating, $highlight, $new, $bestseller, $sale)) {
                                // Delete the link ads
                                $medias_ads->deleteLinksMedias($id);
                                // Delete the ads in medias_delete
                                for($i = 0; $i < count($delete_medias); $i++){
                                    $medias_ads->deleteMedia($delete_medias[$i]);
                                }
                                for ($i = 0; $i < count($medias); $i++) {
                                    $medias_ads->register($id, $medias[$i]['media'], $medias[$i]['media_type'], $medias[$i]['media_link']);
                                }
                                // Returns true
                                echo 'true';
                                exit;
                            } else {
                                echo 'Anúncio já cadastrado.';
                                exit;
                            }
                        }
                    } else {
                        echo 'Preencha todos os campos obrigatórios.';
                        exit;
                    }
                } else {
                    echo 'Preencha todos os campos obrigatórios.';
                    exit;
                }
            } else {
                echo 'Preencha todos os campos obrigatórios.';
                exit;
            }
            exit;
        }
    }

    /**
     * This function receive a advertisement id on Base64 (2x),
     * execute delete function and headers to index page (adminAdvertisementsCMS/index)
     */
    public function deleteAdvertisement($id){
        $u = new Administrators();
        $a = new Advertisements();

        if($u->isLogged() && $u->havePermission('ads')){
            $id = addslashes(base64_decode(base64_decode($id)));
            $a->delete($id);
            header("Location: ".BASE_URL."adminAdvertisementsCMS");
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }
}