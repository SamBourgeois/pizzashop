<?php
/** Admin pagine **/
/* Gebruikers overzicht*/
/* - gebruiker aanpassen */
/* - gebruiker verwijderen */

$pagina     = "Admin - Gebruikers";
require '../src/config/init.php';
$general->admin_protect();
$heading    = $twig->render("heading.twig", array("isAdmin" => $general->is_admin(), "loggedIn" => $general->logged_in(), "gebruikersnaam" => $gebruiker->getGebruikersnaam()));


print($head);
print($heading);
?>
<?php 

/* gebruiker verwijderen*/
if(isset($_POST["verwijderen"])){
    $gebruiker = new Gebruiker();
    $gebruiker->setId($_POST['id']);
    $gebruikerservice->deleteGebruiker($gebruiker);
}

/* gebruiker status aanpassen*/
if(isset($_POST['aanpassen'])){
    $gebruiker = new Gebruiker();
    $gebruiker->setId($_POST['id']);
    $gebruiker->setStatus($_POST['status']);
    $gebruikerservice->updateStatus($gebruiker); 
}

/* gebruikers overzicht */
$gebruikers = $gebruikerservice->getGebruikersLijst();
include("../src/presentation/includes/admin/gebruikers.php");
print($footer);
?>

