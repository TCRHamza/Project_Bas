<?php
// Auteur: Hmidoush
// Functie: definitie van de Verkooporder class
namespace Bas\classes;
 
use PDO;
use PDOException;
 
include_once "functions.php";
 
class Verkooporder extends Database {
    public $orderId;
    public $orderDatum;
    public $artikelNaam; // Gewijzigd om artikelnamen op te slaan in plaats van artikel-IDs
    public $orderStatus;
    public $orderTotaal;
    private $table_name = "verkooporder"; // Ensure table name matches your database
 
    // Methoden
   
    /**
     * Haal alle verkooporders op en toon ze in een tabel
     * @return void
     */
    public function crudVerkooporder() : void {
        // Haal alle verkooporders op uit de database mbv de method getVerkooporders()
        $lijst = $this->getVerkooporders();
 
        // Toon een HTML-tabel van de lijst  
        $this->showTable($lijst);
    }
 
    /**
     * Haal alle verkooporders op uit de database
     * @return array
     */
    public function getVerkooporders() : array {
        try {
            // Voer een query uit om verkooporders op te halen, waarbij artikelnamen en klantnamen worden opgehaald
            $sql = "SELECT v.*, a.artOmschrijving AS artNaam, k.klantNaam
                    FROM $this->table_name v
                    INNER JOIN artikel a ON v.artId = a.artId
                    INNER JOIN klant k ON v.klantId = k.klantId";
            $stmt = self::$conn->query($sql);
            $lijst = $stmt->fetchAll(PDO::FETCH_ASSOC);
           
            return $lijst;
        } catch (PDOException $e) {
            echo "Fout: " . $e->getMessage();
            return [];
        }
    }
 
    /**
     * Toon de verkooporders in een HTML-tabel
     * @param array $lijst
     * @return void
     */
    public function showTable(array $lijst) : void {
        if (empty($lijst)) {
            echo "<p>Geen gegevens beschikbaar.</p>";
            return;
        }
 
        $txt = "<table border='1'>";
 
        // Voeg de kolomnamen boven de tabel
        $txt .= "<thead><tr>";
        $txt .= "<th>klantNaam</th>";
        $txt .= "<th>artNaam</th>";
        $txt .= "<th>verkOrdDatum</th>";
        $txt .= "<th>verkOrdBestAantal</th>";
        $txt .= "<th>verkOrdStatus</th>";
        $txt .= "<th></th><th></th>";
        $txt .= "</tr></thead>";
 
        $txt .= "<tbody>";
        foreach($lijst as $row){
            $txt .= "<tr>";
            $txt .=  "<td>" . htmlspecialchars($row["klantNaam"] ?? '') . "</td>";
            $txt .=  "<td>" . htmlspecialchars($row["artNaam"] ?? '') . "</td>"; // Weergeven van artikelnaam
            $txt .=  "<td>" . htmlspecialchars($row["verkOrdDatum"] ?? '') . "</td>";
            $txt .=  "<td>" . htmlspecialchars($row["verkOrdBestAantal"] ?? '') . "</td>";
            $txt .=  "<td>" . htmlspecialchars($row["verkOrdStatus"] ?? '') . "</td>";
           
            // Update
            // Wijzig knopje
            $txt .=  "<td>";
            $txt .= "
            <form method='post' action='update.php?orderId=" . htmlspecialchars($row["orderId"] ?? '') . "' >      
                <button name='update'>Wzg</button>    
            </form> </td>";
 
            // Verwijderen
            $txt .=  "<td>";
            $txt .= "
            <form method='post' action='delete.php?orderId=" . htmlspecialchars($row["orderId"] ?? '') . "' >      
                <button name='verwijderen'>Verwijderen</button>    
            </form> </td>";
            $txt .= "</tr>";
        }
        $txt .= "</tbody>";
        $txt .= "</table>";
        echo $txt;
    }
 
    /**
     * Voeg een nieuwe verkooporder toe
     * @param int $klantId
     * @param int $artId
     * @param string $verkOrdDatum
     * @param int $verkOrdBestAantal
     * @param string $verkOrdStatus
     * @return bool
     */
    public function insertVerkooporder($klantId, $artId, $verkOrdDatum, $verkOrdBestAantal, $verkOrdStatus) {
        try {
            $sql = "INSERT INTO $this->table_name (klantId, artId, verkOrdDatum, verkOrdBestAantal, verkOrdStatus)
                    VALUES (:klantId, :artId, :verkOrdDatum, :verkOrdBestAantal, :verkOrdStatus)";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':klantId', $klantId);
            $stmt->bindParam(':artId', $artId);
            $stmt->bindParam(':verkOrdDatum', $verkOrdDatum);
            $stmt->bindParam(':verkOrdBestAantal', $verkOrdBestAantal);
            $stmt->bindParam(':verkOrdStatus', $verkOrdStatus);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Fout: " . $e->getMessage();
            return false;
        }
    }
 
    /**
     * Bepaal uniek orderId
     * @return int
     */
    private function BepMaxOrderId() : int {
        // Bepaal uniek nummer
        $sql = "SELECT MAX(orderId)+1 FROM $this->table_name";
        return (int) self::$conn->query($sql)->fetchColumn();
    }
   
    /**
     * Voeg een nieuwe verkooporder toe aan de database
     * @param array $row Array met verkoopordergegevens
     * @return bool True als het invoegen succesvol is, anders False
     */
    public function insertVerkooporderWithRow(array $row) : bool {
        try {
            // Begin een transactie
            self::$conn->beginTransaction();
 
            // Bepaal een unieke orderId
            $orderId = $this->BepMaxOrderId();
           
            // SQL-query voor het invoegen van een nieuwe verkooporder
            $sql = "INSERT INTO $this->table_name (orderId, orderDatum, klantId, orderStatus, orderTotaal)
                    VALUES (:orderId, :orderDatum, :klantId, :orderStatus, :orderTotaal)";
           
            // Bereid de query voor
            $stmt = self::$conn->prepare($sql);
           
            // Bind de parameters
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            $stmt->bindParam(':orderDatum', $row['orderDatum'], PDO::PARAM_STR);
            $stmt->bindParam(':klantId', $row['klantId'], PDO::PARAM_INT);
            $stmt->bindParam(':orderStatus', $row['orderStatus'], PDO::PARAM_STR);
            $stmt->bindParam(':orderTotaal', $row['orderTotaal'], PDO::PARAM_STR);
           
            // Voer de query uit
            $stmt->execute();
 
            // Commit de transactie
            self::$conn->commit();
 
            return true; // Succesvol ingevoegd
        } catch(PDOException $e) {
            // Rol de transactie terug bij een fout
            self::$conn->rollBack();
            echo "Error: " . $e->getMessage();
            return false; // Fout bij het invoegen
        }
    }
 
    /**
     * Verwijder een verkooporder
     * @param int $orderId
     * @return bool
     */
    public function deleteVerkooporder(int $orderId) : bool {
        try {
            $sql = "DELETE FROM $this->table_name WHERE orderId = :orderId";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Fout: " . $e->getMessage();
            return false;
        }
    }
 
    /**
     * Update een verkooporder
     * @param int $orderId
     * @param array $data
     * @return bool
     */
    public function updateVerkooporder(int $orderId, array $data) : bool {
        try {
            $sql = "UPDATE $this->table_name SET klantId = :klantId, artId = :artId, verkOrdDatum = :verkOrdDatum, verkOrdBestAantal = :verkOrdBestAantal, verkOrdStatus = :verkOrdStatus WHERE orderId = :orderId";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':klantId', $data['klantId'], PDO::PARAM_INT);
            $stmt->bindParam(':artId', $data['artId'], PDO::PARAM_INT);
            $stmt->bindParam(':verkOrdDatum', $data['verkOrdDatum'], PDO::PARAM_STR);
            $stmt->bindParam(':verkOrdBestAantal', $data['verkOrdBestAantal'], PDO::PARAM_INT);
            $stmt->bindParam(':verkOrdStatus', $data['verkOrdStatus'], PDO::PARAM_STR);
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Fout: " . $e->getMessage();
            return false;
        }
    }
}
?>