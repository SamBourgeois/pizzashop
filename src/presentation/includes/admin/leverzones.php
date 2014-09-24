<div class="container"><div class="tekst">
    <h1>Leverzones overzicht</h1>
    <div class="productlijst">
        <table>
            <tr><td>Postcode</td>
                <td>Gemeente</td>
                <td>Prijs</td>
                <td></td>
            </tr>
        <?php foreach ($leverzones as $leverzone){?>   
            <tr>
                <td><?php print($leverzone->getPostcode());?></td>
                <td><?php print($leverzone->getGemeente());?></td>
                <td><?php print($leverzone->getPrijs());?></td>
                <td class="bestellen">
                    <form action="" method="post">
                        <input type="hidden" name="postcode" value="<?php print($leverzone->getPostcode());?>" />
                        <button type="submit" name="aanpassen" title="Aanpassen" class="button"/>&#187;</button>
                    </form>
                </td>
            </tr>      
        <?php } ?>
        </table>
        <form method="post" action="" class="loginform bestellen flright">
            <button type="submit" name="nieuw" title="Nieuw"class="button"/>Nieuwe Leverzone</button>
        </form>
    </div>
</div>