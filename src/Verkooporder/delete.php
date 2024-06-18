<?php
// auteur:
// functie: delete VerkoopOrder

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\VerkoopOrder;

if (isset($_GET['verkOrdId'])) {
    $verkooporder = new VerkoopOrder();
    $verkOrdId = $_GET['verkOrdId'];
    $success = $verkooporder->deleteVerkoopOrder($verkOrdId);

    if ($success) {
        echo '<script>alert("Verkooporder succesvol verwijderd."); location.replace("read.php");</script>';
    } else {
        echo '<script>alert("Fout bij het verwijderen van de verkooporder."); location.replace("read.php");</script>';
    }
} else {
    echo '<script>alert("Geen verkOrdId opgegeven."); location.replace("read.php");</script>';
}
?>