<?php
/** Registratie pagina **/

$pagina     = "Register";
require '../src/config/init.php';
$general->logged_in_protect();
$heading    = $twig->render("heading.twig");

if(isset($_POST['submit'])){
    
    /* Invoer controle */
    if (empty($_POST['gebruikersnaam'])){array_push($errors, 'Gelieve uw gebruikersnaam in te vullen');}else{$gebruiker->setGebruikersnaam($_POST['gebruikersnaam']);}
    if (empty($_POST['emailadres'])){array_push($errors, 'Gelieve uw emailadres in te vullen');}else{$gebruiker->setEmailadres($_POST['emailadres']);}
    if (empty($_POST['wachtwoord'])){array_push($errors, 'Gelieve uw wachtwoord in te vullen');}else{$gebruiker->setWachtwoord($_POST['wachtwoord']);}
    if (empty($_POST['voornaam'])){array_push($errors, 'Gelieve uw voornaam in te vullen');}else{$gebruiker->setVoornaam($_POST['voornaam']);}
    if (empty($_POST['achternaam'])){array_push($errors, 'Gelieve uw achternaam in te vullen');}else{$gebruiker->setAchternaam($_POST['achternaam']);}
    if (empty($_POST['adres'])){array_push($errors, 'Gelieve uw adres in te vullen');}else{$gebruiker->setAdres($_POST['adres']);}
    if (empty($_POST['gemeente'])){array_push($errors, 'Gelieve uw gemeente in te vullen');}else{$gebruiker->setGemeente($_POST['gemeente']);}
    if (empty($_POST['postcode'])){array_push($errors, 'Gelieve uw postcode in te vullen');}else{$gebruiker->setPostcode($_POST['postcode']);}
    if (empty($_POST['telefoonnummer'])){array_push($errors, 'Gelieve uw telefoonnummer in te vullen');}else{$gebruiker->setTelefoonnummer($_POST['telefoonnummer']);}
    if ($gebruikerservice->gebruikerVolledig($gebruiker) && !(empty($_POST['wachtwoord']))){ 
        if($gebruikerservice->gebruikersnaamExists($gebruiker) === true){
            array_push($errors, 'Het gebruikersnaam bestaat al, gelieve een ander te kiezen');
        }
        if(!ctype_alnum($gebruiker->getGebruikersnaam())){
            array_push($errors, 'Gelieve een gebruikersnaam te kiezen met enkel letters en nummers');
        }
        if(strlen($gebruiker->getWachtwoord()) < 6){
            array_push($errors, 'Gelieve een wachtwoord te kiezen met meer dan 6 tekens');
        }else if (strlen($gebruiker->getWachtwoord())>18){
            array_push($errors, 'Gelieve een wachtwoord te kiezen met minder dan 18 tekens');
        }
        if(filter_var($gebruiker->getEmailadres(), FILTER_VALIDATE_EMAIL) === false){
            array_push($errors, 'Gelieve een geldig emailadres in te vullen');
        }else if($gebruikerservice->emailExists($gebruiker) == true){
            array_push($errors, 'Het emailadres bestaat al, gelieve een andere te gebruiken');
        }
        if(!(is_numeric($gebruiker->getPostcode()))){
            array_push($errors, 'Gelieve een geldig postcode in te vullen (enkel cijfers)');
        }
        if(!(is_numeric($gebruiker->getTelefoonnummer()))){
            array_push($errors, 'Gelieve een geldig telefoonnummer in te vullen (enkel cijfers)');
        }
        
    }
}
if(empty($errors) === true && isset($_POST['submit'])){ 
    /* Gebruiker toevoegen aan database */
    $gebruiker->setGebruikersnaam(htmlentities($_POST['gebruikersnaam']));
    $gebruiker->setEmailadres(htmlentities($_POST['emailadres']));
    $gebruiker->setWachtwoord($_POST['wachtwoord']);
    $gebruiker->setVoornaam(htmlentities($_POST['voornaam']));
    $gebruiker->setAchternaam(htmlentities($_POST['achternaam']));
    $gebruiker->setAdres(htmlentities($_POST['adres']));
    $gebruiker->setGemeente(htmlentities($_POST['gemeente']));
    $gebruiker->setPostcode(htmlentities($_POST['postcode']));
    $gebruiker->setTelefoonnummer(htmlentities($_POST['telefoonnummer']));

    $gebruikerservice->registerGebruiker($gebruiker);
    $view = $twig->render("registerSuccess.twig");
}else{
    $view = $twig->render("register.twig", array("gebruikersnaam" => $gebruiker->getGebruikersnaam(), "emailadres" => $gebruiker->getEmailadres(), "voornaam" => $gebruiker->getVoornaam(), "achternaam" => $gebruiker->getAchternaam(), "adres" => $gebruiker->getAdres(), "gemeente" => $gebruiker->getGemeente(), "postcode" => $gebruiker->getPostcode(), "telefoonnummer" => $gebruiker->getTelefoonnummer()));
}
?>
<?php 
print($head);
print($heading);

if(empty($errors) === false){
    print("<div class=\"container errors\"><ul><li>" . implode('</li><li>', $errors). "</li></ul></div>");
}  
    
print($view);
print($footer);
