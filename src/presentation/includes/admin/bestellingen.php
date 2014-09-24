<div class="container">
    <div class="tekst">
        <h1>Bestellingen overzicht</h1>
        <div class="filter">
            <form action="" method="post" class="">
                <select name="filternaam" class="select">
                    <option value="n">Geen filter</option>
                    <?php foreach($gebruikersnamen as $naam){ ?>
                        <option value="<?php print($naam->getId());?>"><?php print($naam->getGebruikersnaam());?></option>
                    <?php } ?>
                </select>                
                <button type="submit" name="filter" title="Filter"class="largebutton"/>Filter</button>
                <div class="openbestellingen">
                    <input type="checkbox" value="1" id="openbestellingen" name="open" />
                    <label for="openbestellingen"></label>
                    <div class="openlabel">Enkel open bestellingen</div>
                </div>
            </form>
        </div>
        <div class="productlijst besteloverzicht">
            <table>
                <tr>
                    <td>Gebruikersnaam</td>
                    <td>Datum</td>
                    <td>Leverwijze</td>
                    <td>Totaalprijs</td>
                    <td class="status">Status</td>
                    <td></td>
                </tr>
                <?php foreach ($bestellingen as $bestelling){ ?>
                <tr>
                    <td><?php print($bestelling->getGebruikersnaam());?></td>
                    <td><?php print($bestelling->getDatum());?></td>
                    <td><?php print($bestelling->getLeverwijzeTekst());?></td>
                    <td><?php print($bestelling->getTotaalprijs());?></td>
                    <td>
                        <form action="" method="post">
                            <select name="status" class="select">
                                <option value="0" <?php if($bestelling->getStatus() == "0"){ print("selected"); } ?>>Te maken</option>
                                <option value="1" <?php if($bestelling->getStatus() == "1"){ print("selected"); } ?>>Bestelling klaar</option>
                                <option value="2" <?php if($bestelling->getStatus() == "2"){ print("selected"); } ?>>Bestelling onderweg</option>
                                <option value="3" <?php if($bestelling->getStatus() == "3"){ print("selected"); } ?>>Bestelling ontvangen</option>    
                            </select>
                        </td>
                        <td class="bestellen">
                            <input type="hidden" name="id" value="<?php print($bestelling->getId());?>" />
                            <button type="submit" name="aanpassen" title="Aanpassen"class="button buttons"/>aanpassen</button>
                            <button type="submit" name="details" title="Details"class="button buttons"/>Details</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
            </table>
        </div>
    </div>