<?php
/** Account pagina **/
/* Account aanpassen, wachtwoord veranderen */

$pagina     = "Settings"; 
require '../src/config/init.php';
$general->logged_out_protect();
$heading    = $twig->render("heading.twig", array("isAdmin" => $general->is_admin(), "loggedIn" => $general->logged_in(), "gebruikersnaam" => $gebruiker->getGebruikersnaam()));
?>
<?php 
if(isset($_POST)){    
    /* account aan passen */
    if(isset($_POST['submitaccount'])){
        if (empty($_POST['gebruikersnaam'])){array_push($errors, 'Gelieve uw gebruikersnaam in te vullen');}else{$gebruiker->setGebruikersnaam($_POST['gebruikersnaam']);}
        if (empty($_POST['emailadres'])){array_push($errors, 'Gelieve uw emailadres in te vullen');}else{$gebruiker->setEmailadres($_POST['emailadres']);}
        if (empty($_POST['voornaam'])){array_push($errors, 'Gelieve uw voornaam in te vullen');}else{$gebruiker->setVoornaam($_POST['voornaam']);}
        if (empty($_POST['achternaam'])){array_push($errors, 'Gelieve uw achternaam in te vullen');}else{$gebruiker->setAchternaam($_POST['achternaam']);}
        if (empty($_POST['adres'])){array_push($errors, 'Gelieve uw adres in te vullen');}else{$gebruiker->setAdres($_POST['adres']);}
        if (empty($_POST['gemeente'])){array_push($errors, 'Gelieve uw gemeente in te vullen');}else{$gebruiker->setGemeente($_POST['gemeente']);}
        if (empty($_POST['postcode'])){array_push($errors, 'Gelieve uw postcode in te vullen');}else{$gebruiker->setPostcode($_POST['postcode']);}
        if (empty($_POST['telefoonnummer'])){array_push($errors, 'Gelieve uw telefoonnummer in te vullen');}else{$gebruiker->setTelefoonnummer($_POST['telefoonnummer']);}
        if($gebruikerservice->gebruikersnaamExists($gebruiker) === true){
            array_push($errors, 'Het gebruikersnaam bestaat al, gelieve een ander te kiezen');
        }
        if(!ctype_alnum($gebruiker->getGebruikersnaam())){
            array_push($errors, 'Gelieve een gebruikersnaam te kiezen met enkel letters en nummers');
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
    
    /* Wachtwoord veranderen*/
    if(isset($_POST['submitpassword'])){
        if(empty($_POST['current_password']) || empty($_POST['password']) || empty($_POST['password_again'])){
            array_push($errors, 'Alle wachtwoord velden zijn verplicht in te vullen');
        }else if($bcrypt->verify($_POST['current_password'], $gebruiker->getWachtwoord()) === true){
            if(trim($_POST['password']) != trim($_POST['password_again'])){
                array_push($errors, 'Uw nieuwe wachtwoorden waren niet gelijk');
            }else if(strlen($_POST['password'])<6){
                array_push($errors, 'Uw wachtwoord moet minstens 6 tekens lang zijn');
            }else if(strlen($_POST['password'])>18){
                array_push($errors, 'Uw wachtwoord kan niet meer dan 18 tekens lang zijn');
            }
        }else{
            array_push($errors, 'Uw huidig wachtwoord is niet correct');
        }
    }
}
print($head);
print($heading);
if(isset($_POST['submitaccount']) && empty($errors) === true && $gebruikerservice->gebruikerVolledig($gebruiker)){        
    $gebruikerservice->updateGebruiker($gebruiker);
    header('Location: account.php');
}else if(isset($_POST['submitpassword']) && empty($errors) === true){
    $gebruiker->setWachtwoord($_POST['password']);
    $gebruikerservice->changeGebruikerWachtwoord($gebruiker);
    header('Location: account.php');
}else if(empty($errors) === false){
    print("<div class=\"container errors\"><ul><li>" . implode('</li><li>', $errors). "</li></ul></div>");
} 
$view = $twig->render("account.twig", array("gebruikersnaam" => $gebruiker->getGebruikersnaam(), "emailadres" => $gebruiker->getEmailadres(), "voornaam" => $gebruiker->getVoornaam(), "achternaam" => $gebruiker->getAchternaam(), "adres" => $gebruiker->getAdres(), "gemeente" => $gebruiker->getGemeente(), "postcode" => $gebruiker->getPostcode(), "telefoonnummer" => $gebruiker->getTelefoonnummer()));
print($view);
print($footer);
?>
