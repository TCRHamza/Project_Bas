<?php
// auteur: Hmidoush
// functie: insert class Artikel

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\Artikel;
use Bas\classes\Database;

$db = new Database();
$db->getConnection();

// Maak een nieuw artikel aan
$artikel = new Artikel();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert'])) {
    $data = [
        'artOmschrijving' => $_POST['artOmschrijving'],
        'artInkoop' => $_POST['artInkoop'],
        'artVerkoop' => $_POST['artVerkoop'],
        'artMinVoorraad' => $_POST['artMinVoorraad'],
        'artMaxVoorraad' => $_POST['artMaxVoorraad'],
        'artLocatie' => $_POST['artLocatie']
    ];
    
    if ($artikel->insertArtikel($data)) {
        echo "Artikel succesvol toegevoegd!";
    } else {
        echo "Er is een fout opgetreden bij het toevoegen van het artikel.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>CRUD Artikel</title>
    <link rel="stylesheet" href="css.css">
</head>
<body class="formbody">
        <form class="crudform" method="post">
        <h1>Artikel Toevoegen</h1>
            <label for="omschrijving">Artikel omschrijving:</label>
            <input type="text" id="omschrijving" name="artOmschrijving" placeholder="Artikelomschrijving" required/>
            
            <label for="inkoop">Inkoopprijs:</label>
            <input type="text" id="inkoop" name="artInkoop" placeholder="Inkoopprijs" required/>
            
            <label for="verkoop">Verkoopprijs:</label>
            <input type="text" id="verkoop" name="artVerkoop" placeholder="Verkoopprijs" required/>
            
            <label for="minVoorraad">Minimum voorraad:</label>
            <input type="text" id="minVoorraad" name="artMinVoorraad" placeholder="Minimum voorraad" required/>
            
            <label for="maxVoorraad">Maximum voorraad:</label>
            <input type="text" id="maxVoorraad" name="artMaxVoorraad" placeholder="Maximum voorraad" required/>
            
            <label for="locatie">LocatieNr.:</label>
            <input type="text" id="locatie" name="artLocatie" placeholder="Locatie" required/>
            
            <input type='submit' name='insert' value='Toevoegen'>
            <a href='read.php' class='back-link'>Terug</a>
        </form>
        
</body>
</html>