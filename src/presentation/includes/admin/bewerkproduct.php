<div class="container">    
    <div class="tekst profiel"> 
        <h2>Bewerk product</h2>
        <form action="" method="post" class="loginform" enctype="multipart/form-data">
            <p>
                <label for="naam">Productnaam:</label>
                <input type="text" name="naam" value="<?php print($artikel->getNaam()); ?>"/>  
            </p><p>
                <label for="omschrijving">Omschrijving:</label>       
                <input type="text" name="omschrijving" value="<?php print($artikel->getOmschrijving()); ?>"/>
            </p><p>
                <label for="prijs">Prijs:</label>       
                <input type="text" name="prijs" value="<?php print($artikel->getPrijs()); ?>"/>
            </p><p>
                <label for="korting">Korting:</label>         
                <input type="text" name="korting" value="<?php print($artikel->getKorting()); ?>"/>
            </p><p>
            </p><p>
                <?php
                if(!empty($artikel->getImage_locatie())){
                    $artikel->getImage_locatie();
                    echo "<img class=\"preview\" src='".$artikel->getImage_locatie()."'>";
                }
                ?>
            </p><p> 
                <label for="myfile">Afbeelding:</label> 
                <input type="file" name="myfile"/>
            </p><p>   
                <input type="hidden" name="id" value="<?php print($artikel->getId()); ?>" />
                <input type="hidden" name="cat" value="<?php print($artikel->getCat()); ?>" />
            </p><p>
                <button type="submit" name="aanpassen2" class="button"/>Aanpassen</button>
                <button type="submit" name="largeverwijderen" class="button"/>Verwijderen</button>
            </p>            
        </form>        
    </div>
</div>