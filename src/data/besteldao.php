<?php
require_once("../src/data/abstractdao.php");
require_once '../src/entities/bestelling.php';
require_once '../src/entities/gebruiker.php';
class BestelDAO extends AbstractDAO{
    
    /* bestelling wegschrijven naar database */
    public function plaatsBestelling(Gebruiker $gebruiker, Winkelmandje $winkelmandje){
        $db = $this->getDb();
        $query = $db->prepare("insert into bestellingen (prijs, gebruikersnummer,bestellingstype, status) values (?, ?, ?, ?)"); 
        $query->bindValue(1, $winkelmandje->getTotaalPrijs());
        $query->bindValue(2, $gebruiker->getId());
        $query->bindValue(3, $gebruiker->getLeverwijzeNummer());
        $query->bindValue(4, "0");
        try{
            $query->execute();
            $bestellingsid = $db->lastInsertId();
            foreach($winkelmandje->getItems() as $artikel){
                $this->plaatsBestelLijnen($bestellingsid, $artikel);
                                
            }            
        }catch(PDOException $e){
            die($e->getMessage());
        }
    } 
    
    /* producten per bestelling wegschrijven */
    public function plaatsBestelLijnen($bestellingsid, Artikel $artikel){ 
        $db = $this->getDb();
        $query = 
        $query = $db->prepare("insert into bestellijnen (bestellingsid, artikelnummer, aantal, prijs) values (?, ?, ?, ?)"); 
        $query->bindValue(1, $bestellingsid);
        $query->bindValue(2, $artikel->getId());
        $query->bindValue(3, $artikel->getAantal());
        $query->bindValue(4, $artikel->getTotaalPrijs());
        
        try{
            $query->execute();
            $bestellijnid = $db->lastInsertId();
            if(!(empty($artikel->getExtrasids()))){
                foreach($artikel->getExtras() as $extra){
                    $this->plaatsExtraBestelLijnen($bestellijnid, $extra);
                }
            }
        }catch(PDOException $e){
            die($e->getMessage());
        }   
    }
        
    /* extras per product wegschrijven */
    public function plaatsExtraBestelLijnen($bestellijnid, Artikel $extra){
        $db = $this->getDb();
        $query = $db->prepare("insert into extrabestellijnen (bestellijnid, extraid) values (?, ?)"); 
        $query->bindValue(1, $bestellijnid);
        $query->bindValue(2, $extra->getId());
        try{
            $query->execute();                       
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* bestellingen ophalen */
    public function getLijst($open){
        $lijst = array();
        $db = $this->getDb();
        if ($open == 1){
            $query = $db->prepare("select a.bestellingsid, b.gebruikersnaam, a.datum, a.prijs, a.bestellingstype, a.status from bestellingen as a, gebruikers as b  where a.gebruikersnummer = b.gebruikersnummer and a.status <> 3 order by datum DESC");
        }else{
            $query = $db->prepare("select a.bestellingsid, b.gebruikersnaam, a.datum, a.prijs, a.bestellingstype, a.status from bestellingen as a, gebruikers as b  where a.gebruikersnummer = b.gebruikersnummer order by datum DESC");
        }      
        
        try{
            $query->execute();
            $rows = $query->fetchAll();
            foreach($rows as $rij){
                $bestelling = new Bestelling($rij["bestellingsid"], $rij["gebruikersnaam"], $rij["datum"], $rij["bestellingstype"], $rij["prijs"], $rij["status"]);  
                array_push($lijst, $bestelling);
            }
            return $lijst;        
        }catch(PDOException $e){
            die($e->getMessage());
        }
        
    }
    
    /* bestellingen per klant ophalen */
    public function getFilterLijst($id, $open){
        $lijst = array();
        $db = $this->getDb();
        if ($open == 1){
            $query = $db->prepare("select a.bestellingsid, b.gebruikersnaam, a.datum, a.prijs, a.bestellingstype, a.status from bestellingen as a, gebruikers as b  where a.gebruikersnummer = b.gebruikersnummer and a.gebruikersnummer = ?  and a.status <> 3 order by datum DESC");
            $query->bindValue(1, $id);
        }else{
            $query = $db->prepare("select a.bestellingsid, b.gebruikersnaam, a.datum, a.prijs, a.bestellingstype, a.status from bestellingen as a, gebruikers as b  where a.gebruikersnummer = b.gebruikersnummer and a.gebruikersnummer = ? order by datum DESC");
            $query->bindValue(1, $id);
        }
        
        try{
            $query->execute();
            $rows = $query->fetchAll();
            foreach($rows as $rij){
                $bestelling = new Bestelling($rij["bestellingsid"], $rij["gebruikersnaam"], $rij["datum"], $rij["bestellingstype"], $rij["prijs"], $rij["status"]);  
                array_push($lijst, $bestelling);
            }
            return $lijst;        
        }catch(PDOException $e){
            die($e->getMessage());
        }
        
    }
    
    /* Status van een bestelling veranderen */
    public function updateStatus($bestelling){
        $db = $this->getDb();
        $query = $db->prepare("UPDATE `bestellingen` SET
                                    `status`      = ?                                    
                                    WHERE `bestellingsid`= ?
                                    ");
        $query->bindValue(1, $bestelling->getStatus());
        $query->bindValue(2, $bestelling->getId());
        
        try{
            $query->execute();
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* Producten per bestelling ophalen */
    public function getBestelLijnen($id){
        $db = $this->getDb();
        $query = $db->prepare("select bestellijnid, artikelnummer, aantal, prijs from bestellijnen as a where bestellingsid = ?");
        $query->bindValue(1, $id);
        
        try{
            $query->execute();
            $rows = $query->fetchAll();
            return $rows;     
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* extras per product ophalen */
    public function getExtras($id){
        $db = $this->getDb();
        $query = $db->prepare("select extraid from extrabestellijnen where bestellijnid = ?");
        $query->bindValue(1, $id);
        
        try{
            $query->execute();
            $rows = $query->fetchAll();
            return $rows;        
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* de gebruiker ophalen die de bestelling geplaatst heeft */
    public function getGebruiker($id){
        $db = $this->getDb();
        $query = $db->prepare("select * from gebruikers as a, bestellingen as b where b.bestellingsid = ? and b.gebruikersnummer = a.gebruikersnummer");
        $query->bindValue(1, $id);
        
        try{
            $query->execute();
            $rij = $query->fetch();
            $gebruiker = new Gebruiker();                   
            $gebruiker->setVoornaam($rij['voornaam']);
            $gebruiker->setAchternaam($rij['achternaam']);
            $gebruiker->setAdres($rij['adres']);
            $gebruiker->setPostcode($rij['postcode']);
            $gebruiker->setGemeente($rij['gemeente']);
            return $gebruiker;
        } catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    
    /* De gebruikersnamen ophalen van de klanten die bestellingen geplaatst hebben */
    public function getGebruikersnamen(){
        $lijst = array();
        $db = $this->getDb();
        $query = $db->prepare("select gebruikersnummer, gebruikersnaam from gebruikers where gebruikersnummer in (select gebruikersnummer from bestellingen)");
        
        try{
            $query->execute();
            $rows = $query->fetchAll();
            foreach($rows as $rij){
                $gebruiker = new Gebruiker();  
                $gebruiker->setId($rij['gebruikersnummer']);
                $gebruiker->setGebruikersnaam($rij['gebruikersnaam']);
                array_push($lijst, $gebruiker);
            }
            return $lijst;        
        }catch(PDOException $e){
            die($e->getMessage());
        }
        
    }
}
?>
