<?php
/** Overzicht van gastenboek, zichtbaar op index.php **/
?>
<div class="gastenboek"><h2>Gastenboek:</h2>
<?php foreach($lijst as $bericht){ ?>
    <div class="bericht">
        <h3 class="berichtTitel"><?php print($bericht->getTitel());?></h3>
        <p><b><?php print($bericht->getGebruiker());?></b> <?php print($bericht->getBoodschap());?></p>
        <?php if($general->is_admin()){ ?>
            <form method="post" action ="">
                <input type="hidden" name="id" value=" <?php print($bericht->getId());?>"/><button type="submit" name="delete" title="Verwijderen"class="button"/>X</button>
            </form>
        <?php } ?>
    </div>
<?php 
}
if($general->logged_in()){
?>
    <div class="bericht">
        <form  action="" method="post"> 
            <p>
                <label for="titel">Titel:</label>
                <input type="text" name="titel" id="txttitel">
            </p><p>
                <label for="boodschap">Boodschap:</label>
                <input type="text" name="boodschap" id="txtboodschap">
            </p>
            <input type="submit" name="new" title="Verzenden" value="&#187;">
        </form> 
    </div>
    <?php
}
print("</div>");
?>
