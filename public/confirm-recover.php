<?php
/** Wachtwoord vergeten pagina **/
/* Gebruikers voeren hun emailadres in, nieuw wachtwoord wordt opgestuurd */

$pagina     = "Settings"; 
require '../src/config/init.php';
$general->logged_in_protect();
$heading    = $twig->render("heading.twig", array("loginHidden" => true));
?>
<?php 
  
/* Controle of het emailadres in de database zit */
if (isset($_POST['emailadres']) === true && empty($_POST['emailadres']) === false) {
    $gebruiker->setEmailadres($_POST['emailadres']);
    if($gebruikerservice->emailExists($gebruiker) === true){
        
        /* als emailadres bestaat nieuw wachtwoord via mail zenden */
        $gebruikerservice->confirmRecoverGebruiker($gebruiker);
        $view = $twig->render("requestSent.twig"); 
    } else if (isset($_POST['emailadres'])) {
        
        /* emailadres bestaat niet : foutboodschap tonen */
        $errors[] = 'Sorry, dat emailadres bestaat niet.';
        $view = $twig->render("recover.twig"); 
    }
}else{
    $view = $twig->render("recover.twig"); 
}


print($head);
print($heading);
if(empty($errors) === false){
    print("<div class=\"container errors\"><ul><li>" . implode('</li><li>', $errors). "</li></ul></div>");
}
print($view);
print($footer);
?>