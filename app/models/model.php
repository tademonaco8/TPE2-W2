<?php
class LightersModel{
    private $db;

    public function __construct(){
        $this->db= new PDO('mysql:host=localhost;'.'dbname=encendedores;charset=utf8', 'root', '');
    }
    public function getList(){
        $query = $this->db->prepare("SELECT * FROM encendedor");
        $query->execute();
        $list = $query->fetchAll(PDO::FETCH_OBJ);
        return $list;
    }

    public function orderLighters($order, $sortby){
        $query = $this->db->prepare("SELECT * FROM encendedor ORDER BY `$sortby` $order");
        $query->execute();
        $list = $query->fetchAll(PDO::FETCH_OBJ);
        return $list;
    }

    public function insertLighter($producto,$tipo_fk,$descripcion,$precio, $img_url) {
        $query = $this->db->prepare("INSERT INTO encendedor (producto, tipo_fk ,precio, descripcion, img_url) VALUES (?,?,?,?,?)");
        $query->execute([$producto,$tipo_fk,$precio,$descripcion, $img_url]);
    }
    public function getLighterByID($id){
        $query = $this->db->prepare("SELECT * FROM encendedor WHERE id =?");
        $query->execute([$id]);  
        $lighter = $query->fetch(PDO::FETCH_OBJ);
        return $lighter;
    }
    public function getLightersByCategory($category){
        $query = $this->db->prepare("SELECT * FROM encendedor WHERE tipo_FK = (SELECT id_tipo from tipo WHERE descripcion_tipo = ?)");
        $query->execute([$category]);  
        $lighters = $query->fetchAll(PDO::FETCH_OBJ);
        // var_dump($lighters);
        return $lighters;
    }
    public function updateLighter($producto,$tipo_fk,$precio,$descripcion,$img_url, $id){
        $query = $this->db->prepare("UPDATE encendedor SET producto=?, tipo_fk =?, descripcion =?, precio =?, img_url =? WHERE id= ?");
        $query->execute([$producto,$tipo_fk, $descripcion, $precio, $img_url, $id]);
    }
    public function deleteLighterById($id) {
        $query = $this->db->prepare('DELETE FROM encendedor WHERE id = ?');
        $query->execute([$id]);
    }
    public function getLastInsertedId(){
        $query = $this->db->prepare('SELECT MAX(id) FROM encendedor');
        $query->execute();
        $id = $query->fetch(PDO::FETCH_OBJ);
        return $id;
    }

}
?>