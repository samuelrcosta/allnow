<?php
/**
 * This class retrieves and saves data of the configs table.
 *
 * @author  samuelrcosta
 * @version 1.1.1, 09/08/2018
 * @since   1.0, 01/18/2017
 */


class Configs extends Model{

    /**
     * This function register a new fail attempt to login in Admin page.
     *
     * @return  int for the number of attempts.
     */
    public function registerLoginAttempt(){
        $name = 'admin_login_attempts';

        $sql = 'SELECT * FROM configs WHERE name = ?';
        $sql = $this->db->prepare($sql);
        $sql->execute(array($name));

        $attempts = $sql->fetch()['value'];
        $attempts = $attempts + 1;

        $sql = 'UPDATE configs SET value = ? WHERE name = ?';
        $sql = $this->db->prepare($sql);
        $sql->execute(array($attempts, $name));

        return $attempts;
    }

    /**
     * This function update a config data.
     *
     * @param   $name   String for the config name
     * @param   $value  String fot the config value
     */
    public function updateConfig($name, $value){
        $sql = 'UPDATE configs SET value = :value WHERE name = :name';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':name', $name);
        $sql->bindValue(':value', $value);
        $sql->execute();
    }

    /**
     * This function retrieves a config data.
     *
     * @param   $name   String for the config name
     *
     * @return array with all data
     */
    public function getConfig($name){
        $return = array();
        $sql = 'SELECT * FROM configs WHERE name = :name';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':name', $name);
        $sql->execute();
        if($sql->rowCount() > 0){
            $return = $sql->fetch()['value'];
        }
        return $return;
    }

    /**
     * This function retrieves a configs data.
     *
     * @param   $configs   array for the configs names
     *
     * @return array with all data
     */
    public function getConfigs(array $configs){
        $return = array();
        if(empty($configs)){
            return $return;
        }
        $sql = "SELECT * FROM configs WHERE name IN("."'".implode("','", $configs)."'".")";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        if($sql->rowCount() > 0){
            foreach($sql->fetchAll() as $c){
                $return[$c['name']] = $c['value'];
            }
        }
        return $return;

    }

    /**
     * This function update the homepage banner image.
     *
     * @param   $data   array for the upload image data
     *
     * @return mixed boolean true if saves correctly and String for error with this description
     */
    public function updateBannerImage($data){
        $exts_checks = array('jpg', 'png', 'jpeg');
        $ext = explode(".", $data['image']['name']);
        $ext = strtolower(end($ext));
        if(array_search($ext, $exts_checks) === false) {
            return "Extensão da imagem não permitida";
        }else{
            $new_name = "banner".md5(time()).".".$ext;
            $dir = $_SERVER['DOCUMENT_ROOT'] . SERVER_URL . "assets/images/banner/";
            if(move_uploaded_file($data['image']['tmp_name'], $dir.$new_name)){
                $oldBanner = self::getConfig('banner_image');
                // Remove old banner
                unlink($_SERVER['DOCUMENT_ROOT'] . SERVER_URL . "assets/images/banner/".$oldBanner);
                self::updateConfig('banner_image', $new_name);
                return true;
            }else{
                return "Problema ao salvar a imagem";
            }
        }
    }
}