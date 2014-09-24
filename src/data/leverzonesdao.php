<?php
require_once("../src/data/abstractdao.php");
require_once '../src/entities/leverzone.php';
class LeverzonesDAO extends AbstractDAO{
    
    /* lijst met leverzones ophalen */
    public function getLeverzones(){
        $lijst = array();
        $db = $this->getDb();
        $query = $db->prepare("select postcode, gemeente, prijs from leverzones order by prijs, gemeente asc");
        
        try{
            $query->execute();
            $rows = $query->fetchAll();
            foreach($rows as $rij){
                $zone = new Leverzone($rij["postcode"], $rij['gemeente'], $rij["prijs"]);                
                array_push($lijst, $zone);
            }
            return $lijst;        
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* lijst met postcodes ophalen */
    public function getLeverPostcodes(){
        $lijst = array();
        $db = $this->getDb();
        $query = $db->prepare("select postcode from leverzones");
        
        try{
            $query->execute();
            $rows = $query->fetchAll();
            foreach($rows as $rij){                                
                array_push($lijst, $rij["postcode"]);
            }
            return $lijst;        
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* Leverzone ophalen */
    public function getLeverzone($gebruiker){
        $db = $this->getDb();
        $query = $db->prepare("SELECT * FROM `leverzones` WHERE `postcode`= ?");
        $query->bindValue(1, $gebruiker->getPostcode());
        
        try{
            $query->execute();
            $rij = $query->fetch();
            $leverzone = new Leverzone($rij['postcode'], $rij['gemeente'], $rij['prijs']);
            return $leverzone;
        } catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* leverzone verwijderen */
    public function delete($leverzone) { 
        $db = $this->getDb();
        $query = $db->prepare("delete from leverzones where postcode = ?"); 
        $query->bindValue(1, $leverzone->getPostcode());
        
        try{
            $query->execute();
        }catch(PDOException $e){
            die($e->getMessage());
        }
        
    }
    
    /* leverzone toevoegen */
    public function create($leverzone) { 
        $db = $this->getDb();
        $query = $db->prepare("insert into leverzones (postcode , gemeente, prijs) values (?, ?, ?)"); 
        $query->bindValue(1, $leverzone->getPostcode());
        $query->bindValue(2, $leverzone->getGemeente());
        $query->bindValue(3, $leverzone->getPrijs());
        try{
            $query->execute();
        }catch(PDOException $e){
            die($e->getMessage());
        }
        
    } 
    
    /* controle of postcode in database zit */
    public function postcode_exists($leverzone){
        $db = $this->getDb();
        $query = $db->prepare("SELECT COUNT(`postcode`) FROM `leverzones` WHERE `postcode`= ?");
        $query->bindValue(1, $leverzone->getPostcode());
        
        try{
            $query->execute();
            $rows = $query->fetchColumn();
            
            if($rows == 1){
                return true;
            }else{
                return false;
            }
        }catch (PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* Leverzone aanpassen */
    public function update($leverzone){
        $db = $this->getDb();
        $query = $db->prepare("UPDATE `leverzones` SET
                                    `postcode`          = ?,
                                    `gemeente`  = ?,
                                    `prijs` = ?                                    
                                    WHERE `postcode`= ?
                                    ");
        $query->bindValue(1, $leverzone->getPostcode());
        $query->bindValue(2, $leverzone->getGemeente());
        $query->bindValue(3, $leverzone->getPrijs());
        $query->bindValue(4, $leverzone->getPostcode());
        
        try{
            $query->execute();
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
}
?>
