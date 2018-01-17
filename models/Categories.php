<?php
/**
 * This class retrieves and saves data of the categories.
 *
 * @author  samuelrcosta
 * @version 1.0.1, 01/16/2017
 * @since   1.0.0, 01/15/2017
 */

class Categories extends model {

    /**
     * This function takes all data from the categories database and rearranges each category with its subcategories.
     *
     * @return  array containing all returned and rearranges data.
     */
    public function getList(){
        $array = array();

        $sql = "SELECT * FROM categories ORDER BY id_principal DESC";
        $sql = $this->db->query($sql);

        if($sql->rowCount() > 0){
            foreach ($sql->fetchAll() as $item){
                $item['subs'] = array();
                $array[$item['id']] = $item;
            }

            while($this->stillNeed($array)){
                $this->organizeCategory($array);
            }
        }

        return $array;
    }

    /**
     * This function takes all data from a category in database and rearranges with its subcategories.
     *
     * @param   $id     int for the category id.
     *
     * @return  array containing all returned data.
     */
    public function getCategoryTree($id){
        $array = array();

        $haveChild = True;

        while($haveChild){
            $sql = 'SELECT * FROM categories WHERE id = :id';
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':id', $id);
            $sql->execute();
            if($sql->rowCount() > 0){
                $sql = $sql->fetch();
                $array[] = $sql;

                if(!empty($sql['id_principal'])){
                    $id = $sql['id_principal'];
                }else{
                    $haveChild = False;
                }
            }
        }

        $array = array_reverse($array);

        return $array;
    }

    /**
     * This function checks if there are still subcategories in the existing categories in the array.
     *
     * @param   $array  array with categories.
     *
     * @return  boolean true if needs or false if not.
     */
    private function stillNeed($array){
        foreach ($array as $item){
            if(!empty($item['id_principal'])){
                return True;
            }
        }
        return False;
    }

    /**
     * This function organizes an array of categories, creating subarrays with subcategories.
     *
     * @param   $array  array with categories.
     */
    private function organizeCategory(&$array){
        foreach ($array as $id => $item){
            if(isset($array[$item['id_principal']])){
                $array[$item['id_principal']]['subs'][$item['id']] = $item;
                unset($array[$id]);
                break;
            }
        }
    }

    /**
     * This function takes the category name from database.
     *
     * @param   $id     int for the category id.
     *
     * @return  string with the category name.
     */
    public function getNameById($id){
        $sql = "SELECT name FROM categories WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch()['name'];
        }else{
            $data = '';
        }

        return $data;
    }

    /**
     * This function register a new category in database.
     * If this category already registered returns False, else returns True.
     *
     * @param   $name           string for the category name.
     * @param   $id_principal   int for the principal category if exists.
     *
     * @return  boolean     boolean false for email already registered, or instead True.
     */
    public function register($name, $id_principal = 0){
        $s = new Store();
        $slug = $s->createSlug($name);
        $sql = "SELECT * FROM categories WHERE slug = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($slug));
        $sql = $sql->fetchAll();
        if($sql && count($sql)){
            return false;
        }else{
            if($id_principal == 0){
                $id_principal = Null;
            }
            $sql = "INSERT INTO categories (name, id_principal, slug) VALUES (?, ?, ?)";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($name, $id_principal, $slug));
            return true;
        }
    }

    /**
     * This function edit a category in database.
     * If this category already registered returns False, else returns True.
     *
     * @param   $name           string for the category name.
     * @param   $id_principal   int for the principal category if exists.
     *
     * @return  boolean     boolean false for email already registered, or instead True.
     */
    public function edit($id, $name, $id_pricipal = Null){
        $s = new Store();
        $slug = $s->createSlug($name);
        $sql = "SELECT * FROM categories WHERE slug = ? AND id != ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($slug, $id));
        $sql = $sql->fetchAll();
        if($sql && count($sql)){
            return false;
        }else{
            $sql = "UPDATE categories SET name = ?, id_principal = ?, slug = ? WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($name, $id_pricipal, $slug, $id));
            return true;
        }
    }

    /**
     * This function delete a category and all its subcategories.
     *
     * @param   $id     int for the category id.
     */
    public function delete($id){
        $sql = "DELETE FROM categories WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id));

        //Delete subs
        $sql = "DELETE FROM categories WHERE id_principal = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id));
    }

}
?>