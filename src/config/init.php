<?php
session_start();
require '../src/business/gebruikerservice.php';
require '../src/entities/gebruiker.php';
require '../src/business/general.php';
require '../src/entities/bcrypt.php';
require '../libraries/Twig/Autoloader.php';

Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem("../src/presentation");

$gebruiker          = new Gebruiker();
$gebruikerservice   = new GebruikerService();
$general            = new General();
$bcrypt             = new Bcrypt(12);

if($general->logged_in() === true){
    $gebruiker->setId($_SESSION['id']);
    $gebruiker = $gebruikerservice->getGebruiker($gebruiker);
}
$errors             = array();
$twig               = new Twig_Environment($loader);

$head               = $twig->render("header.twig", array("titel" => $pagina));
$menu               = $twig->render("menu.twig");
$general            = new General();
$footer             = $twig->render("footer.twig");
?>
