<?php
/** Mini versie van winkelmandje zichtbaar op pizzas.php **/

    print("<div class=\"mandje\"><div class=\"mandje-top\"><h2 class=\"mandje-top-titel\">Mandje</h2>");
    print("<div class=\"mandje-top-info\">".$winkelmandje->getAantalItems()." items</div></div><ul>");
    if (!$winkelmandje->isLeeg()) {
        foreach ($winkelmandje->getItems() as $item) {  
            print(" <li class=\"mandje-item\">");
                print("<span class=\"mandje-item-pic\"><img src=\"".$item->getImage_locatie()."\"></span>");            
                print($item->getNaam()." (".$item->getAantal().")<span class=\"mandje-item-desc\">".$item->getExtrasString()."</span><span class=\"mandje-item-price\">".$item->getTotaalPrijsTekst()."</span>");
                
                print("</li>");
        }
    }    
    print("<div class=\"mandje-bottom\">Totaal: ".$winkelmandje->getTotaalPrijsTekst()."<a href=\"bestellen.php\" class=\"mandje-button\">Bestellen</a></div></div>");  
?>
</div>