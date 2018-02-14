<?php
/**
 * This class is the Controller of the LoginPage.
 *
 * @author  samuelrcosta
 * @version 1.0.2, 01/12/2017
 * @since   1.0, 01/10/2017
 */

use \ReCaptcha\ReCaptcha;

class loginController extends Controller{

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * This function shows the login and register page.
     * Receive the input data and use the user's login method
     */
    public function index(){
        $u = new Users();
        $e = new States();
        $c = new Cities();
        $cats = new Categories();
        $store = new Store();
        global $config;
        $reCaptcha = new ReCaptcha($config['google_captch_secret']);
        $data = array();
        $data['title'] = 'Faça o login';
        $data['categoryMenuData'] = $cats->getActiveList();
        $data['states'] = $e->getList();

        if(!$u->isLogged()){
            $fb = new \Facebook\Facebook([
                'app_id' => $config['fb_appId'],
                'app_secret' => $config['fb_secretKey'],
                'default_graph_version' => 'v2.10',
                //'default_access_token' => '{access-token}', // optional
            ]);
            $helper = $fb->getRedirectLoginHelper();

            $permissions = ['email']; // Optional permissions
            $loginUrl = $helper->getLoginUrl(BASE_URL."login/fbLogin", $permissions);
            $data['loginFbUrl'] = $loginUrl;

            if(isset($_POST['login']['email']) && !empty($_POST['login']['email'])){
                $email = addslashes($_POST['login']['email']);
                $password = addslashes($_POST['login']['password']);
                //$keepLogged = addslashes($_POST['login']['keepLogged']);

                if($u->login($email, $password)){
                    /*
                    if(isset($_POST['login']['keepLogged'])){
                        setcookie("idLogin",$_SESSION['idLogin'],time()+432000);
                    }
                    */
                    header('Location:'.BASE_URL);
                    exit;
                }else{
                    $data['login']['email'] = $email;
                    $data['login']['notice'] = '<div class="alert alert-warning">E-mail ou senha inválidos.</div>';
                }
            }
            if(isset($_POST['register']['name']) && !empty($_POST['register']['name'])){
                $name = addslashes($_POST['register']['name']);
                $email = addslashes($_POST['register']['email']);
                $password = addslashes($_POST['register']['password']);
                $id_state = addslashes($_POST['register']['id_state']);
                $id_city = addslashes($_POST['register']['id_city']);

                $response = null;
                if ($_POST["g-recaptcha-response"]) {
                    $response = $reCaptcha->verify(
                        $_SERVER["REMOTE_ADDR"],
                        $_POST["g-recaptcha-response"]
                    );
                }
                if($response != null){
                    if(!empty($name) && !empty($email) && !empty($password) && !empty($id_state) && !empty($id_city)){
                        if($u->register($name, $email, $password, $id_state, $id_city)){
                            $store->subscribeMailChimp($email, $name);
                            $msg = urlencode('Cadastro efetuado com sucesso!');
                            header("Location: ".BASE_URL."login?notification=".$msg."&status=alert-success");
                            exit;
                        }else{
                            $data['register']['name'] = $name;
                            $data['register']['email'] = $email;
                            $data['register']['id_state'] = $id_state;
                            $data['cities'] = $c->getCities($id_state);
                            $data['register']['id_city'] = $id_city;
                            $data['register']['notice'] = '<div class="alert alert-warning">Usuário já cadastrado. Faça o login agora ou <a href="'.BASE_URL.'login/recoverPassword" class="alert-link">Recupere sua senha</a></div>';
                        }
                    }else{
                        $data['register']['name'] = $name;
                        $data['register']['email'] = $email;
                        $data['register']['id_state'] = $id_state;
                        $data['cities'] = $c->getCities($id_state);
                        $data['register']['id_city'] = $id_city;
                        $data['register']['notice'] = '<div class="alert alert-warning">Preencha todos os campos.</div>';
                    }
                }else{
                    $data['register']['name'] = $name;
                    $data['register']['email'] = $email;
                    $data['register']['id_state'] = $id_state;
                    $data['cities'] = $c->getCities($id_state);
                    $data['register']['id_city'] = $id_city;
                    $data['register']['notice'] = '<div class="alert alert-warning">Marque a verificação de segurança.</div>';
                }
            }
            $this->loadTemplate('login/index', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function shows the register page with Facebook information.
     */
    public function fbLogin(){
        $u = new Users();
        $e = new States();
        $c = new Cities();
        $cats = new Categories();
        $store =  new Store();
        global $config;
        $reCaptcha = new ReCaptcha($config['google_captch_secret']);
        $data = array();
        $data['states'] = $e->getList();
        $data['categoryMenuData'] = $cats->getActiveList();
        $data['title'] = 'Faça seu cadastro';
        //FACEBOOK
        $fb = new \Facebook\Facebook([
            'app_id' => $config['fb_appId'],
            'app_secret' => $config['fb_secretKey'],
            'default_graph_version' => 'v2.10',
            //'default_access_token' => '{access-token}', // optional
        ]);
        if(isset($_POST['name']) && !empty($_POST['name'])){
            $name = addslashes($_POST['name']);
            $email = addslashes($_POST['email']);
            $password = addslashes($_POST['password']);
            $id_state = addslashes($_POST['id_state']);
            $id_city = addslashes($_POST['id_city']);

            $response = null;
            if ($_POST["g-recaptcha-response"]) {
                $response = $reCaptcha->verify(
                    $_SERVER["REMOTE_ADDR"],
                    $_POST["g-recaptcha-response"]
                );
            }
            if($response != null){
                if(!empty($name) && !empty($email) && !empty($password) && !empty($id_state) && !empty($id_city)){
                    if($u->register($name, $email, $password, $id_state, $id_city)){
                        $store->subscribeMailChimp($email, $name);
                        $msg = urlencode('Cadastro efetuado com sucesso!');
                        header("Location: ".BASE_URL."login?notification=".$msg."&status=alert-success");
                        exit;
                    }else{
                        $data['name'] = $name;
                        $data['email'] = $email;
                        $data['id_state'] = $id_state;
                        $data['cities'] = $c->getCities($id_state);
                        $data['id_city'] = $id_city;
                        $data['notice'] = '<div class="alert alert-warning">Usuário já cadastrado. <a href="'.BASE_URL.'login" class="alert-link">Faça o login agora</a> ou <a href="'.BASE_URL.'login/recoverPassword" class="alert-link">Recupere sua senha</a></div>';
                    }
                }else{
                    $data['name'] = $name;
                    $data['email'] = $email;
                    $data['id_state'] = $id_state;
                    $data['cities'] = $c->getCities($id_state);
                    $data['id_city'] = $id_city;
                    $data['notice'] = '<div class="alert alert-warning">Preencha todos os campos.</div>';
                }
            }else{
                $data['name'] = $name;
                $data['email'] = $email;
                $data['id_state'] = $id_state;
                $data['cities'] = $c->getCities($id_state);
                $data['id_city'] = $id_city;
                $data['notice'] = '<div class="alert alert-warning">Marque a verificação de segurança.</div>';
            }
            $this->loadTemplate('login/register', $data);
            exit;
        }
        $helper = $fb->getRedirectLoginHelper();
        $accessToken = $helper->getAccessToken();
        if (!isset($accessToken)) {
            header("Location: ".BASE_URL.'login');
            exit;
        }
        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();
        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId($config['fb_appId']); // Replace {app-id} with your app id
        // If you know the user ID this access token belongs to, you can validate it here
        //$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();
        if (! $accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
        }
        $_SESSION['fb_access_token'] = (string) $accessToken;
        $response = $fb->get('/me?fields=id,name,email', $accessToken);
        $user = $response->getGraphUser();

        $userData = $u->getData(2, $user['email']);
        if(!empty($userData)){
            $_SESSION['idLogin'] = $userData['id'];
            header("Location: ".BASE_URL);
        }else{
            $data['title'] = 'Faça seu cadastro';
            $data['name'] =  $user['name'];
            $data['email'] = $user['email'];

            $this->loadTemplate('login/register', $data);
        }

    }

    /**
     * This function shows the register page.
     * Receive the input data and use the user's register method
     */
    public function register(){
        $u = new Users();
        $e = new States();
        $c = new Cities();
        $cats = new Categories();
        $store = new Store();
        global $config;
        $reCaptcha = new ReCaptcha($config['google_captch_secret']);
        $data = array();

        $data['categoryMenuData'] = $cats->getActiveList();
        $data['title'] = 'Faça seu cadastro';
        $data['states'] = $e->getList();

        if(isset($_POST['name']) && !empty($_POST['name'])){
            $name = addslashes($_POST['name']);
            $email = addslashes($_POST['email']);
            $password = addslashes($_POST['password']);
            $id_state = addslashes($_POST['id_state']);
            $id_city = addslashes($_POST['id_city']);

            $response = null;
            if ($_POST["g-recaptcha-response"]) {
                $response = $reCaptcha->verify(
                    $_SERVER["REMOTE_ADDR"],
                    $_POST["g-recaptcha-response"]
                );
            }
            if($response != null){
                if(!empty($name) && !empty($email) && !empty($password) && !empty($id_state) && !empty($id_city)){
                    if($u->register($name, $email, $password, $id_state, $id_city)){
                        $store->subscribeMailChimp($email, $name);
                        $msg = urlencode('Cadastro efetuado com sucesso!');
                        header("Location: ".BASE_URL."login?notification=".$msg."&status=alert-success");
                        exit;
                    }else{
                        $data['name'] = $name;
                        $data['email'] = $email;
                        $data['id_state'] = $id_state;
                        $data['cities'] = $c->getCities($id_state);
                        $data['id_city'] = $id_city;
                        $data['notice'] = '<div class="alert alert-warning">Usuário já cadastrado. <a href="'.BASE_URL.'login" class="alert-link">Faça o login agora</a> ou <a href="'.BASE_URL.'login/recoverPassword" class="alert-link">Recupere sua senha</a></div>';
                    }
                }else{
                    $data['name'] = $name;
                    $data['email'] = $email;
                    $data['id_state'] = $id_state;
                    $data['cities'] = $c->getCities($id_state);
                    $data['id_city'] = $id_city;
                    $data['notice'] = '<div class="alert alert-warning">Preencha todos os campos.</div>';
                }
            }else{
                $data['name'] = $name;
                $data['email'] = $email;
                $data['id_state'] = $id_state;
                $data['cities'] = $c->getCities($id_state);
                $data['id_city'] = $id_city;
                $data['notice'] = '<div class="alert alert-warning">Marque a verificação de segurança.</div>';
            }
        }
        $this->loadTemplate('login/register', $data);
    }

    /**
     * This function use the user's logoff method and redirects to homepage
     */
    public function logoff(){
        $u = new Users();
        $u->logoff();
        header("Location: ".BASE_URL);
        exit;
    }

    /**
     * This function retrieves cities of the selected state
     *
     * @param   $id_state   int for the state id
     */
    public function cities($id_state){
        $c = new Cities();
        $list = $c->getCities(addslashes($id_state));
        echo (json_encode($list));
    }

    /**
     * This function shows the sending screen of the password recovery email, if
     * param $hashRecover is not empty, shows the modify screen the user's password
     * using the code of recovery sends to user's email
     *
     * @param   $hashRecover    string for recover hash code
     */
    public function recoverPassword($hashRecover = ''){
        $u = new Users();
        $cats = new Categories();
        $data = array();
        $data['categoryMenuData'] = $cats->getActiveList();
        $data['title'] = 'Recupere sua senha';
        if(!empty($hashRecover)){
            $hashRecover = addslashes($hashRecover);
            $userData = $u->getDataByRecoverHash($hashRecover);
            if(!empty($userData)){
                if(isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['confirmPassword']) && !empty($_POST['confirmPassword'])){
                    $password = addslashes($_POST['password']);
                    $confirmPassword = addslashes($_POST['confirmPassword']);
                    if($password == $confirmPassword){
                        $u->edit($userData['id'], $userData['name'], $userData['cpf'], $userData['email'], $password, $userData['telephone'], $userData['cellphone'], $userData['id_state'], $userData['id_city']);
                        $u->setHashRecuperacao($userData['id'], Null);
                        $userData['notice'] = '<div class="alert alert-success notificacao">Senha alterada com sucesso!</div>';
                        $data['title'] = 'Login';
                        $this->loadTemplate('login/index', $data);
                        exit;
                    }else{
                        $data['notice'] = '<div class="alert alert-warning">As senhas não são compatíveis.</div>';
                        exit;
                    }
                }
            }else{
                header("Location:".BASE_URL."login");
                exit;
            }
            $this->loadTemplate('/login/updatePassword', $data);
        }else{
            if (isset($_POST['email']) && !empty($_POST['email'])) {
                $email = addslashes($_POST['email']);
                if (!empty($email)) {
                    if ($u->recoverPassword($email)) {
                        $urlmsg = 'E-mail de recuperação enviado com sucesso.';
                        header("Location: " . BASE_URL . "/login?notification=" . urlencode($urlmsg) . "&status=alert-success");
                        exit;
                    } else {
                        $data['email'] = $email;
                        $data['notice'] = '<div class="alert alert-warning">E-mail não cadastrado.</div>';
                    }
                } else {
                    $data['notice'] = '<div class="alert alert-warning">Preencha todos os campos!</div>';
                }
            }
        }
        $this->loadTemplate('login/recoverPassword', $data);
    }

}