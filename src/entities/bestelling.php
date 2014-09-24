<?php
class Bestelling{
    private $id;
    private $gebruikersnaam;
    private $datum;
    private $leverwijze;
    private $totaalprijs;
    private $status;
    
    function __construct($id, $gebruikersnaam, $datum, $leverwijze, $totaalprijs, $status) {
        $this->id = $id;
        $this->gebruikersnaam = $gebruikersnaam;
        $this->datum = $datum;
        $this->leverwijze = $leverwijze;
        $this->totaalprijs = $totaalprijs;
        $this->status = $status;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getGebruikersnaam() {
        return $this->gebruikersnaam;
    }

    public function getDatum() {
        return $this->datum;
    }

    public function getLeverwijze() {
        return $this->leverwijze;
    }
    public function getLeverwijzeTekst(){
        if($this->leverwijze == 0){return "Thuislevering";}
        else{return "Afhalen";}
    }
    public function getTotaalprijs() {
        return $this->totaalprijs;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }



}
?>
