<?php
/**
 * This class is the Controller of the Admin receives contacts panel.
 *
 * @author  samuelrcosta
 * @version 1.0.0, 05/02/2018
 * @since   1.0, 05/02/2018
 */

class contactsCMSController extends Controller{

    /**
     * Class constructor
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * This function shows the Contacts List page.
     */
    public function index(){
        $u = new Administrators();
        $c = new Contacts();
        $data = array();

        if($u->isLogged() && $u->havePermission('contacts')){
            $data['title'] = 'ADM - Contatos';
            $data['link'] = 'contactsCMS/index';
            $data['userData'] = $u->getData(1, $_SESSION['adminLogin']);
            $data['contactsData'] = $c->getList();

            $this->loadTemplateCMS('cms/contacts/index', $data);
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function shows the contact details page.
     */
    public function viewContact($id){
        $u = new Administrators();
        $c = new Contacts();
        $data = array();

        if($u->isLogged() && $u->havePermission('contacts')){
            $id = addslashes(base64_decode(base64_decode($id)));
            $data['title'] = 'ADM - Visualizar Contato';
            $data['link'] = 'contactsCMS/index';
            $data['userData'] = $u->getData(1, $_SESSION['adminLogin']);
            $data['contactData'] = $c->getDataById($id);
            if(!empty($data['contactData'])){
                $this->loadTemplateCMS('cms/contacts/viewContact', $data);
            }else{
                $msg = urlencode('Erro, contato não encontrado.');
                header("Location: ".BASE_URL."contactsCMS?notification=".$msg."&status=alert-danger");
                exit;
            }
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }

    /**
     * This function edit the contact status by POST request.
     */
    public function editStatus(){
        $u = new Administrators();
        if($u->isLogged() && $u->havePermission('contacts')){
            if(!empty($_POST)){
                $s = new Store();
                $c = new Contacts();
                // Array for check the keys
                $keys = array('id', 'status');
                if($s->array_keys_check($keys, $_POST)){
                    // Check if the array is completed
                    if($s->array_check_completed_keys($keys, $_POST)){
                        $id = addslashes($_POST['id']);
                        $status = addslashes($_POST['status']);
                        // Check if status its a true value
                        if($status == "1" || $status == "2"){
                            if($c->setStatus($id, $status)){
                                // Returns true
                                echo json_encode(true);
                            }else{
                                echo json_encode("Status não encontrado.");
                            }
                        }else{
                            echo json_encode("Status inválido.");
                        }
                    }else{
                        echo json_encode("Dados incompletos.");
                    }
                }else{
                    echo json_encode("Dados corrompidos.");
                }
            }
        }
    }

    /**
     * This function sends a email to contact
     */
    public function sendAnswer(){
        $u = new Administrators();
        if($u->isLogged() && $u->havePermission('contacts')){
            if(!empty($_POST)){
                $s = new Store();
                $c = new Contacts();
                // Array for check the keys
                $keys = array('id', 'subject', 'message');
                if($s->array_keys_check($keys, $_POST)){
                    // Check if the array is completed
                    if($s->array_check_completed_keys($keys, $_POST)){
                        $id = addslashes($_POST['id']);
                        $subject = addslashes($_POST['subject']);
                        $message = addslashes($_POST['message']);
                        // get contact data
                        $contactData = $c->getDataById($id);
                        if(!empty($contactData)){
                            // Change status if its equals 1
                            if($contactData['status'] == "1"){
                                $c->setStatus($id, "2");
                            }
                            // Sends the message
                            $template = file_get_contents(BASE_URL."assets/templates/mail_template.htm");
                            $msg = str_replace("#EMAIL_TEXT#", $message, $template);
                            $recipient = array("name" => $contactData['name'], "email" => $contactData['email']);
                            if($s->sendMail(array($recipient), $subject, $msg)){
                                echo json_encode(true);
                            }else{
                                echo json_encode("Erro no envio do e-mail.");
                            }
                        }else{
                            echo json_encode("Erro: Contato não encontrado.");
                        }
                    }else{
                        echo json_encode("Dados incompletos.");
                    }
                }else{
                    echo json_encode("Dados corrompidos.");
                }
            }
        }
    }

    /**
     * This function receive a contact id on Base64 (2x),
     * execute delete function and headers to index page (contactsCMS/index)
     */
    public function delete($id){
        $u = new Administrators();
        $c = new Contacts();

        if($u->isLogged() && $u->havePermission('contacts')){
            $id = addslashes(base64_decode(base64_decode($id)));
            // try to delete
            if($c->delete($id)){
                $msg = urlencode('Contato excluído com sucesso!');
                header("Location: ".BASE_URL."contactsCMS?notification=".$msg."&status=alert-info");
                exit;
            }else{
                $msg = urlencode('Falha ao excluir, contato não encontrado.');
                header("Location: ".BASE_URL."contactsCMS?notification=".$msg."&status=alert-danger");
                exit;
            }
        }else{
            header("Location: ".BASE_URL);
            exit;
        }
    }
}