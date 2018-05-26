<?php
/**
 * This class controls auxiliary methods of the system.
 *
 * @author  samuelrcosta
 * @version 1.3.0, 05/25/2018
 * @since   1.0, 01/11/2017
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Store extends Model{

    // Models instances
    private $c;

    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct();
        // Initialize instances
        $this->c = new Configs();
    }

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
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
        $str = str_replace($a, $b, $str);
        $str = strtolower($str);
        $str = str_replace(" ", "-", $str);
        $str = preg_replace("/[^a-zA-Z0-9-]/", "",$str);
        return $str;
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
            if(count($matches) > 1){
                $id = $matches[1];
                return 'https://www.youtube.com/embed/' . $id ;
            }else{
                return '';
            }  
        }else{
            return '';
        }
    }

    /**
     * This function returns the Youtube video id from a URL.
     *
     * @param   $url    string for youtube URL watch.
     *
     * @return  string with video id.
     */
    function getYoutubeId($url){
        if (strpos($url, 'youtu') !== false) {
            preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
            if(count($matches) > 1){
                $id = $matches[1];
                return $id ;
            }else{
                return '';
            }
        }else{
            return '';
        }
    }

    /**
     * This function execute a cUrl to get Data.
     *
     * @param $url  string for the url.
     *
     * @return mixed
     */
    public function curl_get($url){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $return = curl_exec($curl);
        curl_close($curl);
        return $return;
    }


    /**
     * This function verify if a URL exists.
     *
     * @param $url  string for the url.
     *
     * @return boolean
     */
    public function url_exists($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($code == 200);
    }

    /**
     * This function verify if all keys in $keys exists in $array keys.
     *
     * @param   $keys array for the keys
     * @param   $array array for the check
     *
     * @return boolean
     */
    public function array_keys_check($keys, $array){
        if (count(array_intersect($keys,array_keys($array))) == count($keys)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * This function verify if all keys in $keys is completed in $array.
     *
     * @param   $keys array for the keys
     * @param   $array array for the check
     *
     * @return boolean
     */
    public function array_check_completed_keys($keys, $array){
        for($i = 0; $i < count($keys); $i++){
            if(strlen($array[$keys[$i]]) <= 0){
                return false;
            }
        }
        return true;
    }

    /**
     * This function register user in MailChimplist.
     *
     * @param $email  string for the user email.
     * @param $name  string for the user name.
     *
     * @return mixed var
     */
    public function subscribeMailChimp($email, $name = ''){
        $memberID = md5(strtolower($email));
        $dataCenter = substr($this->MAILCHIMP_API_KEY,strpos($this->MAILCHIMP_API_KEY,'-')+1);
        $url = 'https://'.$dataCenter.'.api.mailchimp.com/3.0/lists/'.$this->MAILCHIMP_LIST_ID.'/members/'.$memberID;

        //Member Info
        $json = json_encode([
            'email_address' => $email,
            'status'        => 'subscribed',
            'merge_fields' => [
                'NAME' => $name,
            ]
        ]);

        // send a HTTP POST request with curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $this->MAILCHIMP_API_KEY);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $result;
    }

    /**
     * This function normalize badges name on advertisement list.
     *
     * @param   $adsData    array with advertisements
     *
     * @return array with badges name
     */
    public function normalizeBadgesName($adsData){
        for($i = 0; $i < count($adsData); $i++){
            $badges = array();
            if($adsData[$i]['new'] == "1"){
                $badges[] = array('class' =>'new', 'name' => "Novo");
            }
            if($adsData[$i]['bestseller'] == "1"){
                $badges[] = array('class' =>'bestseller', 'name' => "Mais&nbsp;vendidos");
            }
            if($adsData[$i]['sale'] == "1"){
                $badges[] = array('class' =>'sale', 'name' => "Promoção");
            }
            $adsData[$i]['badges'] = $badges;
        }
        return $adsData;
    }

    /**
     * This function return a description and url image for share.
     *
     * @param   $type      string for the type of data, allows "ad", "category" and "area"
     * @param   $data    array with data
     *
     * @return array with description and image
     */
    public function getShareData($type, $data){
        $array = array("description" => "", "image" => "");

        // Check the type
        if($type == "ad"){
            // Remove break lines
            $description = str_replace("\n", ' ', $data['abstract']);
            $description = str_replace("\r", ' ', $description);
            $description = str_replace("  ", ' ', $description);
            $array['description'] = $description;

            foreach ($data['medias'] as $ad){
                if($ad['media_type'] == 1){
                    $array['image'] = "https://img.youtube.com/vi/".$ad['media']."/hqdefault.jpg";
                    break;
                }else if($ad['media_type'] == 2){
                    $data = json_decode(self::curl_get("https://vimeo.com/api/v2/video/".$ad['media'].".json"), true);
                    $array['image'] = $data[0]['thumbnail_large'];
                    break;
                }
            }
        }else if($type == "category" || $type == "area"){
            // Get description
            if(empty($data['description'])){
                $array['description'] = $data['name'];
            }else{
                // Remove break lines
                $description = str_replace("\n", ' ', $data['description']);
                $description = str_replace("\r", ' ', $description);
                $description = str_replace("  ", ' ', $description);
                $array['description'] = $description;
            }
            // Get image
            if(empty($data['share_image'])){
                $pattern_image = $this->c->getConfig('pattern_category_image');
                $array['image'] = BASE_URL."assets/images/categories/".$pattern_image;
            }else{
                $array['image'] = BASE_URL."assets/images/categories/".$data['share_image'];
            }
        }

        return $array;
    }
}