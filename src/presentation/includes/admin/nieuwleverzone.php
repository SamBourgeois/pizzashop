<div class="container">    
    <div class="tekst profiel"> 
        <h2>Nieuw leverzone</h2>
        <form action="" method="post" class="loginform">
            <p>
                <label for="postcode">Postcode:</label>
                <input type="text" name="postcode" value="<?php print($leverzone->getPostcode()); ?>"/>  
            </p><p>
                <label for="gemeente">Gemeente:</label>       
                <input type="text" name="gemeente" value="<?php print($leverzone->getGemeente()); ?>"/>
            </p><p>
                <label for="prijs">Prijs:</label>       
                <input type="text" name="prijs" value="<?php print($leverzone->getPrijs()); ?>"/>
            </p><p>
                <button type="submit" name="toevoegen" class="button"/>Toevoegen</button>
            </p>            
        </form>        
    </div>
</div>