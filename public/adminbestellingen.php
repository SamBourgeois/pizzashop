<?php
/** Admin pagina - Bestellingen **/
/* Bestellingen overzicht */
/* - Bestellingen filteren */
/* - Bestelling aanpassen */
/* - Bestelling details bekijken */

$pagina     = "Admin - Bestellingen";
require '../src/config/init.php';
$general->admin_protect();
require_once("../src/business/productenservice.php");
require_once("../src/business/bestelservice.php");
require_once("../src/entities/bestelling.php");
$heading    = $twig->render("heading.twig", array("isAdmin" => $general->is_admin(), "loggedIn" => $general->logged_in(), "gebruikersnaam" => $gebruiker->getGebruikersnaam()));
$productenservice = new ProductenService();
$bestelservice = new BestelService();

print($head);
print($heading); 
?>
<?php 
/* bestelling details bekijken */
if(isset($_POST['details'])){
    include("../src/presentation/includes/admin/bestellingdetails.php");
}else{
    if(isset($_POST['aanpassen'])){
        $bestelling = new Bestelling($_POST['id'], "", "", "", "", $_POST['status']);  
        $bestelservice->updateStatus($bestelling);    
    }
    
    /* Filter gegevens */
    if(isset($_POST['filter'])){   
        if(is_numeric($_POST['filternaam']) && isset($_POST['open'])){
            $bestellingen = $bestelservice->getFilterBestellingLijst($_POST['filternaam'], 1);
        }elseif(is_numeric($_POST['filternaam']) && !(isset($_POST['open']))){
            $bestellingen = $bestelservice->getFilterBestellingLijst($_POST['filternaam'], 0);
        }elseif(!(is_numeric($_POST['filternaam'])) && isset($_POST['open'])){
            $bestellingen = $bestelservice->getBestellingLijst(1);
        }else{
            $bestellingen = $bestelservice->getBestellingLijst(0);
        }
    }else{
        $bestellingen = $bestelservice->getBestellingLijst(0);
    }
    /* bestellingen overzicht */
    $gebruikersnamen = $bestelservice->getGebruikersnamen();
    include("../src/presentation/includes/admin/bestellingen.php");
}
print($footer);
?>

