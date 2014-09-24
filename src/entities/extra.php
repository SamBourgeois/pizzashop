<?php
class Extra{
    private $id;
    private $naam;
    private $prijs;
    
    function __construct($id, $naam, $prijs) {
        $this->id = $id;
        $this->naam = $naam;
        $this->prijs = $prijs;
    }
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNaam() {
        return $this->naam;
    }

    public function setNaam($naam) {
        $this->naam = $naam;
    }

    public function getPrijs() {
        return $this->prijs;
    }

    public function setPrijs($prijs) {
        $this->prijs = $prijs;
    }


}
?>
