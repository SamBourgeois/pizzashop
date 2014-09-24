<?php
require_once '../src/data/productendao.php';
$productenDAO = new ProductenDAO();
class ProductenService{
    
    /* de categorieen ophalen uit database */
    public function getCategorieen(){
        global $productenDAO;
        return $productenDAO->getCategorieen();
    }
    
    /* Producten per categorie ophalen */
    public function getProductenPerCat($categorie){
        global $productenDAO;
        return $productenDAO->getProductenPerCat($categorie);
    }    
    
    /* Extras ophalen */
    public function getExtras(){
        global $productenDAO;
        return $productenDAO->getExtras();
    }
    
    /* Productdata ophalen */
    public function getProduct($id){
        /*
         * return een product
         * @id integer, verplicht, de id van het product
         * return object
         */
        global $productenDAO;
        return $productenDAO->getProduct($id);
    }
    
    /* Product verwijderen */
    public function deleteProduct($id){
        global $productenDAO;
        return $productenDAO->delete($id);
    }
    
    /* Product toevoegen */
    public function setProduct($artikel){
        global $productenDAO;
        return $productenDAO->create($artikel);
    }
    
    /* Product aanpassen */
    public function updateProduct($artikel){
        global $productenDAO;
        return $productenDAO->update($artikel);
    }
}
?>
