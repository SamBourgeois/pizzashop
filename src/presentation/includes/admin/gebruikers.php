<div class="container">
    <div class="tekst">
        <h1>Gebruikers overzicht</h1>
        <div class="productlijst besteloverzicht">
            <table>
                <tr>
                    <td>Gebruikersnaam</td>
                    <td>Emailadres</td>
                    <td>Datum</td>
                    <td>Status</td>
                    <td></td>
                </tr>
            <?php foreach ($gebruikers as $gebruiker){ ?>
                <tr>
                    <td><?php print($gebruiker->getGebruikersnaam());?></td>
                    <td><?php print($gebruiker->getEmailadres());?></td>
                    <td><?php print($gebruiker->getDatum());?></td>
                    <td class="status">
                        <form action="" method="post">
                            <select name="status" class="select">
                                <option value="0" <?php if($gebruiker->getStatus() == "0"){ print("selected"); } ?>>Actief</option>
                                <option value="1" <?php if($gebruiker->getStatus() == "1"){ print("selected"); } ?>>Inactief</option>
                                <option value="2" <?php if($gebruiker->getStatus() == "2"){ print("selected"); } ?>>Admin</option>  
                            </select>
                        </td>
                        <td class="bestellen">
                            <input type="hidden" name="id" value="<?php print($gebruiker->getId());?>" />
                            <button type="submit" name="aanpassen" title="Aanpassen" class="button buttons"/>aanpassen</button>
                            <button type="submit" name="verwijderen" title="Verwijderen" class="button buttons"/>Verwijderen</button>
                        </form>
                    </td>
                </tr>        
                <?php } ?>
            </table>
        </div>
    </div>