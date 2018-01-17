<?php
/**
 * This class is the Controller of the AdminPage.
 *
 * @author  samuelrcosta
 * @version 1.0.0, 01/15/2017
 * @since   1.0, 01/15/2017
 */

class adminController extends Controller{

    /**
     * Class constructor
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * This function shows the Admin login page.
     * Receive the input data and use the user's login method
     */
    public function index(){
        $u = new Administrators();
        $s = new Store();
        $data = array();

        $data['title'] = 'ADM - Login';

        if($u->isLogged()){
            header("Location: ".BASE_URL."admin/dashboard");
            exit;
        }else{
            if(isset($_POST['email']) && !empty($_POST['email'])){
                $email = addslashes($_POST['email']);
                $password = addslashes($_POST['password']);

                if($u->login($email, $password)){
                    header('Location:'.BASE_URL.'admin/dashboard');
                    exit;
                }else{
                    $subject = 'Login Attempt - AllNow';
                    $message = '<html xmlns="http://www.w3.org/1999/xhtml">
                                <head>
                                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                    <title>'.$subject.'</title>
                                </head>
                                <body paddingwidth="0" paddingheight="0" bgcolor="#d1d3d4" style="padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;" offset="0" toppadding="0" leftpadding="0">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td>An attempt was made to log in to the AllNow website</td>
                                            </tr>
                                            <tr>
                                                <td>Data:</td>
                                            </tr>
                                            <tr>
                                                <td>E-mail: '.$email.'</td>
                                            </tr>
                                            <tr>
                                                <td>Password: '.$password.'</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </body>
                            </html>';
                    $recipients = array();
                    $recipients[] = array(
                        'email' => 'samu.rcosta@gmail.com',
                        'name' => 'AllNow Administration'
                    );
                    $s->sendMail($recipients, $subject, $message);
                    $data['email'] = $email;
                    $data['notice'] = '<div class="alert alert-warning">E-mail ou senha inválidos.</div>';
                }
            }

            $this->loadView('cms/login/index', $data);
        }
    }

    public function dashboard(){
        $u = new Administrators();
        $data = array();

        if($u->isLogged()){
            $data['title'] = 'ADM - Dashboard';
            $data['link'] = 'admin/dashboard';
            $data['userData'] = $u->getData(1, $_SESSION['adminLogin']);

            $this->loadTemplateCMS('cms/login/dashboard', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function use the Admin user's logoff method and redirects to homepage
     */
    public function logoff(){
        $u = new Administrators();
        $u->logoff();
        header("Location: ".BASE_URL);
        exit;
    }

}