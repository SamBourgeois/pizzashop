<?php
/** Overzicht van producten in winkelmandje, zichtbaar op bestellen.php**/
?>
<div class="besteloverzicht">
    <?php
        if ($winkelmandje->isLeeg()) {
            print("<h2>Er zijn nog geen producten in het winkelmandje.</h2>");
        }elseif($gebruiker->getStatus() == "1"){
            print("<h2>Uw account is op inactief geplaatst</h2><p>Dit kan gebeuren doordat u de rekening van uw vorige bestelling niet betaaldt heeft.</p>");
            unset($_SESSION['winkelmandje']);
        }else{
            print("<div class=\"productlijst\"><table>");
            print("<tr><td></td><td class=\"naam\">Naam</td><td class=\"omschrijving\"><td>Aantal</td></td><td class=\"prijs\">Prijs</td><td></td></tr>");
            foreach ($winkelmandje->getItems() as $item) {  
                print("<tr><form action=\"bestellen.php\" method=\"post\"><td><img src=\"".$item->getImage_locatie()."\"></td><td class=\"naam\">".$item->getNaam()."</td><td class=\"omschrijving\">".$item->getExtrasString()."</td><td class=\"aantal\"><input type=\"text\" name=\"aantal\"value=\"".$item->getAantal()."\"></td><td class=\"prijs\">".$item->getTotaalPrijsTekst()."</td>");
                print("<td class=\"bestellen\"><input type=\"hidden\" name=\"item\" value=\"".base64_encode(serialize($item))."\" /><button type=\"submit\" name=\"wijzigen\" title=\"Aanpassen\"class=\"button buttons\"/>Aanpassen</button><button type=\"submit\" name=\"verwijderen\" title=\"Verwijderen\"class=\"button buttons\"/>Verwijderen</button></td></form></tr>");                
            }
            print("</table></div>");
?>    
</div>  
<div class="bestel">
    <form method="post" action="pizzas.php" class="loginform flleft">        
        <button type="submit" name="" class="button bestelknop">Terug naar productoverzicht</button>
    </form>
    <form method="post" action="" class="loginform flleft">        
        <button type="submit" name="leegmaken" class="button bestelknop">Winkelmandje leegmaken</button>
    </form>
    <form method="post" action="" class="loginform bestellen flright">
        <?php if($leverzonesservice->isLeverbaar($gebruiker)){ ?>
            <input type="radio" name="levering" value="Thuislevering"> Thuislevering (<?php print($leverzonesservice->getLeverzone($gebruiker)->getPrijsTekst());?>)<br>
        <?php }else{ ?>
            <input type="radio" name="levering" Disabled value="Thuislevering"> Thuislevering (Buiten leveringszone)<br>
        <?php } ?>
        <input type="radio" name="levering" value="Afhalen" checked> Afhalen<br>
        <button type="submit" name="bestellen" class="button">Bestellen</button>
    </form>
    
</div>
<?php
    }
?>
</div>
</div>
