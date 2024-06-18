<?php
// Include de benodigde klassen
include_once __DIR__ . '/../classes/Database.php';
include_once __DIR__ . '/../classes/Klant.php';

if (isset($_GET['klantId'])) {
    $klantId = $_GET['klantId'];

    // Maak verbinding met de database
    $db = new \Bas\classes\Database();
    $conn = $db->getConnection();

    // Maak een nieuw Klant object en stel de verbinding in
    $klant = new \Bas\classes\Klant();
    $klant->setConnection($conn);

    // Verwijder de klant
    if ($klant->deleteKlant((int)$klantId)) {
        echo "Klant succesvol verwijderd.";
    } else {
        echo "Er is een fout opgetreden bij het verwijderen van de klant.";
    }
}
?>
