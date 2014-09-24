<?php
class Gebruiker{
    private $id;
    private $gebruikersnaam;
    private $emailadres;
    private $wachtwoord;
    private $recovery_string;
    private $datum;
    private $voornaam;
    private $achternaam;
    private $adres;
    private $gemeente;
    private $postcode;
    private $telefoonnummer;
    private $status;
    private $leverwijze;
    
    function __construct() {        
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getGebruikersnaam() {
        return $this->gebruikersnaam;
    }

    public function setGebruikersnaam($gebruikersnaam) {
        $this->gebruikersnaam = $gebruikersnaam;
    }

    public function getEmailadres() {
        return $this->emailadres;
    }

    public function setEmailadres($emailadres) {
        $this->emailadres = $emailadres;
    }

    public function getWachtwoord() {
        return $this->wachtwoord;
    }

    public function setWachtwoord($wachtwoord) {
        $this->wachtwoord = $wachtwoord;
    }

    public function getRecovery_string() {
        return $this->recovery_string;
    }

    public function setRecovery_string($recovery_string) {
        $this->recovery_string = $recovery_string;
    }

    public function getDatum() {
        return $this->datum;
    }

    public function setDatum($datum) {
        $this->datum = $datum;
    }

    public function getVoornaam() {
        return $this->voornaam;
    }

    public function setVoornaam($voornaam) {
        $this->voornaam = $voornaam;
    }

    public function getAchternaam() {
        return $this->achternaam;
    }

    public function setAchternaam($achternaam) {
        $this->achternaam = $achternaam;
    }

    public function getAdres() {
        return $this->adres;
    }

    public function setAdres($adres) {
        $this->adres = $adres;
    }

    public function getGemeente() {
        return $this->gemeente;
    }

    public function setGemeente($gemeente) {
        $this->gemeente = $gemeente;
    }

    public function getPostcode() {
        return $this->postcode;
    }

    public function setPostcode($postcode) {
        $this->postcode = $postcode;
    }

    public function getTelefoonnummer() {
        return $this->telefoonnummer;
    }

    public function setTelefoonnummer($telefoonnummer) {
        $this->telefoonnummer = $telefoonnummer;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    
    public function getStatusTekst(){
        if($this->status == 2){
            return "Admin";
        }elseif($this->status == 1){
            return "Inactive";
        }else{
            return "";
        }
    }
    public function getLeverwijze() {
        return $this->leverwijze;
    }
    public function getLeverwijzeNummer(){
        if($this->leverwijze=="Thuislevering"){
            return "0";
        }else{ return "1";}
    }

    public function setLeverwijze($leverwijze) {
        $this->leverwijze = $leverwijze;
    }




}
?>
