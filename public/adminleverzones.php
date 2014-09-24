<?php
/** Admin pagina **/
/* Leverzones overzicht */
/* - Leverzone toevoegen */
/* - Leverzone aanpassen */
/* - Leverzone verwijderen */

$pagina     = "Admin - Leverzones";
require '../src/config/init.php';
require_once("../src/business/leverzonesservice.php");
require_once("../src/entities/leverzone.php");

$general->admin_protect();
$heading    = $twig->render("heading.twig", array("isAdmin" => $general->is_admin(), "loggedIn" => $general->logged_in(), "gebruikersnaam" => $gebruiker->getGebruikersnaam()));
$leverzonesservice = new Leverzonesservice();
$leverzones = $leverzonesservice->getLeverzones();

print($head);
print($heading);
?>
<?php 
/* Leverzone verwijderen */
if(isset($_POST["verwijderen"])){
    $leverzone = new Leverzone("","","");
    $leverzone->setPostcode($_POST['postcode']);
    $leverzonesservice->deleteLeverzone($leverzone);
    header('Location: adminleverzones.php');
    exit();
}

/* Leverzone toevoegen */
if(isset($_POST['nieuw'])){
    $leverzone = new Leverzone("","","");    
    include("../src/presentation/includes/admin/nieuwleverzone.php");

/* Leverzone aanpassen */
}else if(isset($_POST['aanpassen'])){
    $leverzone = new Leverzone("","","");
    $leverzone->setPostcode($_POST['postcode']);
    $leverzone = $leverzonesservice->getLeverzone($leverzone);
    include("../src/presentation/includes/admin/bewerkleverzone.php");
}elseif(isset($_POST['aanpassen2']) || isset($_POST['toevoegen'])){
    if(isset($_POST['aanpassen2'])){    
        $leverzone = new Leverzone("","","");
        $leverzone->setPostcode($_POST['postcode']);
        $leverzone = $leverzonesservice->getLeverzone($leverzone);
    }else{
        $leverzone = new Leverzone("","","");
    }

    /* invoer controle */
    if(isset($_POST['postcode'])){
        if($_POST['postcode'] == ""){
            array_push($errors, 'Gelieve een postcode in te vullen');
        }else if(!(is_numeric($leverzone->getPostcode()))){
            array_push($errors, 'Gelieve een geldig postcode in te vullen (enkel cijfers)');
        }else{
            $leverzone->setPostcode($_POST['postcode']);
            if(isset($_POST['toevoegen']) && $leverzonesservice->postcode_exists($leverzone)){
                array_push($errors, 'Postcode bestaat al');
            }else{            
                $leverzone->setPostcode(htmlentities($_POST['postcode']));
            }
        }
    }
    if(isset($_POST['gemeente'])){
        if($_POST['gemeente'] == ""){
            array_push($errors, 'Gelieve een gemeente in te vullen');
        }else{
            $leverzone->setGemeente(htmlentities($_POST['gemeente']));
        }
    }  
    if(isset($_POST['prijs'])){
        if($_POST['prijs'] == ""){
            array_push($errors, 'Gelieve een prijs in te vullen');
        }elseif(!(is_numeric($_POST['prijs']))){
            array_push($errors, 'Gelieve een prijs met numerieke waarden in te vullen');
        }else{
            $leverzone->setPrijs(htmlentities($_POST['prijs']));
        }
    }  
    if(empty($errors) === false){
        print("<div class=\"container errors\"><ul><li>" . implode('</li><li>', $errors). "</li></ul></div>");
        if(isset($_POST['aanpassen2'])){
            include("../src/presentation/includes/admin/bewerkleverzone.php");
        }else{
            include("../src/presentation/includes/admin/nieuwleverzone.php");
        }
    }else {   
        /** als alles in orde is **/
        /* leverzone aanpassen */
        if(isset($_POST['aanpassen2'])){
            $leverzonesservice->updateLeverzone($leverzone);
            header('Location: adminleverzones.php');
            exit();
            
        /* leverzone toevoegen */
        }else if(isset($_POST['toevoegen'])){
            $leverzonesservice->createLeverzone($leverzone);
            header('Location: adminleverzones.php');
            exit(); 
        }
               
    }
    
}else{
    /*leverzones overzicht */
    include("../src/presentation/includes/admin/leverzones.php");
}
print($footer);
?>

