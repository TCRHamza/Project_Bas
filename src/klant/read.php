<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Klant</title>
    <link rel="stylesheet" href="../css.css">
</head>
<body>
    <h1>CRUD Klant</h1>
    <nav>
        <a href='../index.html'>Home</a><br>
        <a href='insert.php'>Toevoegen nieuwe klant</a><br><br>
    </nav>
    
    <form method="post" class="searchbar">
        <label for="klantNaam">Zoek op klantnaam:</label>
        <input type="text" name="klantNaam" id="klantNaam" required>
        <input type="submit" name="search" value="Zoeken">
    </form>

    <?php
    // Autoloader classes via composer
    require '../../vendor/autoload.php';

    use Bas\classes\Klant;

    // Maak een object Klant
    $klant = new Klant();

    // Start CRUD
    if (isset($_POST['search'])) {
        $klantNaam = $_POST['klantNaam'];
        $lijst = $klant->searchKlanten($klantNaam);
        $klant->showTable($lijst);
    } else {
        $klant->crudKlant();
    }
    ?>
</body>
</html>
