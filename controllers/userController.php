<?php
/**
 * This class is the Controller of the User data pages.
 *
 * @author  samuelrcosta
 * @version 1.0, 01/11/2017
 * @since   1.0, 01/11/2017
 */
class userController extends Controller{

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * This page not exists, redirect to login page.
     */
    public function index(){
        header("Location: ".BASE_URL);
        exit;
    }

    /**
     * This page shows user data, if the user is logged in.
     */
    public function account(){
        $u = new Users();
        $data = array();
        if($u->isLogged()){
            $userData = $u->getData(1, $_SESSION['idLogin']);
            $data['title'] = 'Minha Conta';
            $data['userData'] = $userData;
            $this->loadTemplate('user/account', $data);
        }else{
            header("Location: ".BASE_URL."login");
            exit;
        }
    }

    /**
     * This function checks if the user if logged in, if so shows the user data editing page.
     * Receive the input data and use the user's edit method.
     */
    public function editAccount(){
        $u = new Users();
        $e = new States();
        $c = new Cities();
        $data = array();
        if($u->isLogged()) {
            $userData = $u->getData(1, $_SESSION['idLogin']);
            $data['title'] = 'Minha Conta';
            $data['userData'] = $userData;
            $data['states'] = $e->getList();
            $data['cities'] = $c->getCities($userData['id_state']);

            if(isset($_POST['name']) && !empty($_POST['name']) ) {
                $name = addslashes($_POST['name']);
                $cpf = addslashes($_POST['cpf']);
                $email = addslashes($_POST['email']);
                $password = addslashes($_POST['password']);
                $newPassword = addslashes($_POST['newPassword']);
                $telephone = addslashes($_POST['telephone']);
                $cellphone = addslashes($_POST['cellphone']);
                $street = addslashes($_POST['street']);
                $number = addslashes($_POST['number']);
                $complement = addslashes($_POST['complement']);
                $neighborhood = addslashes($_POST['neighborhood']);
                $zip_code = addslashes($_POST['zip_code']);
                $id_state = addslashes($_POST['id_state']);
                $id_city = addslashes($_POST['id_city']);

                if(!empty($name) && !empty($email) && !empty($id_state) && !empty($id_city)){
                    if($password != "" || $newPassword != ""){
                        if($u->login($email, $password)){
                            if ($u->edit($_SESSION['idLogin'], $name, $cpf, $email, $newPassword, $telephone, $cellphone, $street, $number, $complement, $neighborhood, $zip_code, $id_state, $id_city)){
                                $msg = urlencode('Dados editados com sucesso.');
                                header("Location: " . BASE_URL . "user/account?notification=".$msg."&status=alert-success");
                            }else{
                                $data['notice'] = '<div class="alert alert-warning">O email digitado já está cadastrado em outra conta.</div>';
                            }
                        }else{
                            $data['notice'] = '<div class="alert alert-danger">Senha incorreta.</div>';
                        }
                    }else{
                        if($u->edit($_SESSION['idLogin'], $name, $cpf, $email, '', $telephone, $cellphone, $street, $number, $complement, $neighborhood, $zip_code, $id_state, $id_city)){
                            $msg = urlencode('Dados editados com sucesso.');
                            header("Location: " . BASE_URL . "user/account?notification=".$msg."&status=alert-success");
                        }else{
                            $data['notice'] = '<div class="alert alert-warning">O email digitado já está cadastrado em outra conta.</div>';
                        }
                    }
                }else{
                    $data['notice'] = '<div class="alert alert-warning">Preencha todos os campos obrigatórios</div>';
                }
            }
            $this->loadTemplate('user/editAccount', $data);
        }else{
            header("Location: ".BASE_URL."login");
            exit;
        }
    }

    /**
     * This function use the user's delete method and redirects to homepage
     */
    public function deleteAccount(){
        $u = new Users();

        if($u->isLogged()) {
            $u->delete($_SESSION['idLogin']);
            $u->logOff();
            header("Location: ".BASE_URL);
        }else{
            header("Location: ".BASE_URL."login");
            exit;
        }
    }

    /**
     * This function shows user advertisements, if it's logged in
     */
    public function advertisements(){
        $u = new Users();
        $a = new Advertisements();
        $data = array();

        if($u->isLogged()) {
            $data['title'] = "Meus Anúncios";
            $data['adsData'] = $a->getUserAds($_SESSION['idLogin']);
            $this->loadTemplate('user/advertisements', $data);
        }else{
            header("Location: ".BASE_URL."login");
            exit;
        }
    }

    /**
     * This function shows user advertisement register page, if it's logged in
     */
    public function newAdvertisement(){
        $u = new Users();
        $a = new Advertisements();
        $c = new Categories();
        $s = new Store();
        $data = array();

        if($u->isLogged()) {
            $data['title'] = "Novo Anúncio";
            $data['categoryData'] = $c->getUserList();

            if (isset($_POST['title'])) {
                $data['adtitle'] = addslashes($_POST['title']);
                $data['id_category'] = addslashes($_POST['id_category']);
                $data['id_subcategory'] = addslashes($_POST['id_subcategory']);
                $data['subcategories'] = array();
                foreach ($data['categoryData'] as $category) {
                    if ($category['id'] == $data['id_category']) {
                        foreach ($category['subs'] as $subcategory) {
                            $data['subcategories'][] = $subcategory;
                        }
                    }
                }
                $data['abstract'] = addslashes($_POST['abstract']);
                $data['media_type'] = addslashes($_POST['media_type']);
                $data['media_link'] = addslashes($_POST['media_link']);
                $data['description'] = $_POST['description'];
                if ((!empty($data['adtitle'])) && (!empty($data['id_category'])) && (!empty($data['id_subcategory'])) && (!empty($data['abstract'])) && (!empty($data['media_link'])) && (!empty($data['description'])) && (!empty($data['media_type']))) {

                    if ($data['media_type'] == 1) {
                        $embed_link = $s->getYoutubeEmbedUrl($data['media_link']);
                        if (!empty($embed_link)) {
                            $data['media'] = "<iframe width='640' height='315' src=" . $embed_link . " frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>";
                        } else {
                            $data['media'] = '';
                        }
                    } elseif ($data['media_type'] == 2) {
                        $oembed_endpoint = 'http://vimeo.com/api/oembed';
                        // Grab the video url from the url, or use default
                        $video_url = $data['media_link'];
                        // Create the URLs
                        $xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($video_url);
                        // Curl helper function
                        function curl_get($url)
                        {
                            $curl = curl_init($url);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                            $return = curl_exec($curl);
                            curl_close($curl);
                            return $return;
                        }

                        if (curl_get($xml_url) == '404 Not Found') {
                            $data['media'] = '';
                        } else {
                            $oembed = simplexml_load_string(curl_get($xml_url));
                            $data['media'] = $oembed->html;
                        }
                    } elseif ($data['media_type'] == 3) {
                        if ($s->url_exists($data['media_link'])) {
                            $data['media'] = "<img width='100%' src=" . $data['media_link'] . ">";
                        } else {
                            $data['media'] = '';
                        }
                    } else {
                        $data['media'] = $data['media_link'];
                    }

                    if (!empty($data['media'])) {
                        if ($a->register($_SESSION['idLogin'], $data['id_category'], $data['id_subcategory'], $data['adtitle'], $data['abstract'], $data['media_type'], $data['media_link'], $data['media'], $data['description'], 1, 1)) {
                            $msg = urlencode('Anúncio cadastrado com sucesso!');
                            header("Location: " . BASE_URL . "user/advertisements?notification=" . $msg . "&status=alert-info");
                            exit;
                        } else {
                            $data['notice'] = '<div class="alert alert-warning">Anúncio já cadastrado, escolha outro título.</div>';
                        }
                    } else {
                        $data['notice'] = '<div class="alert alert-warning">Preencha todos os campos.</div>';
                    }
                } else {
                    $data['notice'] = '<div class="alert alert-warning">Preencha todos os campos.</div>';
                }
            }

            $this->loadTemplate('user/newAdvertisement', $data);
        }else{
            header("Location: " . BASE_URL . "login");
            exit;
        }
    }

    public function editAdvertisement($id){
        $u = new Users();
        $a = new Advertisements();
        $c = new Categories();
        $s = new Store();
        $data = array();

        $id = addslashes(base64_decode(base64_decode($id)));

        if($u->isLogged()){
            $data['title'] = 'Editar Anúncio';
            $data['advertisementData'] = $a->getDataById($id);
            $data['categoryData'] = $c->getUserList();
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
                $data['advertisementData']['description'] = ($_POST['description']);
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
                        if($a->edit($id, $data['advertisementData']['id_category'], $data['advertisementData']['id_subcategory'], $data['advertisementData']['title'], $data['advertisementData']['abstract'], $data['advertisementData']['media_type'], $data['advertisementData']['media_link'], $data['advertisementData']['media'], $data['advertisementData']['description'], 1, 1)){
                            $msg = urlencode('Anúncio editado com sucesso!');
                            header("Location: ".BASE_URL."user/advertisements?notification=".$msg."&status=alert-info");
                            exit;
                        }else{
                            $data['notice'] = '<div class="alert alert-warning">Anúncio já cadastrado, use outro nome.</div>';
                        }
                    }else{
                        $data['notice'] = '<div class="alert alert-warning">Link da mídia inválido.</div>';
                    }
                }else{
                    $data['notice'] = '<div class="alert alert-warning">Preencha todos os campos.</div>';
                }
            }
            $this->loadTemplate('user/editAdvertisement', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }


    /**
     * This function delete a user's advertisement if it's logged in, and
     * redirects to advertisements page.
     */
    public function deleteAdvertisement($id){
        $u = new Users();
        $a = new Advertisements();

        $id = addslashes(base64_decode(base64_decode($id)));

        if($u->isLogged()){
            $a->inactivate($id);
            header("Location: ".BASE_URL."user/advertisements");
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }
}