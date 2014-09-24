<?php
/** Nieuw wachtwoord aanmaken en vie mail zenden **/

$pagina     = "Settings"; 
require '../src/config/init.php';
$general->logged_in_protect();
$heading    = $twig->render("heading.twig", array("loginHidden" => true));
?>
<?php 
print($head);
print($heading);

/* Als emailadres en recoverystring in de link zitten */
if(isset($_GET['emailadres'], $_GET['recovery_string']) === true){
   $gebruiker = new Gebruiker();
   $gebruiker->setEmailadres(trim($_GET['emailadres']));
   $gebruiker->setRecovery_string(trim($_GET['recovery_string']));

   /* Controle of het emailadres en de recoverystring in de database zitten */
   if($gebruikerservice->emailExists($gebruiker) === false || $gebruikerservice->recoverGebruiker($gebruiker) === false){
   array_push($errors,'Sorry, er is iets fout gegaan. We konden uw wachtwoord niet herstellen.');
   }
   if(empty($errors) === false){
       print("<div class=\"container errors\"><ul><li>" . implode('</li><li>', $errors). "</li></ul></div>");
   }else{
       
       $view = $twig->render("wachtwoordSent.twig");
       print($view);
   }
}else{
   header('Location:index.php');
   exit();
}
print($footer);
?>