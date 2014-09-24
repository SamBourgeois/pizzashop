<?php
require_once("../src/entities/artikel.php");

$lijnen = $bestelservice->getBestelLijnen($_POST['id']);
?>
<?php
print("<div class=\"container\"><div class=\"tekst\">");
print("<h1>Bestelling details</h1>");
print("<div class=\"leveringsadres\"><h2>Te leveren aan</h2><div class=\"adres\">");
$klant = $bestelservice->getGebruiker($_POST['id']);
print("<p>".$klant->getVoornaam()." ".$klant->getAchternaam()."</p>");
print("<p>".$klant->getAdres()."</p>");
print("<p>".$klant->getPostcode()." ".$klant->getGemeente()."</p>");
print("</div></div>");
print("<div class=\"productlijst details\">");
print("<table>");
print("<tr><td></td><td>Naam</td><td>Extras</td><td class=\"aantal\">Aantal</td><td class=\"aantal\">Prijs</td></tr>");
$totaalprijs = 0;
foreach ($lijnen as $lijn){   
    $item = $productenservice->getProduct($lijn['artikelnummer']);
    $item->setAantal($lijn['aantal']);
    $item->setPrijs($lijn['prijs']);
    print("<tr><form action=\"bestellen.php\" method=\"post\"><td><img src=\"".$item->getImage_locatie()."\"></td><td class=\"naam\">".$item->getNaam()."</td><td class=\"omschrijving\">");
    $extras = array();
    $extrasid = $bestelservice->getExtras($lijn['bestellijnid']);
    foreach ($extrasid as $extraid){
        $extra = $productenservice->getProduct($extraid[0]);
        array_push($extras, $extra->getNaam());
    }
    print("<p>" . implode(', ', $extras). "</p>");
    print("</td><td class=\"aantal\"><input type=\"text\" disabled name=\"aantal\"value=\"".$item->getAantal()."\"></td><td class=\"aantal\"><input type=\"text\" disabled name=\"aantal\"value=\"€ ".$item->getPrijs()."\"></td></form></tr>");   
    $totaalprijs += $item->getPrijs();
}
print("</table>");
print("<div class=\"totaal\"><h3>Totaal: € ". number_format($totaalprijs, 2, '.', '') ."</h3></div>");
print("<form method=\"post\" action=\"\"class=\"loginform flright\"><button type=\"submit\" name=\"terug\" title=\"Terug\"class=\"largebutton\"/>Terug naar overzicht</button></form></div>");
print("</div>");

?>