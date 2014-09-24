<?php
/** Overzicht van alle pizzas **/
/* + klein overzicht van winkelmandje */
/* - Producten aan winkelmandje toevoegen */

/** ook code in producten.php*/
/* - Extras van pizzas tonen */

$pagina     = "Pizza";
require '../src/config/init.php';
require_once("../src/business/productenservice.php");
require'../src/entities/winkelmandje.php';
require_once("../src/entities/artikel.php");
require_once("../src/entities/categorie.php");

$heading    = $twig->render("heading.twig", array("isAdmin" => $general->is_admin(), "loggedIn" => $general->logged_in(), "gebruikersnaam" => $gebruiker->getGebruikersnaam()));
$productenservice = new ProductenService();
$categorieen = $productenservice->getCategorieen();
?>
<?php

/* Nieuw winkelmandje aanmaken */
if(!isset($_SESSION['winkelmandje'])){
    $winkelmandje = new Winkelmandje();        
}else{
    $winkelmandje = unserialize($_SESSION['winkelmandje']);
} 

/* Producten aan winkelmandje toevoegen */
if(isset($_POST['submit']) && $_POST['cat']<>2){ 
    $artikel = $productenservice->getProduct($_POST['id']);
    if(!empty($_POST['checkbox'])){
        foreach($_POST['checkbox'] as $extraid){
            $extra = $productenservice->getProduct($extraid);
            $artikel->setExtra($extra);
        }
    }    
    $winkelmandje->addItem($artikel);  
    $_SESSION['winkelmandje'] = serialize($winkelmandje);
}

?>
<?php 
print($head);
print($heading); 
include("../src/presentation/includes/producten.php");
include("../src/presentation/includes/winkelmandjeSmal.php");
print($footer);
?>
