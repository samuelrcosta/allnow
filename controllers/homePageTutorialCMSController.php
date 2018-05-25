<?php
/**
 * This class is the Controller of the Admin homePage configurations.
 *
 * @author  samuelrcosta
 * @version 1.0.0, 05/22/2018
 * @since   1.0, 05/22/2018
 */

class homePageTutorialCMSController extends Controller{

    // Models instances
    private $u;
    private $c;
    private $s;

    /**
     * Class constructor
     */
    public function __construct(){
        // Initialize instances
        $this->u = new Administrators();
        $this->c = new Configs();
        $this->s = new Store();
        parent::__construct();
    }

    /**
     * This function shows the Home Page data configuration page.
     */
    public function index(){
        $data = array();

        if($this->u->isLogged() && $this->u->havePermission('homeTutorial')){
            $data['title'] = 'ADM - Configs Tela Inicial';
            $data['link'] = 'homePageTutorialCMS/index';
            $data['userData'] = $this->u->getData(1, $_SESSION['adminLogin']);
            $data['configData'] = $this->c->getConfig("tutorial_advertisement");
            $this->loadTemplateCMS('cms/homePageTutorial/index', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function edit homePage config data.
     */
    public function saveData(){
        if($this->u->isLogged() && $this->u->havePermission('homeTutorial')){
            if(!empty($_POST)){
                // Array for check the keys
                $keys = array('title', 'media_type', 'media_link');
                if($this->s->array_keys_check($keys, $_POST)){
                    $title = addslashes($_POST['title']);
                    $text = addslashes($_POST['text']);
                    $media_type = addslashes($_POST['media_type']);
                    $media_link = addslashes($_POST['media_link']);
                    $media = "";
                    if(isset($_POST['active_radio'])){
                        $status = "on";
                    }else{
                        $status = "off";
                    }

                    // Check medias validate
                    if($status == "on"){
                        if($media_type == 1){
                            $youtubeID= $this->s->getYoutubeId($media_link);
                            if(!empty($youtubeID)) {
                                $media = $youtubeID;
                            }else{
                                echo json_encode("Link do Youtube inválido.");
                                exit;
                            }
                        }elseif($media_type == 2){
                            $oembed_endpoint = 'http://vimeo.com/api/oembed';
                            // Grab the video url from the url, or use default
                            $video_url = $media_link;
                            // Create the URLs
                            $xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($video_url);
                            if($this->s->curl_get($xml_url) == '404 Not Found'){
                                echo json_encode("Link do Vimeo inválido.");
                                exit;
                            }else{
                                $oembed = simplexml_load_string($this->s->curl_get($xml_url));
                                $media = $oembed->video_id;
                            }
                        }else{
                            echo json_encode("Tipo de Mídia inválido.");
                            exit;
                        }
                    }
                    $array = array(
                        "status" => $status,
                        "data" => array(
                            "title" => $title,
                            "text" => $text,
                            "media_type" => $media_type,
                            "media_link" => $media_link,
                            "media" => $media
                        )
                    );

                    $this->c->updateConfig('tutorial_advertisement', json_encode($array));
                    echo json_encode(true);
                    exit;
                }else{
                    echo json_encode("Dados corrompidos.");
                    exit;
                }
            }
        }
    }
}