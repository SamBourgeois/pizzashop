<?php
class Artikel{
    private $id;
    private $naam;
    private $omschrijving;
    private $image_locatie;
    private $prijs;
    private $korting;
    private $cat;
    private $extras = array();
    private $etraids = array();
    private $aantal;
    
    function __construct($id, $naam, $omschrijving, $image_locatie, $prijs, $korting, $cat) {
        $this->id = $id;
        $this->naam = $naam;
        $this->omschrijving = $omschrijving;
        $this->image_locatie = $image_locatie;
        $this->prijs = $prijs;
        $this->korting = $korting;
        $this->cat = $cat;
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

    public function getOmschrijving() {
        return $this->omschrijving;
    }

    public function setOmschrijving($omschrijving) {
        $this->omschrijving = $omschrijving;
    }

    public function getImage_locatie() {
        return $this->image_locatie;
    }

    public function setImage_locatie($image_locatie) {
        $this->image_locatie = $image_locatie;
    }

    public function getPrijsTekst() {
        return '€ '.number_format($this->getPrijs(), 2, '.', '');
    }
    private function getExtrasPrijs(){
        $prijs = 0;
        foreach ($this->extras as $extra){
            $prijs += $extra->getPrijs();
        }
        return number_format($prijs, 2, '.', '');
    }
    public function getPrijs() {
        $prijs = $this->prijs + $this->getExtrasPrijs();
        return number_format($prijs, 2, '.', '');
    }
    public function getTotaalPrijs() {
        $prijs = ($this->getPrijs() - $this->getKorting())*$this->getAantal();
        return number_format($prijs, 2, '.', '');
    }
    public function getTotaalPrijsTekst() {
        return '€ '. number_format($this->getTotaalPrijs(), 2, '.', '');
    }
    public function setPrijs($prijs) {
        $this->prijs = $prijs;
    }

    public function getKortingTekst() {
        if ($this->korting == 0){
            return '';
        }else{
            return '€ -' .$this->korting;
        }
    }
    public function getKorting() {
       return $this->korting + 0;
    }
    public function setKorting($korting) {
        $this->korting = $korting;
    }
    
    public function getCat() {
        return $this->cat;
    }

    public function setCat($cat) {
        $this->cat = $cat;
    }
    public function setExtra(Artikel $extra){
        array_push($this->extras, $extra);
        array_push($this->etraids, $extra->getId());
    }
    public function getExtras(){
        return $this->extras;
    }
    public function getExtrasids(){
        return $this->etraids;
    } 
    public function getExtrasString(){
        $string = "";
        foreach($this->extras as $extra){
            if($string==""){$string = $extra->getNaam();}
            else{$string .= ", ".$extra->getNaam();}
        }
        return $string;
    }
    public function getAantal(){
        return $this->aantal;
    }
    public function setAantal($aantal){
        $this->aantal = $aantal;
    }    
}
?>
