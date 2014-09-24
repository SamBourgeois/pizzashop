<?php
class Bericht{
    private $id;
    private $gebruiker;
    private $titel;
    private $boodschap;
    
    function __construct($gebruiker, $titel, $boodschap) {
        $this->gebruiker = $gebruiker;
        $this->titel = $titel;
        $this->boodschap = $boodschap;
    }  
    
    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function getGebruiker() {
        return $this->gebruiker;
    }

    public function getTitel() {
        return $this->titel;
    }

    public function getBoodschap() {
        return $this->boodschap;
    }


}
    
?>
