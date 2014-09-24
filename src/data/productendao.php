<?php
require_once("../src/data/abstractdao.php");
require_once '../src/entities/artikel.php';
require_once '../src/entities/categorie.php';
class ProductenDAO extends AbstractDAO{
    
    /* de categorieen ophalen uit database */
    public function getCategorieen(){
        //return array
        $lijst = array();
        $db = $this->getDb();
        $query = $db->prepare("select categorieid, omschrijving from categorieen where categorieid<>3 order by categorieid");
        
        try{
            $query->execute();
            $rows = $query->fetchAll();
            foreach($rows as $rij){
                $categorie = new Categorie($rij["categorieid"], $rij["omschrijving"]);                
                array_push($lijst, $categorie);
            }
            return $lijst;        
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* Producten per categorie ophalen */
    public function getProductenPerCat($categorie){
        $lijst = array();
        $db = $this->getDb();
        $query = $db->prepare("select artikelnummer, naam, omschrijving, image_locatie, prijs, korting from artikels where `categorieid`= ? order by naam");
        $query->bindValue(1, $categorie);
        
        try{
            $query->execute();
            $rows = $query->fetchAll();
            foreach($rows as $rij){
                $artikel = new Artikel($rij["artikelnummer"], $rij["naam"], $rij["omschrijving"], $rij["image_locatie"], $rij["prijs"], $rij["korting"], $categorie);                
                array_push($lijst, $artikel);
            }
            return $lijst;        
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* Extras ophalen */
    public function getExtras(){
        $lijst = array();
        $db = $this->getDb();
        $query = $db->prepare("select artikelnummer, naam, omschrijving, image_locatie, prijs, korting from artikels where `categorieid`= 3 order by naam");
        
        try{
            $query->execute();
            $rows = $query->fetchAll();
            foreach($rows as $rij){
                $artikel = new Artikel($rij["artikelnummer"], $rij["naam"], $rij["omschrijving"], $rij["image_locatie"], $rij["prijs"], $rij["korting"], "3");                
                array_push($lijst, $artikel);
            }
            return $lijst;        
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* Productdata ophalen */
    public function getProduct($id){
        $db = $this->getDb();
        $query = $db->prepare("SELECT * FROM `artikels` WHERE `artikelnummer`= ?");
        $query->bindValue(1, $id);
        
        try{
            $query->execute();
            $rij = $query->fetch();
            $artikel = new Artikel($rij["artikelnummer"], $rij["naam"], $rij["omschrijving"], $rij["image_locatie"], $rij["prijs"], $rij["korting"], $rij["categorieid"]);            
            return $artikel;
        } catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* Product verwijderen */
    public function delete($id) { 
        $db = $this->getDb();
        $query = $db->prepare("delete from artikels where artikelnummer = ?"); 
        $query->bindValue(1, $id);
        
        try{
            $query->execute();
        }catch(PDOException $e){
            die($e->getMessage());
        }
        
    }
    
    /* Product toevoegen */
    public function create($artikel) { 
        $db = $this->getDb();
        $query = $db->prepare("insert into artikels (naam , omschrijving, image_locatie, prijs, korting, categorieid) values (?, ?, ?, ?, ?, ?)"); 
        $query->bindValue(1, $artikel->getNaam());
        $query->bindValue(2, $artikel->getOmschrijving());
        $query->bindValue(3, $artikel->getImage_locatie());
        $query->bindValue(4, $artikel->getPrijs());
        $query->bindValue(5, $artikel->getKorting());
        $query->bindValue(6, $artikel->getCat());
        try{
            $query->execute();
        }catch(PDOException $e){
            die($e->getMessage());
        }
        
    } 
    
    /* Product aanpassen */
    public function update($artikel){
        $db = $this->getDb();
        $query = $db->prepare("UPDATE `artikels` SET
                                    `naam`          = ?,
                                    `omschrijving`  = ?,
                                    `image_locatie` = ?,
                                    `prijs`         = ?,
                                    `korting`       = ?,
                                    `categorieid`   = ?
                                    WHERE `artikelnummer`= ?
                                    ");
        $query->bindValue(1, $artikel->getNaam());
        $query->bindValue(2, $artikel->getOmschrijving());
        $query->bindValue(3, $artikel->getImage_locatie());
        $query->bindValue(4, $artikel->getPrijs());
        $query->bindValue(5, $artikel->getKorting());
        $query->bindValue(6, $artikel->getCat());
        $query->bindValue(7, $artikel->getId());
        
        try{
            $query->execute();
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
}
?>
