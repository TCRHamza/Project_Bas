<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klant Zoeken op </title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
   
     
    <form method="post">
        <label for="klantId">klantnaam:</label>
        <input type="number" name="klantId" required>
        <input type="submit" name="submit" value="Zoeken">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $klantId = $_POST['klantId'];

        try {
            // Maak een nieuwe PDO-verbinding
            $dsn = 'mysql:host=localhost;dbname=bas';
            $username = 'root'; // vervang met je database gebruikersnaam
            $password = '';     // vervang met je database wachtwoord
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            $pdo = new PDO($dsn, $username, $password, $options);

            // Zoek de klant op basis van klantId
            $sql = 'SELECT * FROM Klant WHERE klantId = :klantId';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':klantId', $klantId, PDO::PARAM_INT);
            $stmt->execute();
            $klantGegevens = $stmt->fetch();

            if ($klantGegevens) {
                echo "<h2>Klant Gegevens:</h2>";
               
                echo "<p>Klant Naam: " . htmlspecialchars($klantGegevens['klantNaam']) . "</p>";
                echo "<p>Klant Email: " . htmlspecialchars($klantGegevens['klantEmail']) . "</p>";
                echo "<p>Klant Woonplaats: " . htmlspecialchars($klantGegevens['klantWoonplaats']) . "</p>";
                echo "<p>Klant Adres: " . htmlspecialchars($klantGegevens['klantAdres']) . "</p>";
                echo "<p>Klant Postcode: " . htmlspecialchars($klantGegevens['klantPostcode']) . "</p>";
            } else {
                echo "<p>Geen klant gevonden met ID $klantId.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Fout bij het verbinden met de database: " . $e->getMessage() . "</p>";
        } catch (Exception $e) {
            echo "<p>Er is een fout opgetreden: " . $e->getMessage() . "</p>";
        }
    }
    ?>
</body>
</html>
