<?php
class Categorie{
    private $id;
    private $omschrijving;
    
    function __construct($id, $omschrijving) {
        $this->id = $id;
        $this->omschrijving = $omschrijving;
    }
    public function getId() {
        return $this->id;
    }

    public function getOmschrijving() {
        return $this->omschrijving;
    }
}
?>
