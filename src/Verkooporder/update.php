<?php
// Auteur: 
// Functie: Update verkooporder
 
// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\Database;
use Bas\classes\Verkooporder;
use Bas\classes\Klant;
 
// Verbind met de database
$database = new Database();
$conn = $database->getConnection();
 
$verkooporder = new Verkooporder();
$verkooporder->setConnection($conn); // Zorg ervoor dat de verbinding wordt ingesteld
 
$klant = new Klant();
$klant->setConnection($conn); // Zorg ervoor dat de verbinding wordt ingesteld
 
// Controleer of het formulier is ingediend en of de update-knop is ingedrukt
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["update"]) && isset($_POST["verkOrdId"])) {
    // Haal de verkOrdId op uit het formulier
    $verkOrdId = (int)$_POST["verkOrdId"];
 
    // Verzamel de nieuwe gegevens van de verkooporder
    $orderData = [
        'klantId' => $_POST['klantId'],
        'artId' => $_POST['artId'],
        'verkOrdDatum' => $_POST['verkOrdDatum'],
        'verkOrdBestAantal' => $_POST['verkOrdBestAantal'],
        'verkOrdStatus' => $_POST['verkOrdStatus']
    ];
 
    // Verzamel de nieuwe gegevens van de klant
    $klantData = [
        'klantNaam' => $_POST['klantNaam'],
        'klantEmail' => $_POST['klantEmail'],
        'klantWoonplaats' => $_POST['klantWoonplaats'],
        'klantAdres' => $_POST['klantAdres'],
        'klantPostcode' => $_POST['klantPostcode']
    ];
 
    // Update de verkooporder met behulp van de updateVerkooporder-methode
    $updateOrderSuccess = $verkooporder->updateVerkooporder($verkOrdId, $orderData);
    // Update de klantgegevens met behulp van de updateKlant-methode
    $updateKlantSuccess = $klant->updateKlant($orderData['klantId'], $klantData);
 
    if ($updateOrderSuccess && $updateKlantSuccess) {
        // Geef een succesmelding weer als de update succesvol is
        echo '<script>alert("Verkooporder en klantgegevens succesvol bijgewerkt")</script>';
    } else {
        // Geef een foutmelding weer als er een probleem was met het bijwerken
        echo '<script>alert("Er is een fout opgetreden bij het bijwerken van de verkooporder of klantgegevens")</script>';
    }
 
    // Stuur de gebruiker terug naar de Verkooporder Overzicht pagina
    echo "<script> location.replace('readVerkooporder.php'); </script>";
    exit;
}
 
// Voeg een formulier toe om de verkooporder bij te werken
if (isset($_GET["verkOrdId"])) {
    $verkOrdId = (int)$_GET["verkOrdId"];
    $orderData = $verkooporder->getVerkoopOrder($verkOrdId);
 
    if ($orderData) {
        $klantData = $klant->getKlant($orderData['klantId']);
        echo '<form method="post">';
        echo '<input type="hidden" name="verkOrdId" value="' . htmlspecialchars($verkOrdId) . '">';
        echo 'Klant ID: <input type="text" name="klantId" value="' . htmlspecialchars($orderData['klantId']) . '" readonly><br>';
        echo 'Klant Naam: <input type="text" name="klantNaam" value="' . htmlspecialchars($klantData['klantNaam']) . '"><br>';
        echo 'Klant Email: <input type="email" name="klantEmail" value="' . htmlspecialchars($klantData['klantEmail']) . '"><br>';
        echo 'Klant Woonplaats: <input type="text" name="klantWoonplaats" value="' . htmlspecialchars($klantData['klantWoonplaats']) . '"><br>';
        echo 'Klant Adres: <input type="text" name="klantAdres" value="' . htmlspecialchars($klantData['klantAdres']) . '"><br>';
        echo 'Klant Postcode: <input type="text" name="klantPostcode" value="' . htmlspecialchars($klantData['klantPostcode']) . '"><br>';
        echo 'Artikel ID: <input type="text" name="artId" value="' . htmlspecialchars($orderData['artId']) . '"><br>';
        echo 'Datum: <input type="date" name="verkOrdDatum" value="' . htmlspecialchars($orderData['verkOrdDatum']) . '"><br>';
        echo 'Aantal: <input type="number" name="verkOrdBestAantal" value="' . htmlspecialchars($orderData['verkOrdBestAantal']) . '"><br>';
        echo 'Status: <input type="text" name="verkOrdStatus" value="' . htmlspecialchars($orderData['verkOrdStatus']) . '"><br>';
        echo '<button type="submit" name="update">Bijwerken</button>';
        echo '</form>';
    } else {
        echo "<p>Verkooporder niet gevonden.</p>";
    }
} else {
    echo "<p>Geen verkooporder ID opgegeven.</p>";
}
?>
