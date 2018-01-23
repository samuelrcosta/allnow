<?php
/**
 * This class controls auxiliary methods of the system.
 *
 * @author  samuelrcosta
 * @version 1.0.1, 01/16/2017
 * @since   1.0, 01/11/2017
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Store extends Model{

    /**
     * This function sends a email to recipient.
     *
     * @param   $recipients         array for the recipients email and name.
     * @param   $subject            string for the email subject.
     * @param   $message            string for the email message.
     *
     * @return  boolean true if its works, false if not.
     */
    public function sendMail($recipients, $subject, $message){
        if(!empty($recipients)){
            $mail = new PHPMailer(true);                      // Passing `true` enables exceptions

            try{
                //Server settings
                $mail->SMTPDebug = 0;                                   // Enable verbose debug output
                $mail->isSMTP();                                        // Set mailer to use SMTP
                $mail->Host = $this->MailHost;                          // Specify main and backup SMTP servers
                $mail->CharSet = "UTF-8";
                $mail->SMTPAuth = true;                                 // Enable SMTP authentication
                $mail->Username = $this->MailUsername;                  // SMTP username
                $mail->Password = $this->MailPassword;                  // SMTP password
                $mail->SMTPSecure = $this->MailSecurity;                // Enable TLS encryption, `ssl` also accepted
                $mail->Port = $this->MailPort;                          // TCP port to connect to

                //Recipients
                $mail->setFrom($this->MailUsername, $this->MailName);
                foreach($recipients as $recipient){
                    $mail->addAddress($recipient['email'], $recipient['name']);       // Add a recipient
                }
                //$mail->addAddress('ellen@example.com');               // Name is optional
                //$mail->addReplyTo('info@example.com', 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');

                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                //Content
                $mail->isHTML(true);                                    // Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $message;
                $mail->AltBody = $message;
                $mail->send();

                return true;
            }catch(Exception $e) {
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * This function create a URL slug from a string.
     *
     * @param   $str         string for create Slug.
     *
     * @return  string with que created slug.
     */
    public function createSlug($str) {
        $str = strtolower(trim($str));
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);
        return rtrim($str, '-');
    }

    /**
     * This function create a embed URL for youtube watch link.
     *
     * @param   $url    string for youtube URL watch.
     *
     * @return  string with embed link.
     */
    function getYoutubeEmbedUrl($url){
        if (strpos($url, 'youtu') !== false) {
            preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
            $id = $matches[1];

            return 'https://www.youtube.com/embed/' . $id ;
        }else{
            return '';
        }
    }

    /**
     * This function verify if a URL exists.
     *
     * @param $url  string for the url.
     *
     * @return boolean
     */
    function url_exists($url) {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($code == 200);
    }

}