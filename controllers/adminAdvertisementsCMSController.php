<?php
/**
 * This class is the Controller of the Admin Advertisement panel.
 *
 * @author  samuelrcosta
 * @version 1.0.1, 01/17/2017
 * @since   1.0, 01/15/2017
 */

class adminAdvertisementsCMSController extends Controller{

    /**
     * Class constructor
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * This function shows the Admin Advertisement List page.
     * Shows a List of Advertisements of Admin User
     */
    public function index(){
        $u = new Administrators();
        $a = new Advertisements();
        $data = array();

        if($u->isLogged()){
            $data['title'] = 'ADM - Meus Anúncios';
            $data['link'] = 'adminAdvertisementsCMS/index';
            $data['userData'] = $u->getData(1, $_SESSION['adminLogin']);
            $data['advertisementsData'] = $a->getAdminAds();

            $this->loadTemplateCMS('cms/adminAdvertisements/index', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function shows the Admin Advertisement register page.
     */
    public function newAdvertisement(){
        $u = new Administrators();
        $a = new Advertisements();
        $c = new Categories();
        $s = new Store();
        $data = array();

        if($u->isLogged()){
            $data['title'] = 'ADM - Cadastrar Anúncio';
            $data['link'] = 'adminAdvertisementsCMS/index';
            $data['userData'] = $u->getData(1, $_SESSION['adminLogin']);
            $data['categoryData'] = $c->getList();

            if(isset($_POST['title'])){
                $data['adtitle'] = addslashes($_POST['title']);
                $data['id_category'] = addslashes($_POST['id_category']);
                $data['id_subcategory'] = addslashes($_POST['id_subcategory']);
                $data['subcategories'] = array();
                foreach ($data['categoryData'] as $category){
                    if($category['id'] == $data['id_category']){
                        foreach ($category['subs'] as $subcategory){
                            $data['subcategories'][] = $subcategory;
                        }
                    }
                }
                $data['abstract'] = addslashes($_POST['abstract']);
                $data['media_type'] = addslashes($_POST['media_type']);
                $data['media_link'] = addslashes($_POST['media_link']);
                $data['description'] = addslashes($_POST['description']);
                $data['rating'] = addslashes($_POST['rating']);
                if(isset($_POST['highlight'])){
                    $data['highlight'] = 1;
                }else{
                    $data['highlight'] = Null;
                }
                if(isset($_POST['new'])){
                    $data['new'] = 1;
                }else{
                    $data['new'] = Null;
                }
                if(isset($_POST['bestseller'])){
                    $data['bestseller'] = 1;
                }else{
                    $data['bestseller'] = Null;
                }
                if(isset($_POST['sale'])){
                    $data['sale'] = 1;
                }else{
                    $data['sale'] = Null;
                }
                if((!empty($data['adtitle'])) && (!empty($data['id_category'])) && (!empty($data['id_subcategory'])) && (!empty($data['abstract'])) && (!empty($data['media_link'])) && (!empty($data['description'])) && (!empty($data['media_type']))){

                    if($data['media_type'] == 1){
                        $embed_link = $s->getYoutubeEmbedUrl($data['media_link']);
                        if(!empty($embed_link)){
                            $data['media'] = "<iframe width='640' height='315' src=".$embed_link." frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>";
                        }else{
                            $data['media'] = '';
                        }
                    }elseif($data['media_type'] == 2){
                        $oembed_endpoint = 'http://vimeo.com/api/oembed';
                        // Grab the video url from the url, or use default
                        $video_url = $data['media_link'];
                        // Create the URLs
                        $xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($video_url);
                        // Curl helper function
                        function curl_get($url) {
                            $curl = curl_init($url);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                            $return = curl_exec($curl);
                            curl_close($curl);
                            return $return;
                        }
                        if(curl_get($xml_url) == '404 Not Found'){
                            $data['media'] = '';
                        }else{
                            $oembed = simplexml_load_string(curl_get($xml_url));
                            $data['media'] = $oembed->html;
                        }
                    }elseif($data['media_type'] == 3){
                        if($s->url_exists($data['media_link'])){
                            $data['media'] = "<img width='100%' src=".$data['media_link'].">";
                        }else{
                            $data['media'] = '';
                        }
                    }else{
                        $data['media'] = $data['media_link'];
                    }

                    if(!empty($data['media'])){
                        if($a->register($_SESSION['adminLogin'], $data['id_category'], $data['id_subcategory'], $data['adtitle'], $data['abstract'], $data['media_type'], $data['media_link'],$data['media'], $data['description'], 1, 2, $data['rating'], $data['highlight'], $data['new'], $data['bestseller'], $data['sale'])){
                            $msg = urlencode('Anúncio cadastrado com sucesso!');
                            header("Location: ".BASE_URL."adminAdvertisementsCMS?notification=".$msg."&status=alert-info");
                            exit;
                        }else{
                            $data['notice'] = '<div class="alert alert-warning">Anúncio já cadastrado.</div>';
                        }
                    }else{
                        $data['notice'] = '<div class="alert alert-warning">Preencha todos os campos.</div>';
                    }
                }else{
                    $data['notice'] = '<div class="alert alert-warning">Preencha todos os campos.</div>';
                }
            }

            $this->loadTemplateCMS('cms/adminAdvertisements/new', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function shows the Admin Advertisement edit page.
     */
    public function editAdvertisement($id){
        $u = new Administrators();
        $a = new Advertisements();
        $c = new Categories();
        $s = new Store();
        $data = array();

        $id = addslashes(base64_decode(base64_decode($id)));

        if($u->isLogged()){
            $data['title'] = 'ADM - Editar Anúncio';
            $data['link'] = 'adminAdvertisementsCMS/index';
            $data['userData'] = $u->getData(1, $_SESSION['adminLogin']);
            $data['advertisementData'] = $a->getDataById($id);
            $data['categoryData'] = $c->getList();
            $data['subcategoryData'] = array();
            foreach ($data['categoryData'] as $category){
                if($category['id'] == $data['advertisementData']['id_category']){
                    foreach ($category['subs'] as $subcategory){
                        $data['subcategoryData'][] = $subcategory;
                    }
                }
            }

            if(isset($_POST['title'])){
                $data['advertisementData']['title'] = addslashes($_POST['title']);
                $data['advertisementData']['id_category'] = addslashes($_POST['id_category']);
                $data['advertisementData']['id_subcategory'] = addslashes($_POST['id_subcategory']);
                $data['advertisementData']['abstract'] = addslashes($_POST['abstract']);
                $data['advertisementData']['media_type'] = addslashes($_POST['media_type']);
                $data['advertisementData']['media_link'] = addslashes($_POST['media_link']);
                $data['advertisementData']['description'] = addslashes($_POST['description']);
                $data['advertisementData']['rating'] = addslashes($_POST['rating']);
                if(isset($_POST['highlight'])){
                    $data['advertisementData']['highlight'] = 1;
                }else{
                    $data['advertisementData']['highlight'] = Null;
                }
                if(isset($_POST['new'])){
                    $data['advertisementData']['new'] = 1;
                }else{
                    $data['advertisementData']['new'] = Null;
                }
                if(isset($_POST['bestseller'])){
                    $data['advertisementData']['bestseller'] = 1;
                }else{
                    $data['advertisementData']['bestseller'] = Null;
                }
                if(isset($_POST['sale'])){
                    $data['advertisementData']['sale'] = 1;
                }else{
                    $data['advertisementData']['sale'] = Null;
                }
                if((!empty($data['advertisementData']['title'])) && (!empty($data['advertisementData']['id_category'])) && (!empty($data['advertisementData']['id_subcategory'])) && (!empty($data['advertisementData']['abstract'])) && (!empty($data['advertisementData']['media_type'])) && (!empty($data['advertisementData']['media_link'])) && (!empty($data['advertisementData']['description']))){

                    if($data['advertisementData']['media_type'] == 1){
                        $embed_link = $s->getYoutubeEmbedUrl($data['advertisementData']['media_link']);
                        if(!empty($embed_link)){
                            $data['advertisementData']['media'] = "<iframe width='640' height='315' src=".$embed_link." frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>";
                        }else{
                            $data['advertisementData']['media'] = '';
                        }
                    }elseif($data['advertisementData']['media_type'] == 2){
                        $oembed_endpoint = 'http://vimeo.com/api/oembed';
                        // Grab the video url from the url, or use default
                        $video_url = $data['advertisementData']['media_link'];
                        // Create the URLs
                        $xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($video_url);
                        // Curl helper function
                        function curl_get($url) {
                            $curl = curl_init($url);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                            $return = curl_exec($curl);
                            curl_close($curl);
                            return $return;
                        }
                        if(curl_get($xml_url) == '404 Not Found'){
                            $data['advertisementData']['media'] = '';
                        }else{
                            $oembed = simplexml_load_string(curl_get($xml_url));
                            $data['advertisementData']['media'] = $oembed->html;
                        }
                    }elseif($data['advertisementData']['media_type'] == 3){
                        if($s->url_exists($data['advertisementData']['media_link'])){
                            $data['advertisementData']['media'] = "<img width='100%' src=".$data['advertisementData']['media_link'].">";
                        }else{
                            $data['advertisementData']['media'] = '';
                        }
                    }else{
                        $data['advertisementData']['media'] = $data['advertisementData']['media_type'];
                    }

                    if(!empty($data['advertisementData']['media'])){
                        if($a->edit($id, $data['advertisementData']['id_category'], $data['advertisementData']['id_subcategory'], $data['advertisementData']['title'], $data['advertisementData']['abstract'], $data['advertisementData']['media_type'], $data['advertisementData']['media_link'], $data['advertisementData']['media'], $data['advertisementData']['description'], 1, 2, $data['advertisementData']['rating'], $data['advertisementData']['highlight'], $data['advertisementData']['new'], $data['advertisementData']['bestseller'], $data['advertisementData']['sale'])){
                            $msg = urlencode('Anúncio editado com sucesso!');
                            header("Location: ".BASE_URL."adminAdvertisementsCMS?notification=".$msg."&status=alert-info");
                            exit;
                        }else{
                            $data['notice'] = '<div class="alert alert-warning">Anúncio já cadastrado.</div>';
                        }
                    }else{
                        $data['notice'] = '<div class="alert alert-warning">Link da mídia inválido.</div>';
                    }
                }else{
                    $data['notice'] = '<div class="alert alert-warning">Preencha todos os campos.</div>';
                }
            }
            $this->loadTemplateCMS('cms/adminAdvertisements/edit', $data);
        }else{
            header("Location: ".BASE_URL);
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

        $id = addslashes(base64_decode(base64_decode($id)));

        if($u->isLogged()){
            $a->inactivate($id);
            header("Location: ".BASE_URL."adminAdvertisementsCMS");
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }
}