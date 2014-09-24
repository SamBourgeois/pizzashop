<?php
/** Over ons pagina **/

$pagina     = "Over_ons";
require '../src/config/init.php';
$heading    = $twig->render("heading.twig", array("isAdmin" => $general->is_admin(), "loggedIn" => $general->logged_in(), "gebruikersnaam" => $gebruiker->getGebruikersnaam()));
$view       = $twig->render("contact.twig");

?>
<?php 
print($head);
print($heading);
print($view);
print($footer);
?>
