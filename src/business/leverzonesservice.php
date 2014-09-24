<?php
require_once '../src/data/leverzonesdao.php';
$LeverzonesDAO = new LeverzonesDAO();

class Leverzonesservice{   
    
    /* lijst met leverzones ophalen */
    public function getLeverzones(){
        global $LeverzonesDAO;
        return $LeverzonesDAO->getLeverzones();        
    }
    
    /* lijst met postcodes ophalen */
    public function getLeverPostcodes(){
        global $LeverzonesDAO;
        return $LeverzonesDAO->getLeverPostcodes();        
    }
    
    /* controleren of gebruiker in de leverzones woont */
    public function isLeverbaar(Gebruiker $gebruiker){
        return in_array($gebruiker->getPostcode(), $this->getLeverPostcodes());
    }
    
    /* Leverzone ophalen */
    public function getLeverzone($gebruiker){
        global $LeverzonesDAO;
        return $LeverzonesDAO->getLeverzone($gebruiker);
    }
    
    /* leverzone verwijderen */
    public function deleteLeverzone(Leverzone $leverzone){
        global $LeverzonesDAO;
        return $LeverzonesDAO->delete($leverzone);
    }
    
    /* leverzone toevoegen */
    public function createLeverzone(Leverzone $leverzone){
        global $LeverzonesDAO;
        return $LeverzonesDAO->create($leverzone);
    }
    
    /* controle of postcode in database zit */
    public function postcode_exists(Leverzone $leverzone){
        global $LeverzonesDAO;
        return $LeverzonesDAO->postcode_exists($leverzone);
    }
    
    /* Leverzone aanpassen */
    public function updateLeverzone(Leverzone $leverzone){
        global $LeverzonesDAO;
        return $LeverzonesDAO->update($leverzone);
    }
}
?>
