<?php
require_once("../src/data/abstractdao.php");
class GebruikerDAO extends AbstractDAO{  
    
    /* Controleren of de gebruikersnaam in de database zit */
    public function gebruikersnaam_exists($gebruiker){
        $db = $this->getDb();
        if($gebruiker->getId()!=""){
            $query = $db->prepare("SELECT COUNT(`gebruikersnummer`) FROM `gebruikers` WHERE `gebruikersnaam`= ? and gebruikersnummer <> ?");
            $query->bindValue(1, $gebruiker->getGebruikersnaam());
            $query->bindValue(2, $gebruiker->getId());
        }else{
            $query = $db->prepare("SELECT COUNT(`gebruikersnummer`) FROM `gebruikers` WHERE `gebruikersnaam`= ?");
            $query->bindValue(1, $gebruiker->getGebruikersnaam());
        }        
        
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
    
    /* controleren of het emailadres al in de database zit */
    public function email_exists($gebruiker){
        $db = $this->getDb();
        $query = $db->prepare("SELECT COUNT(`gebruikersnummer`) FROM `gebruikers` WHERE `emailadres`= ?");
        $query->bindValue(1, $gebruiker->getEmailadres());
        
        try{
            $query->execute();
            $rows = $query->fetchColumn();
            
            if($rows == 1){
                return true;
            }else{
                return false;
            }
        } catch (PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* De gebruiker toevoegen aan de database */
    public function register($gebruiker){        
        global $bcrypt;
        $gebruiker->setWachtwoord($bcrypt->genHash($gebruiker->getWachtwoord()));
        
        $db = $this->getDb();
        $query = $db->prepare("INSERT INTO `gebruikers` (`gebruikersnaam`, `wachtwoord`, `emailadres`, `voornaam`, `achternaam`, `adres`, `gemeente`, `postcode`, `telefoonnummer`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ");
        
        $query->bindValue(1, $gebruiker->getGebruikersnaam());
        $query->bindValue(2, $gebruiker->getWachtwoord());
        $query->bindValue(3, $gebruiker->getEmailadres());
        $query->bindValue(4, $gebruiker->getVoornaam());
        $query->bindValue(5, $gebruiker->getAchternaam());
        $query->bindValue(6, $gebruiker->getAdres());
        $query->bindValue(7, $gebruiker->getGemeente());
        $query->bindValue(8, $gebruiker->getPostcode());
        $query->bindValue(9, $gebruiker->getTelefoonnummer());
        
        try{
            $query->execute();  
            return $gebruiker;            
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }   
    
    
    /* Controleren of de gebruiker en wachtwoord kloppen */
    public function login($gebruiker){
        global $bcrypt;
        $db = $this->getDb();
        $query = $db->prepare("SELECT `wachtwoord`, `gebruikersnummer` FROM `gebruikers` WHERE `emailadres` = ?");
        $query->bindValue(1, $gebruiker->getEmailadres());
        
        try{
            $query->execute();
            $data               = $query->fetch();
            $stored_password    = $data['wachtwoord'];
            $gebruiker->setId($data['gebruikersnummer']);
            
            if($bcrypt->verify($gebruiker->getWachtwoord(), $stored_password) === true){
                $gebruiker = $this->gebruikerdata($gebruiker);
                return $gebruiker;
            }else{
                return false;
            }
        }catch(PDOException $e){
            die($e->getMessage());
        }
    } 
    
    /* Controleren of de gebruiker een admin is */
    public function is_admin($id){
        $db = $this->getDb();
        $query = $db->prepare("SELECT `status` FROM `gebruikers` WHERE `gebruikersnummer` = ?");
        $query->bindValue(1, $id);
        
        try{
            $query->execute();
            $data       = $query->fetch();
            $status     = $data['status'];            
            
            if($status == "2"){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* De gebruiker data ophalen uit database */
    public function gebruikerdata($gebruiker){
        $db = $this->getDb();
        $query = $db->prepare("SELECT * FROM `gebruikers` WHERE `gebruikersnummer`= ?");
        $query->bindValue(1, $gebruiker->getId());
        
        try{
            $query->execute();
            $data = $query->fetch();
            $gebruiker = new Gebruiker();
            $gebruiker->setId($data['gebruikersnummer']);
            $gebruiker->setGebruikersnaam($data['gebruikersnaam']);
            $gebruiker->setEmailadres($data['emailadres']);
            $gebruiker->setWachtwoord($data['wachtwoord']);
            $gebruiker->setRecovery_string($data['recovery_string']);
            $gebruiker->setDatum($data['datum']);
            $gebruiker->setVoornaam($data['voornaam']);
            $gebruiker->setAchternaam($data['achternaam']);
            $gebruiker->setAdres($data['adres']);
            $gebruiker->setGemeente($data['gemeente']);
            $gebruiker->setPostcode($data['postcode']);
            $gebruiker->setTelefoonnummer($data['telefoonnummer']);
            $gebruiker->setStatus($data['status']);
            $gebruiker->setLeverwijze($data['leverwijze']);
            
            return $gebruiker;
        } catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* De gebruikers ophalen uit database */
    public function get_gebruikers(){
        $lijst = array();
        $db = $this->getDb();
        $query = $db->prepare("SELECT * FROM `gebruikers` ORDER BY `datum` DESC");
        
        try{
            $query->execute();
            $rows = $query->fetchAll();
            foreach($rows as $rij){
                $gebruiker = new Gebruiker();
                $gebruiker->setId($rij['gebruikersnummer']);
                $gebruiker->setGebruikersnaam($rij['gebruikersnaam']);
                $gebruiker->setEmailadres($rij['emailadres']);
                $gebruiker->setDatum($rij['datum']);
                $gebruiker->setStatus($rij['status']);
                array_push($lijst, $gebruiker);
            }
            return $lijst; 
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* een bepaalde kolom ophalen uit de database aan de hand van een andere kolom */
    public function fetch_info($what, $field, $value){
        $allowed = array('gebruikersnummer', 'gebruikersnaam', 'emailadres', 'voornaam', 'achternaam', 'adres', 'gemeente', 'postcode', 'telefoonnummer', 'leverwijze');
        if(!in_array($what, $allowed, true) || !in_array($field, $allowed, true)){
            throw new InvalidArgumentException;
        }else{
            $db = $this->getDb();
            $query = $db->prepare("SELECT $what FROM `gebruikers` WHERE $field = ?");
            $query->bindValue(1, $value);
            try{
                $query->execute();
            }catch(PDOException $e){
                die($e->getMessage());
            }
            return $query->fetchColumn();
        }
    }
    
    /* Recovery string genereren en wegschrijven naar database en mail zenden naar gebruiker */
    public function confirm_recover($gebruiker){ 
        $gebruiker->setId($this->fetch_info('gebruikersnummer', 'emailadres', $gebruiker->getEmailadres()));
        $unique = uniqid('', true);
        $random = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0, 10);
        $gebruiker->setRecovery_string($unique . $random);
        $db = $this->getDb();
        $query = $db->prepare("UPDATE `gebruikers` SET `recovery_string` = ? WHERE `gebruikersnummer` = ?");
        $query->bindValue(1, $gebruiker->getRecovery_string());
        $query->bindValue(2, $gebruiker->getId());
        
        try{
            $query->execute(); 
            $gebruiker = $this->gebruikerdata($gebruiker);
            return $gebruiker;            
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* Nieuw wachtwoord genereren en mail zenden naar gebruiker */
    public function recover($gebruiker){
        if($gebruiker->getRecovery_string() == 0){
            return false;
        }else{
            $db = $this->getDb();
            $query = $db->prepare("SELECT COUNT(`gebruikersnummer`) FROM `gebruikers` WHERE `emailadres`= ? And `recovery_string` = ?");
            $query->bindValue(1, $gebruiker->getEmailadres());
            $query->bindValue(2, $gebruiker->getRecovery_string());
            try{
                $query->execute();
                $rows = $query->fetchColumn();
                if($rows == 1){
                    global $bcrypt; 
                    $gebruiker->setId($this->fetch_info('gebruikersnummer', 'emailadres', $gebruiker->getEmailadres()));
                    
                    $charset = 'abcdefghijklmnopqrstuvwyzABCDEFGHIJKLMNOPQRSTUVWYZ0123456789';
                    $password = substr(str_shuffle($charset), 0, 10);
                    $gebruiker->setWachtwoord($password);
                    $this->change_password($gebruiker);
                    $gebruiker->setWachtwoord($password);
                    $db = $this->getDb();
                    $query = $db->prepare("UPDATE `gebruikers` SET `recovery_string` = 0 WHERE `gebruikersnummer` = ?");
                    $query->bindValue(1, $gebruiker->getId());
                    $query->execute(); 
                    $gebruiker->setGebruikersnaam($this->fetch_info('gebruikersnaam', 'emailadres', $gebruiker->getEmailadres()));
                    return $gebruiker;
                 }else{
                     return false;
                 }
            }catch(PDOException $e){
                die($e->getMessage());
            }
        }
    }
    
    /* Wachtwoord van gebruiker veranderen */
    public function change_password($gebruiker){
        global $bcrypt;
        $gebruiker->setWachtwoord($bcrypt->genHash($gebruiker->getWachtwoord()));
        $db = $this->getDb();
        $query = $db->prepare("Update `gebruikers` SET `wachtwoord` = ? WHERE `gebruikersnummer` = ?");
        $query->bindValue(1, $gebruiker->getWachtwoord());
        $query->bindValue(2, $gebruiker->getId());
        
        try{
            $query->execute();
            return true;
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* De gebruikerdata aanpassen */
    public function update($gebruiker){
        $db = $this->getDb();
        $query = $db->prepare("UPDATE `gebruikers` SET
                                    `emailadres`    = ?,
                                    `voornaam`      = ?,
                                    `achternaam`    = ?,
                                    `adres`         = ?,
                                    `gemeente`      = ?,
                                    `postcode`      = ?,
                                    `telefoonnummer`= ?,
                                    `leverwijze`    = ?
                                    WHERE `gebruikersnummer`= ?
                                    ");
        $query->bindValue(1, $gebruiker->getEmailadres());
        $query->bindValue(2, $gebruiker->getVoornaam());
        $query->bindValue(3, $gebruiker->getAchternaam());
        $query->bindValue(4, $gebruiker->getAdres());
        $query->bindValue(5, $gebruiker->getGemeente());
        $query->bindValue(6, $gebruiker->getPostcode());
        $query->bindValue(7, $gebruiker->getTelefoonnummer());
        $query->bindValue(8, $gebruiker->getLeverwijze());
        $query->bindValue(9, $gebruiker->getId());
        
        try{
            $query->execute();
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* de status van de gebruiker aanpassen */
    public function updateStatus($gebruiker){
        $db = $this->getDb();
        $query = $db->prepare("UPDATE `gebruikers` SET
                                    `status`      = ?                                    
                                    WHERE `gebruikersnummer`= ?
                                    ");
        $query->bindValue(1, $gebruiker->getStatus());
        $query->bindValue(2, $gebruiker->getId());
        
        try{
            $query->execute();
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    /* De gebruiker verwijderen uit de database */
    public function delete($gebruiker) { 
        $db = $this->getDb();
        $query = $db->prepare("delete from gebruikers where gebruikersnummer = ?"); 
        $query->bindValue(1, $gebruiker->getId());
        
        try{
            $query->execute();
        }catch(PDOException $e){
            die($e->getMessage());
        }
        
    }
}
?>
