<?php
/**
 * This class is the Controller of the Information pages.
 *
 * @author  samuelrcosta
 * @version 1.0.0, 04/21/2017
 * @since   1.0, 04/21/2017
 */

class infoController extends Controller{

    // Models instances
    private $a;
    private $c;
    private $s;

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();
        // Initialize instances
        $this->a = new Areas();
        $this->c = new Contacts();
        $this->s = new Store();
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
    public function about(){
        $data = array();

        $data['title'] = 'Optium - Sobre a empresa';
        $data['menuUrlActive'] = 'sobre';
        $data['categoryMenuData'] = $this->a->getCompleteList();
        $this->loadTemplate('info/about', $data);
    }

    /**
     * This function shows the contact page
     */
    public function contact(){
        $data = array();

        $data['title'] = 'Optium - Contato';
        $data['categoryMenuData'] = $this->a->getCompleteList();
        $this->loadTemplate('info/contact', $data);
    }

    /**
     * This function saves a contact POST
     */
    public function saveContact(){
        if(!empty($_POST)){
            // Array for check the keys
            $keys = array('name', 'email', 'phone', 'subject', 'message');
            if($this->s->array_keys_check($keys, $_POST)){
                // Check if the array is completed
                if($this->s->array_check_completed_keys($keys, $_POST)){
                    $name = addslashes($_POST['name']);
                    $email = addslashes($_POST['email']);
                    $phone = addslashes($_POST['phone']);
                    $subject = addslashes($_POST['subject']);
                    $message = addslashes($_POST['message']);
                    // Sends E-mail to Admin
                    $mail_subject = "Optium - Novo contato no site";
                    $mail_text = "<p><b>Uma solicitação de contato foi cadastrada no site</b></p>";
                    $mail_text .= "<p><b>Nome: </b>".$name."<br>";
                    $mail_text .= "<b>E-mail: </b>".$email."<br>";
                    $mail_text .= "<b>Telefone: </b>".$phone."<br>";
                    $mail_text .= "<b>Assunto da Mensagem: </b>".$subject."<br>";
                    $mail_text .= "<b>Mensagem: </b><br><span style='white-space: pre;'>".$message."</span></p>";
                    $template = file_get_contents(BASE_URL."assets/templates/mail_template.htm");
                    $msg = str_replace("#EMAIL_TEXT#", $mail_text, $template);
                    $recipient = array("name" => $this->MailName, "email" => $this->MailUsername);
                    $this->s->sendMail(array($recipient), $mail_subject, $msg);
                    // Sends E-mail to user
                    $mail_subject = "Optium - Recebemos sua mensagem de contato";
                    $mail_text = "<p><b>Olá ".$name."!</b></p>";
                    $mail_text .= "<p>Recebemos seu contato.<br>";
                    $mail_text .= "Responderemos o mais rápido possível.<br></p>";
                    $msg = str_replace("#EMAIL_TEXT#", $mail_text, $template);
                    $recipient = array("name" => $name, "email" => $email);
                    $this->s->sendMail(array($recipient), $mail_subject, $msg);
                    // Save in database
                    $this->c->register($name, $email, $phone, $subject, $message);
                    // Returns true
                    echo json_encode(true);
                }else{
                    echo json_encode("Dados incompletos.");
                }
            }else{
                echo json_encode("Dados corrompidos.");
            }
        }else{
            exit;
        }
    }

    /**
     * This function shows the terms of use page
     */
    public function TermsOfUse(){
        $data = array();

        $data['title'] = 'Optium - Termos de Uso';
        $data['categoryMenuData'] = $this->a->getCompleteList();
        $this->loadTemplate('info/termsOfUse', $data);
    }

    /**
     * This function shows the privacy policy page
     */
    public function PrivacyPolicy(){
        $data = array();

        $data['title'] = 'Optium - Política de Privacidade';
        $data['categoryMenuData'] = $this->a->getCompleteList();
        $this->loadTemplate('info/PrivacyPolicy', $data);
    }

}