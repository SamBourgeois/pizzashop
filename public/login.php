<?php
/** Login pagina **/
$pagina     = "Login";
require '../src/config/init.php';
$general->logged_in_protect();
$heading    = $twig->render("heading.twig", array("loginHidden" => true));
$view       = $twig->render("loginpagina.twig");

if(empty($_POST)=== false){
    $gebruiker->setEmailadres(trim($_POST['email']));
    $gebruiker->setWachtwoord(trim($_POST['wachtwoord']));
    
    /* Invoer controle */
    if(empty($gebruiker->getEmailadres()) === true || empty($gebruiker->getWachtwoord()) === true){
        array_push($errors, 'Sorry, gelieve uw emailadres en wachtwoord in te vullen.');
        
    /* Controle of emailadres bestaat */
    }else if($gebruikerservice->EmailExists($gebruiker) === false){
        array_push($errors, 'Sorry dat emailadres bestaat niet.');
    }else{        
        $login = $gebruikerservice->login($gebruiker);        
        if($login === false){
            array_push($errors, 'Sorry, dat emailadres/wachtwoord is verkeerd');
        }else {  
            
            /* sessie aanmaken */
            session_regenerate_id(true);
            $_SESSION['id'] = $login->getId();
            header('Location: index.php');
            exit();
        }
    }
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
?>