<?php
/** Pizzas zijn besteld**/
$pagina     = "Home"; 
require '../src/config/init.php';
$general->logged_out_protect();
$heading    = $twig->render("heading.twig", array("isAdmin" => $general->is_admin(), "loggedIn" => $general->logged_in(), "gebruikersnaam" => $gebruiker->getGebruikersnaam()));

?>
<?php

?>
<?php 
print($head);
print($heading);  

?>

<div class="container">    
    <div class="tekst">
        
        <?php
        if($gebruiker->getLeverwijze()<>""){
            print("<h2>Dank u om bij ons te bestellen</h2>");
            if($gebruiker->getLeverwijze() == "Thuislevering"){
                
                print("<p>Uw pizza zal zo vlug mogelijk bij u geleverd worden</p>");
            }else{
                print("<p>Uw pizza zal klaar liggen wanneer u er achter komt.</p>");
            }
        }else{
            header('Location:bestellen.php');
        }       
        ?>        
    </div>
</div>
<?php
print($footer);
?>