<div class="container">
    <div class="tekst">
        <h1>Extras overzicht</h1>
        <div class="productlijst">
            <table>
                <tr>
                    <td></td>
                    <td>Naam</td>
                    <td></td>
                    <td>Prijs</td>
                    <td>Korting</td>
                    <td></td>
                </tr>
                <?php foreach ($extras as $extra){ ?>
                <tr>
                    <td><img src="<?php print($extra->getImage_locatie());?>"></td>
                    <td class="naam"><?php print($extra->getNaam());?></td>
                    <td class="omschrijving"><?php print($extra->getOmschrijving());?></td>
                    <td class="prijs"><?php print($extra->getPrijsTekst());?></td>
                    <td class="korting prijs"><?php print($extra->getKortingTekst());?></td>
                    <td class="bestellen">
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?php print($extra->getId());?>" />
                            <button type="submit" name="aanpassen" title="aanpassen" class="button"/>&#187;</button>
                        </form>
                    </td>
                </tr>        
                <?php } ?>
            </table>
            <form method="post" action="" class="loginform bestellen flright">
                <input type="hidden" name="cat" value="3" />
                <button type="submit" name="nieuw" title="Nieuw" class="button"/>Nieuwe extra</button>
            </form>
        </div>
    </div>
