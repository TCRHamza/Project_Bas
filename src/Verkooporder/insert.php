<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwe Verkooporder Plaatsen</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1>Nieuwe Verkooporder Plaatsen</h1>
    <nav>
        <a href='../index.html'>Home</a><br>
        <a href='read.php'>Verkooporder Overzicht</a><br><br>
    </nav>
    <?php
    require '../../vendor/autoload.php';
    use Bas\classes\Verkooporder;
    use Bas\classes\Klant;
    use Bas\classes\Artikel;

    $verkooporder = new Verkooporder();
    $klant = new Klant();
    $artikel = new Artikel();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $klantId = $_POST['klantId'];
        $artId = $_POST['artId'];
        $verkOrdDatum = $_POST['verkOrdDatum'];
        $verkOrdBestAantal = $_POST['verkOrdBestAantal'];
        $verkOrdStatus = $_POST['verkOrdStatus'];

        // Sanitize and validate input data if needed
        $result = $verkooporder->insertVerkooporder($klantId, $artId, $verkOrdDatum, $verkOrdBestAantal, $verkOrdStatus);
        if ($result) {
            echo "<p>Nieuwe verkooporder succesvol geplaatst!</p>";
        } else {
            echo "<p>Er is een fout opgetreden bij het plaatsen van de verkooporder.</p>";
        }
    }

    // Fetching klanten and artikelen with error handling
    try {
        $klanten = $klant->getKlanten();
        $artikelen = $artikel->getArtikelen();
    } catch (Exception $e) {
        echo "<p>Fout bij het ophalen van gegevens: " . $e->getMessage() . "</p>";
        exit;
    }
    ?>
    <form method="post">
        <label for="klantId">Klant:</label>
        <select name="klantId" required>
            <?php foreach ($klanten as $kl) { ?>
                <option value="<?php echo htmlspecialchars($kl['klantId']); ?>"><?php echo htmlspecialchars($kl['klantNaam']); ?></option>
            <?php } ?>
        </select><br>
        <label for="artId">Artikel:</label>
        <select name="artId" required>
            <?php foreach ($artikelen as $art) { ?>
                <option value="<?php echo htmlspecialchars($art['artId']); ?>"><?php echo htmlspecialchars($art['artOmschrijving']); ?></option>
            <?php } ?>
        </select><br>
        <label for="verkOrdDatum">Order Datum:</label>
        <input type="date" name="verkOrdDatum" required><br>
        <label for="verkOrdBestAantal">Besteld Aantal:</label>
        <input type="number" name="verkOrdBestAantal" required><br>
        <label for="verkOrdStatus">Order Status:</label>
        <input type="text" name="verkOrdStatus" required><br>
        <input type="submit" name="submit" value="Plaatsen">
    </form>
</body>
</html>
