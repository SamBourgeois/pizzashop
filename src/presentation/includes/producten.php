<?php
/** Overzicht van producten, zichtbaar op pizzas.php**/

print("<div class=\"container\"><div class=\"tekst producten\"><img class=\"productenImg\" src=\"images/pizza2.png\">");
foreach ($categorieen as $categorie){
    print("<div class=\"productlijst\"><h2>".$categorie->getOmschrijving()."</h2>");
    print("<table>");
    print("<tr><td></td><td class=\"naam\">Naam</td><td class=\"omschrijving\">Omschrijving</td><td class=\"prijs\">Prijs</td><td class=\"prijs\">Korting</td><td></td></tr>");
    $artikels = $productenservice->getProductenPerCat($categorie->getId());
    foreach ($artikels as $artikel){ 
        /* Overzicht van producten */
        print("<tr><td><img src=\"".$artikel->getImage_locatie()."\"></td><td class=\"naam\">".$artikel->getNaam()."</td><td class=\"omschrijving\">".$artikel->getOmschrijving()."</td><td class=\"prijs\">".$artikel->getPrijsTekst()."</td><td class=\"korting prijs\">".$artikel->getKortingTekst()."</td>");
        print("<td class=\"bestellen\"><form action=\"pizzas.php#".$artikel->getId()."\" method=\"post\"><input type=\"hidden\" name=\"cat\" value=\"".$artikel->getCat()."\" /><input type=\"hidden\" name=\"id\" value=\"".$artikel->getId()."\" /><button type=\"submit\" name=\"submit\" title=\"Bestellen\"class=\"button\"/>&#187;</button></form></td></tr>");
        if(isset($_POST['cat']) && isset($_POST['id'])){
            
            /* Als men een pizza wil bestellen een overzicht van de extras geven*/
            if($_POST['cat'] == "2" && $_POST['id']== $artikel->getId()){
                print("<tr class=\"extra\"><td colspan=\"6\"><a name=\"".$_POST['id']."\"></a><ul>");
                $extras = $productenservice->getExtras();
                print("<form action=\"\" method=\"post\"><div>");
                foreach ($extras as $extra){                    
                    print("<input type=\"checkbox\" name=\"checkbox[]\" value=\"".$extra->getId()."\">".$extra->getNaam()."(".$extra->getPrijsTekst().")<br>");                    
                }
                print("<input type=\"hidden\" name=\"cat\" value=\"0\" /><input type=\"hidden\" name=\"id\" value=\"".$artikel->getId()."\" />");
                print("<button type=\"submit\" name=\"submit\" title=\"Bestellen\"class=\"button\"/>Bestellen</button>");
                print("</div></form>");
                print("</ul></td></tr>");
            }
        }
    }
    print("</table></div>");
}
print("</div>");

?>