<?php
require_once '../src/data/besteldao.php';
$bestelDAO = new BestelDAO();

class BestelService{
    
    /* bestelling wegschrijven naar database */
    public function plaatsBestelling($gebruiker, $winkelmandje){
        global $bestelDAO;
        return $bestelDAO->plaatsBestelling($gebruiker, $winkelmandje);
    }    
    
    /* bestellingen ophalen */
    public function getBestellingLijst($open){
        global $bestelDAO;
        return $bestelDAO->getLijst($open);
    } 
    
    /* bestellingen per klant ophalen */
    public function getFilterBestellingLijst($id, $open){
        global $bestelDAO;
        return $bestelDAO->getFilterLijst($id, $open);
    }
    
    /* Status van een bestelling veranderen */
    public function updateStatus($bestelling){
        global $bestelDAO;
        $bestelDAO->updateStatus($bestelling);
    }
    
    /* Producten per bestelling ophalen */
    public function getBestelLijnen($id){
        global $bestelDAO;
        return $bestelDAO->getBestelLijnen($id);
    }
    
    /* extras per product ophalen */
    public function getExtras($id){
        global $bestelDAO;
        return $bestelDAO->getExtras($id);
    } 
    
    /* de gebruiker ophalen die de bestelling geplaatst heeft */
    public function getGebruiker($id){
        global $bestelDAO;
        return $bestelDAO->getGebruiker($id);
    } 
    
    /* De gebruikersnamen ophalen van de klanten die bestellingen geplaatst hebben */
    public function getGebruikersnamen(){
        global $bestelDAO;
        return $bestelDAO->getGebruikersnamen();
    } 
}
?>
