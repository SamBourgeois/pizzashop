<?php
require_once '../src/data/berichtendao.php';
$berichtenDAO = new BerichtenDAO();

class BerichtenService{
    
    /* bericht wegschrijven naar database */
    public function createBericht($bericht){
        global $berichtenDAO;
        return $berichtenDAO->create($bericht);
    }
    
    /* bericht verwijderen uit database */
    public function deleteBericht($id){
        global $berichtenDAO;
        return $berichtenDAO->delete($id);
    }
    
    /* Berichten uit database halen */
    public function getBerichtenLijst(){
        global $berichtenDAO;
        return $berichtenDAO->getLijst();        
    }
}
?>
