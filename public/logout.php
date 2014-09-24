<?php
/** Uitloggen **/
/* sessies worden verwijderd*/

require '../src/config/init.php';
$general->logged_out_protect();
session_start();
session_destroy();
header('Location:index.php');
?>
