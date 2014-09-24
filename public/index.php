<?php
/** Home pagina **/
/* + gastenboek */
$pagina     = "Home"; 
require '../src/config/init.php';
require_once("../src/entities/bericht.php");
require_once("../src/business/berichtenservice.php");
$heading    = $twig->render("heading.twig", array("isAdmin" => $general->is_admin(), "loggedIn" => $general->logged_in(), "gebruikersnaam" => $gebruiker->getGebruikersnaam()));
$view       = $twig->render("index.twig"); 
$berichtenService = new BerichtenService();
$lijst      =$berichtenService->getBerichtenLijst();


if(empty($_POST)=== false){
    /* Bericht uit gastenboek verwijderen */
    if(isset($_POST["delete"])){
        $id = $_POST['id'];
        $berichtenService->deleteBericht($id);
        header("location: index.php");
    }
    
    /* Bericht aan gastenboek toevoegen */
    if(isset($_POST["new"])) { 
        $titel = $_POST["titel"];
        $boodschap = $_POST["boodschap"]; 
        
        if (!empty($boodschap) && !empty($titel)) {
            $bericht = new Bericht($gebruiker->getGebruikersnaam(), $titel, $boodschap);
            $berichtenService->createBericht($bericht);
            header("location: index.php");
        }

    }
}
?>
<?php 
print($head);
print($heading);          
print($view);
include("../src/presentation/includes/gastenboek.php");
print($footer);
?>
