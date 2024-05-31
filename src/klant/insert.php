<?php
// auteur: Hmidoush
// functie: insert class Klant

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\Klant;

if (isset($_POST["insert"]) && $_POST["insert"] == "Toevoegen") {
    // Code insert klant
    // Maak een nieuw Klant object
    $klant = new Klant();

    // Haal de gegevens uit het formulier
    $klantnaam = $_POST['klantnaam'];
    $klantemail = $_POST['klantemail'];
    $klantwoonplaats = $_POST['klantwoonplaats'];
    $klantadres = $_POST['klantadres'];
    $klantpostcode = $_POST['klantpostcode'];

    // Maak een array met de klantgegevens
    $data = [
        'klantNaam' => $klantnaam,
        'klantEmail' => $klantemail,
        'klantWoonplaats' => $klantwoonplaats,
        'klantAdres' => $klantadres,
        'klantPostcode' => $klantpostcode
    ];

    // Voeg de klant toe aan de database
    $result = $klant->insertKlant($data);

    if ($result) {
        echo "Klant succesvol toegevoegd met ID: $result";
    } else {
        echo "Er is een fout opgetreden bij het toevoegen van de klant.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <h1>CRUD Klant</h1>
    <h2>Toevoegen</h2>
    <form method="post">
        <label for="nv">Klantnaam:</label>
        <input type="text" id="nv" name="klantnaam" placeholder="Klantnaam" required/>
        <br>   
        <label for="an">Klantemail:</label>
        <input type="text" id="an" name="klantemail" placeholder="Klantemail" required/>
        <br>   
        <label for="wp">Klantwoonplaats:</label>
        <input type="text" id="wp" name="klantwoonplaats" placeholder="Klantwoonplaats" required/>
        <br>
        <label for="ka">Klantadres:</label>
        <input type="text" id="ka" name="klantadres" placeholder="Klantadres" required/>
        <br>
        <label for="kp">Klantpostcode:</label>
        <input type="text" id="kp" name="klantpostcode" placeholder="Klantpostcode" required/>
        <br><br>
        <input type='submit' name='insert' value='Toevoegen'>
    </form></br>

    <a href='read.php'>Terug</a>

</body>
</html>
