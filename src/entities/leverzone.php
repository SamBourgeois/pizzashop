<?php
class Leverzone{
    private $postcode;
    private $gemeente;
    private $prijs;
    
    function __construct($postcode, $gemeente, $prijs) {
        $this->postcode = $postcode;
        $this->gemeente = $gemeente;
        $this->prijs = $prijs;
    }
    public function getPostcode() {
        return $this->postcode;
    }

    public function setPostcode($postcode) {
        $this->postcode = $postcode;
    }

    public function getGemeente() {
        return $this->gemeente;
    }

    public function setGemeente($gemeente) {
        $this->gemeente = $gemeente;
    }

    public function getPrijs() {
        return $this->prijs;
    }

    public function setPrijs($prijs) {
        $this->prijs = $prijs;
    }
    public function getPrijsTekst(){
        return '€ ' . $this->getPrijs();
    }
}
?>
