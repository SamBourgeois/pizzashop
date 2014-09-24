<?php
require_once("../src/data/abstractdao.php");
require_once '../src/entities/bericht.php';
class BerichtenDAO extends AbstractDAO{
    
    /* bericht wegschrijven naar database */
    public function create($bericht) { 
        $db = $this->getDb();
        $query = $db->prepare("insert into gastenboek (gebruikersnaam,titel, boodschap) values (?, ?, ?)"); 
        $query->bindValue(1, $bericht->getGebruiker());
        $query->bindValue(2, $bericht->getTitel());
        $query->bindValue(3, $bericht->getBoodschap());
        try{
            $query->execute();
        }catch(PDOException $e){
            die($e->getMessage());
        }        
    }   
    
    /* bericht verwijderen uit database */
    public function delete($id) { 
        $db = $this->getDb();
        $query = $db->prepare("delete from gastenboek where `id` = ?"); 
        $query->bindValue(1, $id);
        try{
            $query->execute();
        }catch(PDOException $e){
            die($e->getMessage());
        }
        
    } 
    
    /* Berichten uit database halen */
    public function getLijst(){
        $lijst = array();
        $db = $this->getDb();
        $query = $db->prepare("select id, gebruikersnaam, titel, boodschap from (select id, gebruikersnaam, titel, boodschap from gastenboek as b order by id DESC LIMIT 20) as a order by id DESC");
        
        try{
            $query->execute();
            $rows = $query->fetchAll();
            foreach($rows as $rij){
                $bericht = new Bericht($rij["gebruikersnaam"], $rij["titel"], $rij["boodschap"]);  
                $bericht->setId($rij['id']);
                array_push($lijst, $bericht);
            }
            return $lijst;        
        }catch(PDOException $e){
            die($e->getMessage());
        }
        
    }
}
?>
