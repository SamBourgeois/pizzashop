<?php
/** Admin pagina**/
/* extras overzicht */
/* - extra toevoegen */
/* - extra aanpassen */
/* - extra verwijderen */

$pagina     = "Admin - Extras";
require '../src/config/init.php';
require_once("../src/entities/artikel.php");

$general->admin_protect();
require_once("../src/business/productenservice.php");
$heading    = $twig->render("heading.twig", array("isAdmin" => $general->is_admin(), "loggedIn" => $general->logged_in(), "gebruikersnaam" => $gebruiker->getGebruikersnaam()));
$productenservice = new ProductenService();

print($head);
print($heading);
?>
<?php 

/* extra verwijderen */
if(isset($_POST["verwijderen"])){
    $productenservice->deleteProduct($_POST['id']);
    header('Location: adminextras.php');
    exit();
}

/*extra toevoegen */
if(isset($_POST['nieuw'])){
    $artikel = new Artikel("","","","","","","");
    $artikel->setCat($_POST['cat']);
    include("../src/presentation/includes/admin/nieuwproduct.php");
    
/*extra aanpassen */
}else if(isset($_POST['aanpassen'])){
    $artikel = $productenservice->getProduct($_POST['id']);
    include("../src/presentation/includes/admin/bewerkproduct.php");
}elseif(isset($_POST['aanpassen2']) || isset($_POST['toevoegen'])){
    if(isset($_POST['aanpassen2'])){    
        $artikel = $productenservice->getProduct($_POST['id']);
    }else{
        $artikel = new Artikel("","","","","","","");
        $artikel->setCat($_POST['cat']);
    }

    /* invoer controlle */
    if(isset($_POST['naam'])){
        if($_POST['naam'] == ""){
            array_push($errors, 'Gelieve een naam in te vullen');
        }else{
            $artikel->setNaam(htmlentities($_POST['naam']));
        }
    }     
    if(isset($_POST['omschrijving']))$artikel->setOmschrijving(htmlentities($_POST['omschrijving']));
    if(isset($_POST['prijs'])){
        if($_POST['prijs'] == ""){
            array_push($errors, 'Gelieve een prijs in te vullen');
        }elseif(!(is_numeric($_POST['prijs']))){
            array_push($errors, 'Gelieve een prijs met numerieke waarden in te vullen');
        }else{
            $artikel->setPrijs(htmlentities($_POST['prijs']));
        }
    }
    if(isset($_POST['korting'])){
        if($_POST['korting'] == ""){
            array_push($errors, 'Gelieve een korting in te vullen');
        }elseif(!(is_numeric($_POST['korting']))){
            array_push($errors, 'Gelieve een korting met numerieke waarden in te vullen');
        }else{
            $artikel->setKorting(htmlentities($_POST['korting']));
        }
    }  
    if(isset($_FILES['myfile']) && !empty($_FILES['myfile']['name'])){        
        $name           = $_FILES['myfile']['name'];
        $tmp_name       = $_FILES['myfile']['tmp_name'];
        $allowed_ext    = array('jpg', 'jpeg', 'png', 'gif');
        $a              = explode('.', $name);
        $file_ext       = strtolower(end($a)); unset($a);
        $file_size      = $_FILES['myfile']['size'];
        $path           = "images";

        if(in_array($file_ext,$allowed_ext) === false){
            array_push($errors, 'File type niet toegestaan');
        }
        if($file_size > 2097152){
            array_push($errors, 'File grootte moet onder de 2MB zijn');
        }
    }else{
        $newpath = $artikel->getImage_locatie();
    }
    if(empty($errors) === false){
        print("<div class=\"container errors\"><ul><li>" . implode('</li><li>', $errors). "</li></ul></div>");
        if(isset($_POST['aanpassen2'])){
            include("../src/presentation/includes/admin/bewerkproduct.php");
        }else{
            include("../src/presentation/includes/admin/nieuwproduct.php");
        }
    }else { 
        /** als alles in orde is **/
        /* Afbeelding uploaden */
        if(isset($_FILES['myfile']) && !empty($_FILES['myfile']['name'])){            
            $newpath = $general->file_newpath($path, $name);
            move_uploaded_file($tmp_name, $newpath);
            $artikel->setImage_locatie($newpath);
        }   
        /* product aanpassen */
        if(isset($_POST['aanpassen2'])){
            $productenservice->updateProduct($artikel);
            header('Location: adminextras.php');
            exit(); 
        /* product toevoegen */
        }else if(isset($_POST['toevoegen'])){
            $productenservice->setProduct($artikel);
            header('Location: adminextras.php');
            exit(); 
        }
               
    }
    
}else{
    /* extras overzicht */
    $extras = $productenservice->getExtras();
    include("../src/presentation/includes/admin/extras.php");
}
print($footer);
?>

