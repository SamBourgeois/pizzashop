<?php
require_once("../src/entities/artikel.php");
require_once("../src/entities/categorie.php");
$categorieen = $productenservice->getCategorieen();
?>
<?php
print("<div class=\"container\"><div class=\"tekst\">");
print("<h1>Producten overzicht</h1>");
foreach ($categorieen as $categorie){
    print("<div class=\"productlijst\"><h2>".$categorie->getOmschrijving()."</h2>");
    print("<table>");
    print("<tr><td></td><td class=\"naam\">Naam</td><td class=\"omschrijving\">Omschrijving</td><td class=\"prijs\">Prijs</td><td class=\"prijs\">Korting</td><td></td></tr>");
    $artikels = $productenservice->getProductenPerCat($categorie->getId());
    foreach ($artikels as $artikel){ 
        
        print("<tr><td><img src=\"".$artikel->getImage_locatie()."\"></td><td class=\"naam\">".$artikel->getNaam()."</td><td class=\"omschrijving\">".$artikel->getOmschrijving()."</td><td class=\"prijs\">".$artikel->getPrijsTekst()."</td><td class=\"korting prijs\">".$artikel->getKortingTekst()."</td>");
        print("<td class=\"bestellen\"><form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id\" value=\"".$artikel->getId()."\" /><button type=\"submit\" name=\"aanpassen\" title=\"Aanpassen\"class=\"button\"/>&#187;</button></form></td></tr>");        
    }
    print("</table><form method=\"post\" action=\"\"class=\"loginform bestellen flright\"><input type=\"hidden\" name=\"cat\" value=\"".$categorie->getId()."\" /><button type=\"submit\" name=\"nieuw\" title=\"Nieuw\"class=\"button\"/>Nieuwe ".$categorie->getOmschrijving()."</button></form></div>");
}
print("</div>");

?>