<?php
/** Overzicht van leveringsadres en de te bestellen producten **/

$pagina     = "Winkelmandje";
require '../src/config/init.php';
require_once("../src/business/productenservice.php");
require_once("../src/business/leverzonesservice.php");
require_once("../src/business/bestelservice.php");
require'../src/entities/winkelmandje.php';
$heading    = $twig->render("heading.twig", array("isAdmin" => $general->is_admin(), "loggedIn" => $general->logged_in(), "gebruikersnaam" => $gebruiker->getGebruikersnaam()));
$productenservice = new ProductenService();
$leverzonesservice = new Leverzonesservice();
$bestelservice = new BestelService();

print($head);
print($heading);

/* controle of de client aangemeld is */
if(!($general->logged_in())){
    $view = $twig->render("aanmeldenBericht.twig");
    print($view);
}else{
    /* overzicht leveradres */
    $adresgegevens = $twig->render("leveringsadres.twig", array("gebruiker" => $gebruiker));
    
    /* winkelmandje leegmaken */
    if(isset($_POST['leegmaken'])){
        unset($_SESSION['winkelmandje']);
        header('Location:pizzas.php');
    }
    
    /* nieuw leeg winkelmandje aanmaken als er geen winkelmandje is */
    if(!isset($_SESSION['winkelmandje'])){
        $winkelmandje = new Winkelmandje();        
    }else{
        
        /* winkelmandje ophalen uit sessie */
        $winkelmandje = unserialize($_SESSION['winkelmandje']);
    } 
    
    /* aantal van product uit winkelmandje aanpassen */
    if(isset($_POST["wijzigen"])){
        $product = unserialize(base64_decode($_POST['item']));
        
        /* invoercontrole */
        if(is_numeric($_POST['aantal'])){
            $aantal = htmlentities($_POST['aantal']);
            $winkelmandje->updateItem($product, $aantal);
            $_SESSION['winkelmandje'] = serialize($winkelmandje);
        }else{
            array_push($errors, 'Gelieve een geldig aantal in te vullen');
        }
        
    /* product uit winkelmandje verwijderen */
    }else if(isset($_POST['verwijderen'])){
        $product = unserialize(base64_decode($_POST['item']));
        $winkelmandje->updateItem($product, 0);
        $_SESSION['winkelmandje'] = serialize($winkelmandje);
        
    /* winkelmandje wegschrijven naar database */
    }else if(isset($_POST['bestellen'])){
        $gebruiker->setLeverwijze($_POST['levering']);
        $gebruikerservice->updateGebruiker($gebruiker);
        $bestelservice->plaatsBestelling($gebruiker, $winkelmandje);
        unset($_SESSION['winkelmandje']);
        header('Location:success.php');
    }
    if(empty($errors) === false){
        print("<div class=\"container errors\"><ul><li>" . implode('</li><li>', $errors). "</li></ul></div>");
    }
    print($adresgegevens); 
    
    /* overzicht van de te bestellen producten */
    include '../src/presentation/includes/productenoverzicht.php';
}

print($footer);
?>