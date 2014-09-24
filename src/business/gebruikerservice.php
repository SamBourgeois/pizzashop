<?php
require_once("../src/data/gebruikerdao.php");

$gebruikerDAO = new GebruikerDAO();
class GebruikerService{
    
    /* Controleren of de gebruikersnaam in de database zit */
    public static function gebruikersnaamExists($gebruiker){
        global $gebruikerDAO;
        return $gebruikerDAO->gebruikersnaam_exists($gebruiker);
    }
    
    /* controleren of het emailadres al in de database zit */
    public static function emailExists($gebruiker){
        global $gebruikerDAO;
        return $gebruikerDAO->email_exists($gebruiker);
    }
    
    /* De gebruiker toevoegen aan de database */
    public static function registerGebruiker($gebruiker){
        global $gebruikerDAO;
        $gebruiker = $gebruikerDAO->register($gebruiker);        
    }
    
    /* Controleren of de gebruiker en wachtwoord kloppen */
    public static function login($gebruiker){
        global $gebruikerDAO;
        return $gebruikerDAO->login($gebruiker);
    }
    
    /* Controleren of de gebruiker een admin is */
    public static function is_admin($id){
        global $gebruikerDAO;
        return $gebruikerDAO->is_admin($id);
    }
    
    /* De gebruiker data ophalen uit database */
    public static function getGebruiker($gebruiker){
        global $gebruikerDAO;
        $gebruiker = $gebruikerDAO->gebruikerdata($gebruiker);        
        return $gebruiker;
    } 
    
    /* De gebruikers ophalen uit database */
    public static function getGebruikersLijst(){
        global $gebruikerDAO;
        return $gebruikerDAO->get_gebruikers();        
        
    } 
    
    /* een bepaalde kolom ophalen uit de database aan de hand van een andere kolom */
    public static function fetchGebruikerInfo($what, $field, $value){
        global $gebruikerDAO;
        return $gebruikerDAO->fetch_info($what, $field, $value);
    }
    
    /* Recovery string genereren en wegschrijven naar database en mail zenden naar gebruiker */
    public static function confirmRecoverGebruiker($gebruiker){
        global $gebruikerDAO;
        $gebruiker = $gebruikerDAO->confirm_recover($gebruiker);
        mail($gebruiker->getEmailadres(), 'Wachtwoord vergeten', "Hallo " . $gebruiker->getGebruikersnaam() . ",\r\nGelieve op onderstaande link te klikken:\r\n\r\n" . GebruikerService::curPageURL() . "recover.php?emailadres=" . $gebruiker->getEmailadres() . "&recovery_string=" . $gebruiker->getRecovery_string() . "\r\n\r\n Wij zullen een nieuw wachtwoord aanmaken en het via email zenden naar u.\r\n\r\n-de Pizzashop");
    }
    
    /* Nieuw wachtwoord genereren en mail zenden naar gebruiker */
    public static function recoverGebruiker($gebruiker){
        global $gebruikerDAO;
        $gebruiker = $gebruikerDAO->recover($gebruiker);
        if($gebruiker != false){   
            mail($gebruiker->getEmailadres(), 'Uw wachtwoord', "Hallo " . $gebruiker->getGebruikersnaam() . ",\n\nUw nieuw wachtwoord is: " . $gebruiker->getWachtwoord() . "\n\nGelieve dit te veranderen van zodra u aangemeld bent.\n\n-de Pizzashop");
        }else{return false;}
    }
    
    /* Wachtwoord van gebruiker veranderen */
    public static function changeGebruikerWachtwoord($gebruiker){
        global $gebruikerDAO;
        return $gebruikerDAO->change_password($gebruiker);
    }
    
    /* De gebruikerdata aanpassen */
    public static function updateGebruiker($gebruiker){
        global $gebruikerDAO;
        $gebruikerDAO->update($gebruiker);
    }
    
    /* de status van de gebruiker aanpassen */
    public static function updateStatus($gebruiker){
        global $gebruikerDAO;
        $gebruikerDAO->updateStatus($gebruiker);
    }
    
    /* De gebruiker verwijderen uit de database */
    public static function deleteGebruiker($gebruiker){
        global $gebruikerDAO;
        $gebruikerDAO->delete($gebruiker);
    }
    
    /* een string genereren met de current url */
    public static function curPageURL() {
        $pageURL = 'http';        
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/')).'/';
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/')).'/';
        }
        return $pageURL;
   }
   
   /* controleren of alle velden van het object gebruiker ingevuld zijn */
   public static function gebruikerVolledig($gebruiker){
       if($gebruiker->getGebruikersnaam() == '' || $gebruiker->getEmailadres() == '' || $gebruiker->getVoornaam() == '' || $gebruiker->getAchternaam() == '' || $gebruiker->getAdres() == '' || $gebruiker->getGemeente() == '' || $gebruiker->getPostcode() == '' || $gebruiker->getTelefoonnummer() == ''){
           return false;
       }else{
           return true;           
       }
   }
    
    
}
?>
